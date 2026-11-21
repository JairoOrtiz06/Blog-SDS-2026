<?php

namespace Tests\Feature;

use App\Models\Evidence;
use App\Models\Publication;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register')->assertNotFound();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_non_admin_accounts_cannot_sign_in(): void
    {
        User::factory()->create([
            'email' => 'estudiante@example.com',
            'password' => 'secure-password',
        ]);

        $this->from('/login')->post('/login', [
            'email' => 'estudiante@example.com',
            'password' => 'secure-password',
        ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_sign_in(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'secure-password',
            'is_admin' => true,
        ]);

        $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'secure-password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    public function test_database_seeder_creates_an_admin_from_configured_credentials(): void
    {
        config([
            'admin.name' => 'Admin de prueba',
            'admin.email' => 'admin-seed@example.com',
            'admin.password' => 'test-password-123',
        ]);

        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'admin-seed@example.com')->firstOrFail();
        $this->assertTrue($admin->is_admin);
        $this->assertSame('Admin de prueba', $admin->name);
        $this->assertTrue(Hash::check('test-password-123', $admin->password));
    }

    public function test_normal_accounts_cannot_access_the_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertForbidden();
    }

    public function test_admin_accounts_can_access_the_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Publication::create([
            'title' => 'Artículo público',
            'slug' => 'articulo-publico',
            'content' => 'Contenido público.',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);
        Publication::create([
            'title' => 'Borrador interno',
            'slug' => 'borrador-interno',
            'content' => 'Contenido en preparación.',
            'status' => 'draft',
        ]);
        Publication::create([
            'title' => 'Artículo programado',
            'slug' => 'articulo-programado',
            'content' => 'Contenido futuro.',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);
        Evidence::create([
            'title' => 'Evidencia de prueba',
            'activity' => 'Ponencia',
            'evidence_date' => now()->toDateString(),
            'file_path' => 'evidencias/prueba.pdf',
            'original_filename' => 'prueba.pdf',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('global-site-header', false)
            ->assertSee('Patrocinadores')
            ->assertSee('Publicaciones')
            ->assertSee('Panel administrativo')
            ->assertSee('Categorías')
            ->assertDontSee('Equipos')
            ->assertSee('Evidencias')
            ->assertSee('Cerrar sesión')
            ->assertSee('Herramientas de administración')
            ->assertSee('Nueva publicación')
            ->assertSee('Administrar publicaciones')
            ->assertSee('Administrar evidencias')
            ->assertDontSee('M5 12h14m-6-6 6 6-6 6')
            ->assertSee($admin->name)
            ->assertSee('data-stat="publications">3', false)
            ->assertSee('data-stat="published">1', false)
            ->assertSee('data-stat="drafts">1', false)
            ->assertSee('data-stat="evidences">1', false);
    }
}
