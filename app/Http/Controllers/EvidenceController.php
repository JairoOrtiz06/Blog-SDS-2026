<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Evidence;
use App\Models\EvidenceAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;
use Throwable;

class EvidenceController extends Controller
{
    public function index(Request $request)
    {
        $views = config('evidence.views');
        $validated = $request->validate([
            'student' => ['sometimes', 'required', 'string', Rule::in(array_keys($views))],
        ]);
        $selectedView = $validated['student'] ?? 'mine';
        $participantName = $views[$selectedView]['participant_name'];

        $evidences = Evidence::with(['user', 'participant', 'attachments'])
            ->where(function ($query) use ($participantName): void {
                $query->where('participant_name', $participantName)
                    ->orWhereHas('participant', function ($query) use ($participantName): void {
                        $query->where('name', $participantName);
                    });
            })
            ->orderByDesc('evidence_date')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $evidences->getCollection()->each(function (Evidence $evidence): void {
            $mimeType = Storage::disk('local')->mimeType($evidence->file_path);
            $previewType = is_string($mimeType) && Str::startsWith($mimeType, 'image/')
                ? 'image'
                : ($mimeType === 'application/pdf' ? 'pdf' : 'download');

            $evidence->setAttribute('preview_type', $previewType);
            $evidence->attachments->each(function (EvidenceAttachment $attachment): void {
                $attachment->setAttribute('preview_type', 'image');
            });
        });

        return view('evidences.index', [
            'evidences' => $evidences,
            'evidenceViews' => $views,
            'selectedView' => $selectedView,
        ]);
    }

    public function create()
    {
        return view('evidences.create', [
            'students' => config('evidence.students'),
            'activities' => Category::query()->orderBy('name')->pluck('name'),
            'evidence' => new Evidence,
        ]);
    }

