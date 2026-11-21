<?php

namespace Tests\Feature;

use App\Models\Category;
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
        $matching = $matching = $this->createPublication(
            'Sensores IoT conectados',
            category: 'Tecnología'
        );
        $this->createPublication(
            'Conservación forestal',
            category: 'Sostenibilidad'
        );

        $query = http_build_query([
            'q' => 'IoT',
            'category' => $matching->category_id,
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
            ->assertSee($visible->content)
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('<meta property="og:title" content="Artículo público">', false)
            ->assertSee('<meta property="og:description" content="Resumen: Artículo público">', false)
            ->assertSee('global-back-button', false)
            ->assertSee('>Regresar</a>', false)
            ->assertSee('Fecha de actividad: 17/11/2026');

        $this->get("/publicaciones/{$draft->slug}")
            ->assertNotFound();
    }

    public function test_public_home_and_listing_have_share_metadata(): void
    {
        $imageUrl = asset('images/logo-sds-green-iot.png');

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta property="og:type" content="website">', false)
            ->assertSee('<meta property="og:image" content="'.$imageUrl.'">', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false);

        $this->get('/publicaciones')
            ->assertOk()
            ->assertSee('<meta property="og:title" content="Publicaciones SDS 2026">', false)
            ->assertSee('<meta property="og:image" content="'.$imageUrl.'">', false);
    }

    public function test_publication_share_metadata_uses_its_cover_image(): void
    {
        Storage::fake('public');
        $publication = $this->createPublication('Artículo para compartir');
        $publication->images()->create([
            'path' => 'publications/share.png',
            'original_filename' => 'share.png',
            'position' => 0,
        ]);
        $imageUrl = url(Storage::disk('public')->url('publications/share.png'));

        $this->get("/publicaciones/{$publication->slug}")
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.$imageUrl.'">', false)
            ->assertSee('<meta name="twitter:image" content="'.$imageUrl.'">', false)
            ->assertSee('<link rel="canonical" href="'.route('blog.show', $publication->slug).'">', false);
    }

    public function test_public_detail_recommends_up_to_three_other_visible_publications(): void
    {
        $current = $this->createPublication('Publicación actual');
        $firstRelated = $this->createPublication(
            'Recomendada reciente',
            activityDate: Carbon::parse('2026-11-16')
        );
        $secondRelated = $this->createPublication(
            'Recomendada anterior',
            activityDate: Carbon::parse('2026-11-15')
        );
        $thirdRelated = $this->createPublication(
            'Tercera recomendada',
            activityDate: Carbon::parse('2026-11-14')
        );
        $this->createPublication(
            'No debe aparecer en recomendaciones',
            activityDate: Carbon::parse('2026-11-13')
        );
        $this->createPublication('Borrador no recomendado', status: 'draft');
        $this->createPublication('Programada no recomendada', publishedAt: now()->addDay());

        $response = $this->get("/publicaciones/{$current->slug}")
            ->assertOk()
            ->assertSee('publication-layout', false)
            ->assertSee('<aside class="related-publications"', false)
            ->assertSee('También te puede interesar')
            ->assertSeeInOrder([
                $firstRelated->title,
                $secondRelated->title,
                $thirdRelated->title,
            ])
            ->assertDontSee('No debe aparecer en recomendaciones')
            ->assertDontSee('Borrador no recomendado')
            ->assertDontSee('Programada no recomendada');

        $this->assertSame(
            3,
            substr_count($response->getContent(), 'class="related-publication-card"')
        );
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
        $publication->images()->create([
            'path' => 'publications/diagram.png',
            'original_filename' => 'diagram.png',
            'position' => 1,
        ]);
        $imageUrl = Storage::disk('public')->url('publications/sensor.png');
        $secondImageUrl = Storage::disk('public')->url('publications/diagram.png');

        $this->get('/publicaciones')
            ->assertOk()
            ->assertSee("data-image-src=\"{$imageUrl}\"", false)
            ->assertSee('aria-label="Vista ampliada de la imagen"', false);

        $this->get("/publicaciones/{$publication->slug}")
            ->assertOk()
            ->assertSee("data-image-src=\"{$imageUrl}\"", false)
            ->assertSee("data-image-src=\"{$secondImageUrl}\"", false)
            ->assertSee('1 de 2')
            ->assertSee('Anterior')
            ->assertSee('Siguiente')
            ->assertDontSee('‹')
            ->assertDontSee('›')
            ->assertSee('data-gallery-thumbnail', false)
            ->assertSee('aria-label="Imagen anterior"', false)
            ->assertSee('aria-label="Imagen siguiente"', false);
    }

    public function test_public_listing_orders_by_activity_date(): void
    {
        $older = $this->createPublication(
            'Actividad anterior',
            activityDate: Carbon::parse('2026-11-15')
        );
        $newer = $this->createPublication(
            'Actividad reciente',
            activityDate: Carbon::parse('2026-11-17')
        );

        $this->get('/publicaciones')
            ->assertOk()
            ->assertSeeInOrder([$newer->title, $older->title]);
    }

    private function createPublication(
        string $title,
        string $category = 'IoT',
        string $status = 'published',
        ?Carbon $publishedAt = null,
        ?Carbon $activityDate = null
    ): Publication {
        $category = Category::firstOrCreate(['name' => $category]);

        return Publication::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => "Resumen: {$title}",
            'content' => "Contenido de {$title}",
            'category_id' => $category->id,
            'activity_date' => $activityDate ?? Carbon::parse('2026-11-17'),
            'status' => $status,
            'published_at' => $publishedAt,
        ]);
    }
}
