<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Publication;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::query()
            ->with(['images', 'category'])
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('admin.publications.form', [
            'publication' => new Publication,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);
        $images = $validated['images'] ?? [];
        unset($validated['images']);

        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['published_at'] = $this->publicationDate($validated);

        $publication = Publication::create($validated);
        $publication->images()->createMany($this->storeImages($images));

        return redirect()
            ->route('publications.index')
            ->with('status', 'La publicación se guardó correctamente.');
    }

    public function edit(Publication $publication)
    {
        return view('admin.publications.form', [
            'publication' => $publication,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Publication $publication)
    {
        $validated = $this->validatedData($request, $publication);
        $images = $validated['images'] ?? [];
        unset($validated['images']);

        $validated['slug'] = $this->uniqueSlug($validated['title'], $publication->id);
        $validated['published_at'] = $this->publicationDate($validated);

        if ($images === []) {
            $publication->update($validated);
        } else {
            $oldImagePaths = $publication->images()->pluck('path')->all();
            if ($publication->image_path) {
                $oldImagePaths[] = $publication->image_path;
            }

            $newImages = $this->storeImages($images);
            $publication->update([...$validated, 'image_path' => null]);
            $publication->images()->delete();
            $publication->images()->createMany($newImages);

            $disk = Storage::disk('public');
            foreach (array_unique($oldImagePaths) as $path) {
                if ($disk->exists($path) && ! $disk->delete($path)) {
                    throw new RuntimeException('No fue posible reemplazar una imagen anterior.');
                }
            }
        }

        return redirect()
            ->route('publications.index')
            ->with('status', 'La publicación se actualizó correctamente.');
    }

    public function destroy(Publication $publication)
    {
        $imagePaths = $publication->images()->pluck('path')->all();
        if ($publication->image_path) {
            $imagePaths[] = $publication->image_path;
        }

        $publication->delete();

        $disk = Storage::disk('public');
        foreach (array_unique($imagePaths) as $path) {
            if ($disk->exists($path) && ! $disk->delete($path)) {
                throw new RuntimeException('La publicación se eliminó, pero no fue posible borrar una imagen asociada.');
            }
        }

        return redirect()
            ->route('publications.index')
            ->with('status', 'La publicación y sus imágenes se eliminaron correctamente.');
    }

    private function validatedData(Request $request, ?Publication $publication = null): array
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'authors' => ['required_if:status,published', 'nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string', 'max:50000'],
            'category_id' => ['required_if:status,published', 'nullable', 'integer', 'exists:categories,id'],
            'activity_date' => ['required_if:status,published', 'nullable', 'date'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'authors.required_if' => 'Indica el autor o los autores para publicar.',
            'authors.max' => 'Los autores no pueden superar los 500 caracteres.',
            'excerpt.max' => 'El resumen no puede superar los 1000 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'content.max' => 'El contenido no puede superar los 50000 caracteres.',
            'category_id.required_if' => 'Selecciona la categoría o actividad para publicar.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'activity_date.required_if' => 'Indica la fecha en que se realizó la actividad.',
            'activity_date.date' => 'Ingresa una fecha de actividad válida.',
            'status.required' => 'Selecciona si guardar como borrador o publicar.',
            'status.in' => 'El estado seleccionado no es válido.',
            'published_at.date' => 'Ingresa una fecha de publicación válida.',
            'images.max' => 'Puedes adjuntar hasta 8 imágenes por publicación.',
            'images.*.image' => 'Cada archivo de portada debe ser una imagen.',
            'images.*.uploaded' => 'No se pudo subir una imagen. Verifica que pese menos de 5 MB y vuelve a intentarlo.',
            'images.*.mimes' => 'Las imágenes deben ser JPG, PNG o WebP.',
            'images.*.max' => 'Cada imagen de portada no puede superar los 5 MB.',
        ]);

        $validator->after(function ($validator) use ($request, $publication): void {
            $hasExistingEvidence = $publication
                && ($publication->image_path || $publication->images()->exists());

            if (
                $request->input('status') === 'published'
                && empty($request->file('images'))
                && ! $hasExistingEvidence
            ) {
                $validator->errors()->add('images', 'Adjunta al menos una imagen de evidencia para publicar.');
            }
        });

        return $validator->validate();
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'publicacion';
        $slug = $base;
        $suffix = 2;

        while (Publication::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    private function publicationDate(array $validated): string|DateTimeInterface|null
    {
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            return now();
        }

        return $validated['published_at'] ?? null;
    }

    private function storeImages(array $images): array
    {
        $records = [];
        foreach ($images as $position => $image) {
            if (! $image instanceof UploadedFile) {
                throw new RuntimeException('Una de las imágenes recibidas no es válida.');
            }

            $path = $image->store('publications', 'public');
            if ($path === false) {
                throw new RuntimeException('No fue posible guardar una imagen de portada.');
            }

            $records[] = [
                'path' => $path,
                'original_filename' => Str::limit($image->getClientOriginalName(), 255, ''),
                'position' => $position,
            ];
        }

        return $records;
    }
}