    public function edit(Evidence $evidence)
    {
        $evidence->load(['participant', 'attachments']);
        $mimeType = Storage::disk('local')->mimeType($evidence->file_path);
        $evidence->setAttribute(
            'preview_type',
            is_string($mimeType) && Str::startsWith($mimeType, 'image/') ? 'image' : 'download'
        );
        $evidence->attachments->each(function (EvidenceAttachment $attachment): void {
            $attachment->setAttribute('preview_type', 'image');
        });
        $activities = Category::query()->orderBy('name')->pluck('name')->all();
        if ($evidence->activity && ! in_array($evidence->activity, $activities, true)) {
            $activities[] = $evidence->activity;
        }

        return view('evidences.create', [
            'students' => config('evidence.students'),
            'activities' => $activities,
            'evidence' => $evidence,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request, true);
        $additionalFiles = $this->validatedAdditionalFiles($request, 7);
        $file = $validated['file'];
        $evidenceType = $validated['evidence_type'];
        $participantNames = $evidenceType === 'pair'
            ? $validated['participant_names']
            : [$validated['participant_name']];
        unset(
            $validated['file'],
            $validated['evidence_type'],
            $validated['participant_name'],
            $validated['participant_names']
        );

        $storedPaths = [];

        try {
            $path = $file->store('evidencias', 'local');
            if ($path === false) {
                throw new RuntimeException('No fue posible guardar el archivo de evidencia.');
            }

            $storedPaths[] = $path;
            $mainPaths = [$path];
            if ($evidenceType === 'pair') {
                $copyPath = 'evidencias/'.Str::uuid().'.'.$file->extension();
                if (! Storage::disk('local')->copy($path, $copyPath)) {
                    throw new RuntimeException('No fue posible crear la copia de evidencia para el segundo estudiante.');
                }

                $storedPaths[] = $copyPath;
                $mainPaths[] = $copyPath;
            }

            $attachmentPaths = [];
            foreach ($additionalFiles as $additionalFile) {
                $additionalPath = $additionalFile->store('evidencias', 'local');
                if ($additionalPath === false) {
                    throw new RuntimeException('No fue posible guardar una de las fotos adicionales.');
                }

                $storedPaths[] = $additionalPath;
                $paths = [$additionalPath];
                if ($evidenceType === 'pair') {
                    $copyPath = 'evidencias/'.Str::uuid().'.'.$additionalFile->extension();
                    if (! Storage::disk('local')->copy($additionalPath, $copyPath)) {
                        throw new RuntimeException('No fue posible crear la copia de una foto para el segundo estudiante.');
                    }

                    $storedPaths[] = $copyPath;
                    $paths[] = $copyPath;
                }
                $attachmentPaths[] = $paths;
            }

            DB::transaction(function () use ($validated, $evidenceType, $participantNames, $mainPaths, $attachmentPaths, $file, $additionalFiles, $request): void {
                foreach ($participantNames as $index => $participantName) {
                    $evidence = Evidence::create([
                        ...$validated,
                        'evidence_type' => $evidenceType,
                        'participant_name' => $participantName,
                        'participant_id' => null,
                        'file_path' => $mainPaths[$index],
                        'original_filename' => Str::limit($file->getClientOriginalName(), 255, ''),
                        'user_id' => $request->user()->id,
                    ]);

                    $attachmentRecords = [];
                    foreach ($attachmentPaths as $position => $paths) {
                        $attachmentRecords[] = [
                            'path' => $paths[$index],
                            'original_filename' => Str::limit($additionalFiles[$position]->getClientOriginalName(), 255, ''),
                            'position' => $position,
                        ];
                    }
                    $evidence->attachments()->createMany($attachmentRecords);
                }
            });
        } catch (Throwable $exception) {
            $this->deleteStoredFiles($storedPaths, $exception);

            throw $exception;
        }

        return redirect()
            ->route('evidences.index')
            ->with('status', $evidenceType === 'pair'
                ? 'Se registró una evidencia individual para cada estudiante.'
                : 'La evidencia se registró correctamente.');
    }

    public function update(Request $request, Evidence $evidence)
    {
        $validated = $this->validatedData($request, false, $evidence);
        $remainingSlots = max(0, 8 - 1 - $evidence->attachments()->count());
        $additionalFiles = $this->validatedAdditionalFiles($request, $remainingSlots);

        $file = $validated['file'] ?? null;
        unset($validated['file']);
        $validated['participant_id'] = null;

        $oldPath = $evidence->file_path;
        $newPaths = [];

        if ($file) {
            $path = $file->store('evidencias', 'local');
            if ($path === false) {
                throw new RuntimeException('No fue posible guardar el archivo de evidencia.');
            }

            $newPaths[] = $path;
            $validated['file_path'] = $path;
            $validated['original_filename'] = Str::limit($file->getClientOriginalName(), 255, '');
        }

        $attachmentRecords = [];
        try {
            foreach ($additionalFiles as $position => $additionalFile) {
                $path = $additionalFile->store('evidencias', 'local');
                if ($path === false) {
                    throw new RuntimeException('No fue posible guardar una de las fotos adicionales.');
                }

                $newPaths[] = $path;
                $attachmentRecords[] = [
                    'path' => $path,
                    'original_filename' => Str::limit($additionalFile->getClientOriginalName(), 255, ''),
                    'position' => $evidence->attachments()->count() + $position,
                ];
            }

            DB::transaction(function () use ($evidence, $validated, $attachmentRecords): void {
                $evidence->update($validated);
                $evidence->attachments()->createMany($attachmentRecords);
            });
        } catch (Throwable $exception) {
            $this->deleteStoredFiles($newPaths, $exception);

            throw $exception;
        }

        if ($file) {
            $disk = Storage::disk('local');
            if ($disk->exists($oldPath) && ! $disk->delete($oldPath)) {
                throw new RuntimeException('La evidencia se actualizó, pero no fue posible borrar el archivo anterior.');
            }
        }

        return redirect()
            ->route('evidences.index')
            ->with('status', 'La evidencia se actualizó correctamente.');
    }

    public function destroy(Evidence $evidence)
    {
        $disk = Storage::disk('local');
        $paths = [$evidence->file_path, ...$evidence->attachments()->pluck('path')->all()];
        foreach ($paths as $path) {
            if ($disk->exists($path) && ! $disk->delete($path)) {
                throw new RuntimeException('No fue posible borrar todos los archivos de evidencia; el registro se conservó.');
            }
        }

        $evidence->delete();

        return redirect()
            ->route('evidences.index')
            ->with('status', 'La evidencia y su archivo se eliminaron correctamente.');
    }

    private function validatedData(Request $request, bool $fileRequired, ?Evidence $evidence = null): array
    {
        $studentNames = config('evidence.students');
        $activities = Category::query()->pluck('name')->all();
        if ($evidence?->activity && ! in_array($evidence->activity, $activities, true)) {
            $activities[] = $evidence->activity;
        }
        $participantNameRules = ['required', 'string', Rule::in($studentNames)];

        if ($evidence || $request->input('evidence_type', 'individual') === 'individual') {
            return $request->validate([
                'title' => ['required', 'string', 'max:150'],
                'activity' => ['required', 'string', 'max:150', Rule::in($activities)],
                'participant_name' => $participantNameRules,
                'description' => ['nullable', 'string', 'max:5000'],
                'evidence_date' => ['required', 'date'],
                'file' => [$fileRequired ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
                ...($evidence ? [] : ['evidence_type' => ['required', Rule::in(['individual'])]]),
            ], [
                'title.required' => 'El título es obligatorio.',
                'title.max' => 'El título no puede superar los 150 caracteres.',
                'activity.required' => 'La actividad es obligatoria.',
                'activity.max' => 'La actividad no puede superar los 150 caracteres.',
                'activity.in' => 'Selecciona una actividad de la lista.',
                'participant_name.required' => 'Selecciona al estudiante que realizó la actividad.',
                'participant_name.in' => 'Selecciona un estudiante de la lista configurada.',
                'evidence_type.required' => 'Selecciona si la evidencia es individual o en pareja.',
                'description.max' => 'La descripción no puede superar los 5000 caracteres.',
                'evidence_date.required' => 'La fecha de la evidencia es obligatoria.',
                'evidence_date.date' => 'Ingresa una fecha válida.',
                'file.required' => 'Adjunta una imagen JPG/PNG o un documento PDF.',
                'file.uploaded' => 'No se pudo subir el archivo. Verifica que pese menos de 10 MB y vuelve a intentarlo.',
                'file.mimes' => 'El archivo debe ser JPG, PNG o PDF.',
                'file.max' => 'El archivo no puede superar los 10 MB.',
            ]);
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'activity' => ['required', 'string', 'max:150', Rule::in($activities)],
            'evidence_type' => ['required', Rule::in(['pair'])],
            'participant_names' => ['required', 'array', 'size:2'],
            'participant_names.*' => [
                'required',
                'string',
                'distinct',
                Rule::in($studentNames),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'evidence_date' => ['required', 'date'],
            'file' => [$fileRequired ? 'required' : 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 150 caracteres.',
            'activity.required' => 'La actividad es obligatoria.',
            'activity.max' => 'La actividad no puede superar los 150 caracteres.',
            'activity.in' => 'Selecciona una actividad de la lista.',
            'evidence_type.required' => 'Selecciona si la evidencia es individual o en pareja.',
            'participant_names.required' => 'Selecciona a los dos estudiantes de la pareja.',
            'participant_names.size' => 'Para una evidencia en pareja debes seleccionar exactamente dos estudiantes.',
            'participant_names.*.in' => 'Cada integrante debe elegirse de la lista configurada.',
            'participant_names.*.distinct' => 'Selecciona dos estudiantes distintos.',
            'description.max' => 'La descripción no puede superar los 5000 caracteres.',
            'evidence_date.required' => 'La fecha de la evidencia es obligatoria.',
            'evidence_date.date' => 'Ingresa una fecha válida.',
            'file.required' => 'Adjunta una imagen JPG/PNG o un documento PDF.',
            'file.uploaded' => 'No se pudo subir el archivo. Verifica que pese menos de 10 MB y vuelve a intentarlo.',
            'file.mimes' => 'El archivo debe ser JPG, PNG o PDF.',
            'file.max' => 'El archivo no puede superar los 10 MB.',
        ]);
    }

    private function validatedAdditionalFiles(Request $request, int $maximumFiles): array
    {
        return $request->validate([
            'additional_files' => ['nullable', 'array', "max:{$maximumFiles}"],
            'additional_files.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ], [
            'additional_files.max' => "Puedes agregar hasta {$maximumFiles} fotos adicionales; cada evidencia admite un máximo de 8 archivos en total.",
            'additional_files.*.image' => 'Cada archivo adicional debe ser una imagen.',
            'additional_files.*.mimes' => 'Las fotos adicionales deben ser JPG, PNG o WebP.',
            'additional_files.*.max' => 'Cada foto adicional no puede superar los 10 MB.',
        ])['additional_files'] ?? [];
    }

    private function deleteStoredFiles(array $paths, ?Throwable $previous = null): void
    {
        $disk = Storage::disk('local');
        $failedPaths = [];

        foreach ($paths as $path) {
            if ($disk->exists($path) && ! $disk->delete($path)) {
                $failedPaths[] = $path;
            }
        }

        if ($failedPaths !== []) {
            throw new RuntimeException(
                'No fue posible limpiar los archivos: '.implode(', ', $failedPaths),
                previous: $previous
            );
        }
    }

    public function download(Evidence $evidence)
    {
        $disk = Storage::disk('local');

        abort_unless($disk->exists($evidence->file_path), 404);

        return $disk->download($evidence->file_path, $evidence->original_filename);
    }

    public function preview(Evidence $evidence)
    {
        $disk = Storage::disk('local');

        abort_unless($disk->exists($evidence->file_path), 404);

        $mimeType = $disk->mimeType($evidence->file_path);
        abort_unless(
            is_string($mimeType)
                && (Str::startsWith($mimeType, 'image/') || $mimeType === 'application/pdf'),
            415
        );

        $extension = pathinfo($evidence->file_path, PATHINFO_EXTENSION);

        return $disk->response(
            $evidence->file_path,
            "evidence-{$evidence->id}.{$extension}",
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "inline; filename=\"evidence-{$evidence->id}.{$extension}\"",
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    public function attachmentPreview(Evidence $evidence, EvidenceAttachment $attachment)
    {
        abort_unless($attachment->evidence_id === $evidence->id, 404);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($attachment->path), 404);

        $mimeType = $disk->mimeType($attachment->path);
        abort_unless(is_string($mimeType) && Str::startsWith($mimeType, 'image/'), 415);

        $extension = pathinfo($attachment->path, PATHINFO_EXTENSION);

        return $disk->response(
            $attachment->path,
            "evidence-{$evidence->id}-attachment-{$attachment->id}.{$extension}",
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "inline; filename=\"evidence-{$evidence->id}-attachment-{$attachment->id}.{$extension}\"",
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    public function attachmentDownload(Evidence $evidence, EvidenceAttachment $attachment)
    {
        abort_unless($attachment->evidence_id === $evidence->id, 404);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($attachment->path), 404);

        return $disk->download($attachment->path, $attachment->original_filename);
    }
}
