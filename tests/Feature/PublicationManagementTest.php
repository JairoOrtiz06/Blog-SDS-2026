<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_a_draft_and_publish_content(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/publicaciones/create')
            ->assertOk()
            ->assertSee('Nueva publicación');

        $this->actingAs($admin)
            ->post('/admin/publicaciones', [
                'title' => 'Internet de las Cosas',
                'excerpt' => 'Una introducción al IoT.',
                'content' => 'Contenido sobre dispositivos conectados.',
                'category' => 'IoT',
                'status' => 'draft',
                'images' => [
                    UploadedFile::fake()->image('portada.png'),
                    UploadedFile::fake()->image('diagrama.png'),
                ],
            ])
            ->assertRedirect(route('publications.index'));

        $draft = Publication::where('title', 'Internet de las Cosas')->firstOrFail();
        $this->assertSame('internet-de-las-cosas', $draft->slug);
        $this->assertNull($draft->published_at);
        $this->assertCount(2, $draft->images);
        Storage::disk('public')->assertExists($draft->images[0]->path);
        Storage::disk('public')->assertExists($draft->images[1]->path);

        $this->actingAs($admin)
            ->get("/admin/publicaciones/{$draft->id}/edit")
            ->assertOk()
            ->assertSee('Editar publicación')
            ->assertSee($draft->title);

        $this->get('/publicaciones')
            ->assertDontSee($draft->title);

        $this->actingAs($admin)
            ->post('/admin/publicaciones', [
                'title' => 'Internet de las Cosas',
                'content' => 'La publicación ya está lista.',
                'category' => 'IoT',
                'status' => 'published',
            ])
            ->assertRedirect(route('publications.index'));

        $published = Publication::where('status', 'published')->firstOrFail();
        $this->assertSame('internet-de-las-cosas-2', $published->slug);
        $this->assertNotNull($published->published_at);

        $this->actingAs($admin)
            ->get('/admin/publicaciones')
            ->assertOk()
            ->assertSee($published->title);

        $this->get('/publicaciones')
            ->assertSee($published->title);
    }

    public function test_admin_can_publish_an_existing_draft(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $draft = Publication::create([
            'title' => 'Borrador IoT',
            'slug' => 'borrador-iot',
            'content' => 'Contenido listo para publicar.',
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->put("/admin/publicaciones/{$draft->id}", [
                'title' => $draft->title,
                'content' => $draft->content,
                'status' => 'published',
            ])
            ->assertRedirect(route('publications.index'));

        $draft->refresh();
        $this->assertSame('published', $draft->status);
        $this->assertNotNull($draft->published_at);

        $this->get("/publicaciones/{$draft->slug}")
            ->assertOk()
            ->assertSee($draft->title);
    }

    public function test_normal_user_cannot_manage_publications(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/publicaciones')
            ->assertForbidden();

        $this->actingAs($user)
            ->post('/admin/publicaciones', [])
            ->assertForbidden();
    }

    public function test_publication_cover_rejects_non_image_files(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from('/admin/publicaciones/create')
            ->post('/admin/publicaciones', [
                'title' => 'Publicación',
                'content' => 'Contenido.',
                'status' => 'draft',
                'images' => [
                    UploadedFile::fake()->create('archivo.pdf', 100, 'application/pdf'),
                ],
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('images.0');

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_a_publication_can_display_two_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/publicaciones', [
                'title' => 'Sensores para Green IoT',
                'content' => 'Detalles de los sensores.',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('sensor-a.png'),
                    UploadedFile::fake()->image('sensor-b.png'),
                ],
            ])
            ->assertRedirect(route('publications.index'));

        $publication = Publication::where('title', 'Sensores para Green IoT')->firstOrFail();
        $this->assertCount(2, $publication->images);

        $this->get("/publicaciones/{$publication->slug}")
            ->assertOk()
            ->assertSee('sensor-a.png')
            ->assertSee('sensor-b.png');
    }

    public function test_publication_rejects_more_than_two_images(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from('/admin/publicaciones/create')
            ->post('/admin/publicaciones', [
                'title' => 'Galería',
                'content' => 'Contenido.',
                'status' => 'draft',
                'images' => [
                    UploadedFile::fake()->image('uno.png'),
                    UploadedFile::fake()->image('dos.png'),
                    UploadedFile::fake()->image('tres.png'),
                ],
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('images');

        $this->assertDatabaseCount('publications', 0);
    }
}
