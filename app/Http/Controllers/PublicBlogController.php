<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Publication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
        ], [
            'q.max' => 'La búsqueda no puede superar los 100 caracteres.',
            'category.exists' => 'La categoría seleccionada no existe.',
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
            $publicationsQuery->where('category_id', $filters['category']);
        }

        $publications = $publicationsQuery
            ->with(['images', 'category'])
            ->orderByRaw('COALESCE(activity_date, published_at) DESC')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()
            ->whereHas('publications', fn (Builder $query) => $query->publiclyVisible())
            ->orderBy('name')
            ->get();

        return view('blog.index', compact('publications', 'categories', 'filters'));
    }

    public function show(string $slug)
    {
        $publication = Publication::publiclyVisible()
            ->with(['images', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedQuery = Publication::publiclyVisible()
            ->where('id', '!=', $publication->id);

        if ($publication->category_id !== null) {
            $relatedQuery->orderByRaw(
                'CASE WHEN category_id = ? THEN 0 ELSE 1 END',
                [$publication->category_id]
            );
        }

        $relatedPublications = $relatedQuery
            ->with(['images', 'category'])
            ->orderByRaw('COALESCE(activity_date, published_at) DESC')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('publication', 'relatedPublications'));
    }
}
