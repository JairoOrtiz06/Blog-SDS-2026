<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
        ], [
            'q.max' => 'La búsqueda no puede superar los 100 caracteres.',
            'category.max' => 'La categoría no puede superar los 100 caracteres.',
        ]);

        $publicationsQuery = Publication::publiclyVisible();

        if (! empty($filters['q'])) {
            $search = trim($filters['q']);

            $publicationsQuery->where(function (Builder $query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['category'])) {
            $publicationsQuery->where('category', $filters['category']);
        }

        $publications = $publicationsQuery
            ->with('images')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Publication::publiclyVisible()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('blog.index', compact('publications', 'categories', 'filters'));
    }

    public function show(string $slug)
    {
        $publication = Publication::publiclyVisible()
            ->with('images')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', compact('publication'));
    }
}
