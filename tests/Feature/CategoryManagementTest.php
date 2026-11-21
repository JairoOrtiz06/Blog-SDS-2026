<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_categories(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/admin/categorias')
            ->assertOk()
            ->assertSee('>Regresar</a>', false)
            ->assertSee('Categorías')
            ->assertSee('Feria de proyectos');
        $this->get('/admin/categorias/create')->assertOk();

        $this->actingAs($admin)
            ->post('/admin/categorias', ['name' => '  Conferencias  '])
            ->assertRedirect(route('categories.index'));

        $category = Category::where('name', 'Conferencias')->firstOrFail();

        $this->get("/admin/categorias/{$category->id}/edit")
            ->assertOk()
            ->assertSee('Conferencias');

        $this->actingAs($admin)
            ->put("/admin/categorias/{$category->id}", ['name' => 'Charlas'])
            ->assertRedirect(route('categories.index'));

        $category->refresh();
        $this->assertSame('Charlas', $category->name);

        $this->actingAs($admin)
            ->delete("/admin/categorias/{$category->id}")
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_category_in_use_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create(['name' => 'Taller especial']);
        Publication::create([
            'title' => 'Publicación vinculada',
            'slug' => Str::slug('Publicación vinculada'),
            'content' => 'Contenido de prueba.',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->from('/admin/categorias')
            ->delete("/admin/categorias/{$category->id}")
            ->assertRedirect('/admin/categorias')
            ->assertSessionHasErrors('category');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_normal_user_cannot_manage_categories(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/categorias')
            ->assertForbidden();

        $this->actingAs($user)
            ->post('/admin/categorias', ['name' => 'No autorizada'])
            ->assertForbidden();
    }

    public function test_category_names_must_be_unique(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Category::create(['name' => 'Categoría personalizada']);

        $this->actingAs($admin)
            ->from('/admin/categorias/create')
            ->post('/admin/categorias', ['name' => 'Categoría personalizada'])
            ->assertRedirect('/admin/categorias/create')
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 8);
    }
}
