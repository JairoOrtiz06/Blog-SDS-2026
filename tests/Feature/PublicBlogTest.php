<?php

namespace Tests\Feature;

use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_listing_hides_drafts_and_future_publications(): void
    {
        $visible = $this->createPublication('Publicación visible');
        $this->createPublication('Borrador interno', status: 'draft');
        $this->createPublication('Publicación programada', publishedAt: now()->addDay());

        $this->get('/publicaciones')
            ->assertOk()
            ->assertSee($visible->title)
            ->assertDontSee('Borrador interno')
            ->assertDontSee('Publicación programada');
    }

    public function test_search_and_category_filters_narrow_the_public_listing(): void
    {
        $matching = $this->createPublication(
            'Sensores IoT conectados',
            category: 'Tecnología'
        );
        $this->createPublication(
            'Conservación forestal',
            category: 'Sostenibilidad'
        );

        $query = http_build_query([
            'q' => 'IoT',
            'category' => 'Tecnología',
        ]);

        $this->get("/publicaciones?{$query}")
            ->assertOk()
            ->assertSee($matching->title)
            ->assertDontSee('Conservación forestal');
    }

    public function test_public_detail_is_available_only_for_visible_publications(): void
    {
        $visible = $this->createPublication('Artículo público');
        $draft = $this->createPublication('Artículo privado', status: 'draft');

        $this->get("/publicaciones/{$visible->slug}")
            ->assertOk()
            ->assertSee($visible->content);

        $this->get("/publicaciones/{$draft->slug}")
            ->assertNotFound();
    }

    public function test_publication_images_can_be_opened_in_a_large_preview(): void
    {
        Storage::fake('public');
        $publication = $this->createPublication('Galería de sensores');
        $publication->images()->create([
            'path' => 'publications/sensor.png',
            'original_filename' => 'sensor.png',
            'position' => 0,
        ]);
        $imageUrl = Storage::disk('public')->url('publications/sensor.png');

        $this->get('/publicaciones')
            ->assertOk()
            ->assertSee("data-image-src=\"{$imageUrl}\"", false)
            ->assertSee('aria-label="Vista ampliada de la imagen"', false);

        $this->get("/publicaciones/{$publication->slug}")
            ->assertOk()
            ->assertSee("data-image-src=\"{$imageUrl}\"", false);
    }

    private function createPublication(
        string $title,
        string $category = 'IoT',
        string $status = 'published',
        ?Carbon $publishedAt = null
    ): Publication {
        return Publication::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => "Resumen: {$title}",
            'content' => "Contenido de {$title}",
            'category' => $category,
            'status' => $status,
            'published_at' => $publishedAt,
        ]);
    }
}
