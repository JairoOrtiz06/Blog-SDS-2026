<?php

namespace Tests\Feature;

use App\Models\Category;
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
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/admin/publicaciones/create')
            ->assertOk()
            ->assertSee('Nueva publicación')
            ->assertSee('Feria de proyectos')
            ->assertSee('id="activity-guidance"', false)
            ->assertSee('Se requiere al menos una imagen para publicar.');

        $this->actingAs($admin)
            ->post('/admin/publicaciones', [
                'title' => 'Internet de las Cosas',
                'excerpt' => 'Una introducción al IoT.',
                'content' => 'Contenido sobre dispositivos conectados.',
                'category_id' => $this->categoryId('IoT'),
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
                'authors' => 'María Pérez, Juan López',
                'content' => 'La publicación ya está lista.',
                'category_id' => $this->categoryId('IoT'),
                'activity_date' => '2026-11-17',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('evidencia.png'),
                ],
            ])
            ->assertRedirect(route('publications.index'));

        $published = Publication::where('status', 'published')->firstOrFail();
        $this->assertSame('internet-de-las-cosas-2', $published->slug);
        $this->assertSame('María Pérez, Juan López', $published->authors);
        $this->assertNotNull($published->published_at);

        $this->actingAs($admin)
            ->get("/admin/publicaciones/{$published->id}/edit")
            ->assertOk()
            ->assertSee('value="María Pérez, Juan López"', false);

        $this->actingAs($admin)
            ->get('/admin/publicaciones')
            ->assertOk()
            ->assertSee($published->title);

        $this->get('/publicaciones')
            ->assertSee($published->title);

        $this->get("/publicaciones/{$published->slug}")
            ->assertSee('Autor(es):')
            ->assertSee($published->authors);
    }

    public function test_admin_can_publish_an_existing_draft(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $draft = Publication::create([
            'title' => 'Borrador IoT',
            'slug' => 'borrador-iot',
            'content' => 'Contenido listo para publicar.',
            'status' => 'draft',
        ]);
        $imagePath = UploadedFile::fake()->image('evidencia.png')->store('publications', 'public');
        $draft->images()->create([
            'path' => $imagePath,
            'original_filename' => 'evidencia.png',
            'position' => 0,
        ]);

        $this->actingAs($admin)
            ->put("/admin/publicaciones/{$draft->id}", [
                'title' => $draft->title,
                'authors' => 'Ana Gómez',
                'content' => $draft->content,
                'category_id' => $this->categoryId('Ponencia'),
                'activity_date' => '2026-11-16',
                'status' => 'published',
            ])
            ->assertRedirect(route('publications.index'));

        $draft->refresh();
        $this->assertSame('published', $draft->status);
        $this->assertSame('Ana Gómez', $draft->authors);
        $this->assertNotNull($draft->published_at);

        $this->get("/publicaciones/{$draft->slug}")
            ->assertOk()
            ->assertSee($draft->title)
            ->assertSee('Ana Gómez');
    }

    public function test_admin_can_replace_a_publication_gallery_with_multiple_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $publication = Publication::create([
            'title' => 'Galería anterior',
            'slug' => 'galeria-anterior',
            'content' => 'Contenido de la publicación.',
            'status' => 'draft',
        ]);
        $oldPath = UploadedFile::fake()->image('anterior.png')->store('publications', 'public');
        $publication->images()->create([
            'path' => $oldPath,
            'original_filename' => 'anterior.png',
            'position' => 0,
        ]);

        $this->actingAs($admin)
            ->put("/admin/publicaciones/{$publication->id}", [
                'title' => 'Galería actualizada',
                'content' => 'Contenido actualizado.',
                'status' => 'draft',
                'images' => [
                    UploadedFile::fake()->image('foto-uno.png'),
                    UploadedFile::fake()->image('foto-dos.png'),
                ],
            ])
            ->assertRedirect(route('publications.index'));

        $publication->refresh();
        $this->assertSame('Galería actualizada', $publication->title);
        $this->assertCount(2, $publication->images);
        $this->assertSame(
            ['foto-uno.png', 'foto-dos.png'],
            $publication->images->pluck('original_filename')->all()
        );
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($publication->images[0]->path);
        Storage::disk('public')->assertExists($publication->images[1]->path);
    }

    public function test_publishing_requires_at_least_one_author(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from('/admin/publicaciones/create')
            ->post('/admin/publicaciones', [
                'title' => 'Publicación sin autoría',
                'content' => 'Contenido.',
                'category_id' => $this->categoryId('Ponencia'),
                'activity_date' => '2026-11-17',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('evidencia.png'),
                ],
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('authors');

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_publishing_requires_at_least_one_evidence_image(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from('/admin/publicaciones/create')
            ->post('/admin/publicaciones', [
                'title' => 'Taller de sensores',
                'authors' => 'Equipo Green IoT',
                'content' => 'Se realizó la actividad y aprendimos sobre sensores.',
                'category_id' => $this->categoryId('Talleres'),
                'activity_date' => '2026-11-17',
                'status' => 'published',
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('images');

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_published_activity_requires_a_name(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from('/admin/publicaciones/create')
            ->post('/admin/publicaciones', [
                'title' => 'Actividad sin tipo',
                'authors' => 'Equipo Green IoT',
                'content' => 'Descripción y reflexión de la actividad.',
                'activity_date' => '2026-11-17',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('evidencia.png'),
                ],
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('publications', 0);
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
        $admin = User::factory()->create(['is_admin' => true]);

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

    public function test_a_publication_can_display_eight_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post('/admin/publicaciones', [
                'title' => 'Sensores para Green IoT',
                'authors' => 'Equipo Green IoT',
                'content' => 'Detalles de los sensores.',
                'category_id' => $this->categoryId('Talleres'),
                'activity_date' => '2026-11-17',
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('sensor-a.png'),
                    UploadedFile::fake()->image('sensor-b.png'),
                    UploadedFile::fake()->image('sensor-c.png'),
                    UploadedFile::fake()->image('sensor-d.png'),
                    UploadedFile::fake()->image('sensor-e.png'),
                    UploadedFile::fake()->image('sensor-f.png'),
                    UploadedFile::fake()->image('sensor-g.png'),
                    UploadedFile::fake()->image('sensor-h.png'),
                ],
            ])
            ->assertRedirect(route('publications.index'));

        $publication = Publication::where('title', 'Sensores para Green IoT')->firstOrFail();
        $this->assertCount(8, $publication->images);

        $response = $this->get("/publicaciones/{$publication->slug}")
            ->assertOk()
            ->assertSee('data-image-gallery="publication"', false)
            ->assertSee('1 de 8')
            ->assertSee('aria-label="Imagen siguiente"', false);

        $this->assertSame(8, substr_count($response->getContent(), 'class="gallery-thumbnail"'));

        foreach (['sensor-a.png', 'sensor-b.png', 'sensor-c.png', 'sensor-d.png', 'sensor-e.png', 'sensor-f.png', 'sensor-g.png', 'sensor-h.png'] as $filename) {
            $response->assertSee($filename);
        }
    }

    public function test_publication_rejects_more_than_eight_images(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

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
                    UploadedFile::fake()->image('cuatro.png'),
                    UploadedFile::fake()->image('cinco.png'),
                    UploadedFile::fake()->image('seis.png'),
                    UploadedFile::fake()->image('siete.png'),
                    UploadedFile::fake()->image('ocho.png'),
                    UploadedFile::fake()->image('nueve.png'),
                ],
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('images');

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_publishing_requires_an_activity_date(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from('/admin/publicaciones/create')
            ->post('/admin/publicaciones', [
                'title' => 'Actividad sin fecha',
                'authors' => 'Equipo Green IoT',
                'content' => 'Contenido real de la actividad.',
                'category_id' => $this->categoryId('Talleres'),
                'status' => 'published',
                'images' => [
                    UploadedFile::fake()->image('evidencia.png'),
                ],
            ])
            ->assertRedirect('/admin/publicaciones/create')
            ->assertSessionHasErrors('activity_date');

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_admin_can_delete_a_publication_and_its_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $publication = Publication::create([
            'title' => 'Publicación para eliminar',
            'slug' => 'publicacion-para-eliminar',
            'content' => 'Contenido de prueba.',
            'status' => 'draft',
        ]);
        $path = UploadedFile::fake()->image('portada.png')->store('publications', 'public');
        $publication->images()->create([
            'path' => $path,
            'original_filename' => 'portada.png',
            'position' => 0,
        ]);

        $this->actingAs($admin)
            ->delete("/admin/publicaciones/{$publication->id}")
            ->assertRedirect(route('publications.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('publications', ['id' => $publication->id]);
        $this->assertDatabaseMissing('publication_images', ['publication_id' => $publication->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_normal_user_cannot_delete_a_publication(): void
    {
        $user = User::factory()->create();
        $publication = Publication::create([
            'title' => 'Publicación protegida',
            'slug' => 'publicacion-protegida',
            'content' => 'Contenido de prueba.',
            'status' => 'draft',
        ]);

        $this->actingAs($user)
            ->delete("/admin/publicaciones/{$publication->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('publications', ['id' => $publication->id]);
    }

    private function categoryId(string $name): int
    {
        return Category::firstOrCreate(['name' => $name])->id;
    }
}
