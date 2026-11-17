<?php

namespace Tests\Feature;

use App\Models\Evidence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EvidenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_register_and_download_a_private_evidence_file(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/evidencias/create')
            ->assertOk()
            ->assertSee('Registrar evidencia');

        $this->actingAs($admin)
            ->post('/admin/evidencias', [
                'title' => 'Taller de sensores',
                'activity' => 'Exposición Green IoT',
                'description' => 'Fotografía de la actividad.',
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->create('evidencia.pdf', 250, 'application/pdf'),
            ])
            ->assertRedirect(route('evidences.index'));

        $evidence = Evidence::firstOrFail();

        $this->assertDatabaseHas('evidences', [
            'title' => 'Taller de sensores',
            'activity' => 'Exposición Green IoT',
            'user_id' => $admin->id,
        ]);
        Storage::disk('local')->assertExists($evidence->file_path);

        $this->get(route('evidences.download', $evidence))
            ->assertOk();

        $this->get('/admin/evidencias')
            ->assertOk()
            ->assertSee('Taller de sensores')
            ->assertSee('evidencia.pdf');
    }

    public function test_normal_user_cannot_access_evidence_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/evidencias')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/admin/evidencias/create')
            ->assertForbidden();

        $this->actingAs($user)
            ->post('/admin/evidencias', [])
            ->assertForbidden();
    }

    public function test_evidence_upload_rejects_unsupported_file_types(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from('/admin/evidencias/create')
            ->post('/admin/evidencias', [
                'title' => 'Archivo inválido',
                'activity' => 'Prueba',
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->create('archivo.txt', 10, 'text/plain'),
            ])
            ->assertRedirect('/admin/evidencias/create')
            ->assertSessionHasErrors('file');

        $this->assertDatabaseCount('evidences', 0);
    }
}
