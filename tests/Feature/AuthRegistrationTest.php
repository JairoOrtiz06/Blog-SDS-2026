<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_create_a_normal_account(): void
    {
        $response = $this->post('/register', [
            'name' => 'Estudiante SDS',
            'email' => 'estudiante@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'estudiante@example.com')->firstOrFail();

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('status');
        $this->assertAuthenticatedAs($user);
        $this->assertSame('user', $user->role);
        $this->assertTrue(Hash::check('secure-password', $user->password));
    }

    public function test_registration_requires_a_unique_email_and_confirmed_password(): void
    {
        User::factory()->create(['email' => 'estudiante@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Otro Estudiante',
            'email' => 'estudiante@example.com',
            'password' => 'secure-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertDatabaseCount('users', 1);
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
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Herramientas de administración')
            ->assertSee('Administrar publicaciones')
            ->assertSee('Administrar evidencias')
            ->assertSee($admin->name);
    }
}
