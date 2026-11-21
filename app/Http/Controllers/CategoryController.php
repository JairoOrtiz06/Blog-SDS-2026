<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->withCount('publications')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', [
            'category' => new Category,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);
        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('status', 'La categoría se creó correctamente.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validatedData($request, $category));

        return redirect()
            ->route('categories.index')
            ->with('status', 'La categoría se actualizó correctamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->publications()->exists()) {
            return back()->withErrors([
                'category' => 'No puedes eliminar una categoría que tiene publicaciones asignadas.',
            ]);
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('status', 'La categoría se eliminó correctamente.');
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($category?->id),
            ],
        ], [
            'name.required' => 'Escribe el nombre de la categoría.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',
            'name.unique' => 'Ya existe una categoría con ese nombre.',
        ]);
    }
}
