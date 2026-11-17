<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class EvidenceController extends Controller
{
    public function index()
    {
        $evidences = Evidence::with('user')
            ->orderByDesc('evidence_date')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('evidences.index', compact('evidences'));
    }

    public function create()
    {
        return view('evidences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'activity' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:5000'],
            'evidence_date' => ['required', 'date'],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 150 caracteres.',
            'activity.required' => 'La actividad es obligatoria.',
            'activity.max' => 'La actividad no puede superar los 150 caracteres.',
            'description.max' => 'La descripción no puede superar los 5000 caracteres.',
            'evidence_date.required' => 'La fecha de la evidencia es obligatoria.',
            'evidence_date.date' => 'Ingresa una fecha válida.',
            'file.required' => 'Adjunta una imagen JPG/PNG o un documento PDF.',
            'file.uploaded' => 'No se pudo subir el archivo. Verifica que pese menos de 10 MB y vuelve a intentarlo.',
            'file.mimes' => 'El archivo debe ser JPG, PNG o PDF.',
            'file.max' => 'El archivo no puede superar los 10 MB.',
        ]);

        $file = $validated['file'];
        unset($validated['file']);

        $path = $file->store('evidencias', 'local');

        if ($path === false) {
            throw new RuntimeException('No fue posible guardar el archivo de evidencia.');
        }

        Evidence::create([
            ...$validated,
            'file_path' => $path,
            'original_filename' => Str::limit($file->getClientOriginalName(), 255, ''),
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('evidences.index')
            ->with('status', 'La evidencia se registró correctamente.');
    }

    public function download(Evidence $evidence)
    {
        $disk = Storage::disk('local');

        abort_unless($disk->exists($evidence->file_path), 404);

        return $disk->download($evidence->file_path, $evidence->original_filename);
    }
}
