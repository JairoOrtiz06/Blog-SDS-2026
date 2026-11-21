<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Patrocinadores de la SDS')
            ->assertSee('global-site-header', false)
            ->assertSee('>Inicio</a>', false)
            ->assertSee('Patrocinadores')
            ->assertSee('Publicaciones')
            ->assertDontSee('Crear cuenta')
            ->assertSee('Iniciar sesión')
            ->assertSee('images/logo-sds-green-iot.png')
            ->assertSee('<video', false)
            ->assertSee('Reproducir video de los patrocinadores')
            ->assertSee('videos/patrocinadores-sds.mp4')
            ->assertSee('images/patrocinadores-poster.svg');
    }
}
