<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::query()
            ->with('images')
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('admin.publications.form', [
            'publication' => new Publication,
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
        return view('admin.publications.form', compact('publication'));
    }

    public function update(Request $request, Publication $publication)
    {
        $validated = $this->validatedData($request);
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

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string', 'max:50000'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'images' => ['nullable', 'array', 'max:2'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'excerpt.max' => 'El resumen no puede superar los 1000 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'content.max' => 'El contenido no puede superar los 50000 caracteres.',
            'category.max' => 'La categoría no puede superar los 100 caracteres.',
            'status.required' => 'Selecciona si guardar como borrador o publicar.',
            'status.in' => 'El estado seleccionado no es válido.',
            'published_at.date' => 'Ingresa una fecha de publicación válida.',
            'images.max' => 'Puedes adjuntar hasta 2 imágenes por publicación.',
            'images.*.image' => 'Cada archivo de portada debe ser una imagen.',
            'images.*.uploaded' => 'No se pudo subir una imagen. Verifica que pese menos de 5 MB y vuelve a intentarlo.',
            'images.*.mimes' => 'Las imágenes deben ser JPG, PNG o WebP.',
            'images.*.max' => 'Cada imagen de portada no puede superar los 5 MB.',
        ]);
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
