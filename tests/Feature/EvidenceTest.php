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
        $admin = User::factory()->create(['is_admin' => true]);
        $students = config('evidence.students');
        $this->actingAs($admin)
            ->get('/admin/evidencias/create')
            ->assertOk()
            ->assertSee('Registrar evidencia')
            ->assertSee('Individual · un estudiante')
            ->assertSee('En pareja · dos estudiantes')
            ->assertSee('Comelona de pizza')
            ->assertSee('Torneo de fútbol sala')
            ->assertSee($students[0])
            ->assertSee($students[1])
            ->assertSee('name="additional_files[]"', false)
            ->assertSee('multiple', false);

        $this->actingAs($admin)
            ->post('/admin/evidencias', [
                'title' => 'Taller de sensores',
                'activity' => 'Talleres',
                'evidence_type' => 'individual',
                'participant_name' => $students[0],
                'description' => 'Fotografía de la actividad.',
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->image('foto-1.png'),
                'additional_files' => [
                    UploadedFile::fake()->image('foto-2.png'),
                    UploadedFile::fake()->image('foto-3.png'),
                    UploadedFile::fake()->image('foto-4.png'),
                    UploadedFile::fake()->image('foto-5.png'),
                    UploadedFile::fake()->image('foto-6.png'),
                ],
            ])
            ->assertRedirect(route('evidences.index'));

        $evidence = Evidence::firstOrFail();

        $this->assertDatabaseHas('evidences', [
            'title' => 'Taller de sensores',
            'activity' => 'Talleres',
            'user_id' => $admin->id,
            'participant_name' => $students[0],
            'participant_id' => null,
        ]);
        Storage::disk('local')->assertExists($evidence->file_path);
        $attachments = $evidence->attachments()->get();
        $this->assertCount(5, $attachments);
        foreach ($attachments as $attachment) {
            Storage::disk('local')->assertExists($attachment->path);
        }

        $this->get(route('evidences.download', $evidence))
            ->assertOk();

        $this->get(route('evidences.index', ['student' => 'companion']))
            ->assertOk()
            ->assertSee('>Regresar</a>', false)
            ->assertSee('Taller de sensores')
            ->assertSee('foto-1.png')
            ->assertSee('foto-6.png')
            ->assertSee($students[0]);
    }

    public function test_admin_can_preview_a_private_image_evidence(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $path = UploadedFile::fake()->image('actividad.png')->store('evidencias', 'local');
        $evidence = Evidence::create([
            'title' => 'Fotografía de la actividad',
            'activity' => 'Ponencia',
            'evidence_date' => '2026-11-17',
            'participant_name' => config('evidence.views.mine.participant_name'),
            'file_path' => $path,
            'original_filename' => 'actividad.png',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get(route('evidences.preview', $evidence))
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png')
            ->assertHeader('Content-Disposition', 'inline; filename="evidence-'.$evidence->id.'.png"');

        $this->get(route('evidences.index'))
            ->assertOk()
            ->assertSee('class="evidence-preview"', false)
            ->assertSee(route('evidences.preview', $evidence), false);
    }

    public function test_admin_can_open_a_private_pdf_evidence_inline(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $path = UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf')
            ->store('evidencias', 'local');
        $evidence = Evidence::create([
            'title' => 'Documento de actividad',
            'activity' => 'Taller',
            'evidence_date' => '2026-11-17',
            'participant_name' => config('evidence.views.mine.participant_name'),
            'file_path' => $path,
            'original_filename' => 'documento.pdf',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get(route('evidences.preview', $evidence))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'inline; filename="evidence-'.$evidence->id.'.pdf"');

        $this->get(route('evidences.index'))
            ->assertOk()
            ->assertSee('Ver PDF');
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

    public function test_admin_can_filter_evidence_by_student(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $views = config('evidence.views');

        foreach ($views as $key => $view) {
            $path = UploadedFile::fake()->create("{$key}.pdf", 100, 'application/pdf')
                ->store('evidencias', 'local');
            Evidence::create([
                'title' => "Evidencia {$key}",
                'activity' => 'Ponencia',
                'evidence_date' => '2026-11-17',
                'participant_name' => $view['participant_name'],
                'file_path' => $path,
                'original_filename' => "{$key}.pdf",
                'user_id' => $admin->id,
            ]);
        }

        $this->actingAs($admin)
            ->get(route('evidences.index'))
            ->assertOk()
            ->assertSee('Evidencia mine')
            ->assertDontSee('Evidencia companion')
            ->assertSee('Evidencias de Isaias Leonel Cañas Rosa');

        $this->get(route('evidences.index', ['student' => 'companion']))
            ->assertOk()
            ->assertSee('Evidencia companion')
            ->assertDontSee('Evidencia mine')
            ->assertSee('Evidencias de Jairo Jair Ortiz Santos');
    }

    public function test_normal_user_cannot_preview_private_evidence(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $path = UploadedFile::fake()->image('privada.png')->store('evidencias', 'local');
        $evidence = Evidence::create([
            'title' => 'Evidencia privada',
            'activity' => 'Ponencia',
            'evidence_date' => '2026-11-17',
            'file_path' => $path,
            'original_filename' => 'privada.png',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($user)
            ->get(route('evidences.preview', $evidence))
            ->assertForbidden();
    }

    public function test_admin_can_assign_an_existing_evidence_to_a_student(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $students = config('evidence.students');
        $path = UploadedFile::fake()->create('historial.pdf', 100, 'application/pdf')
            ->store('evidencias', 'local');
        $evidence = Evidence::create([
            'title' => 'Evidencia anterior',
            'activity' => 'Ponencias',
            'evidence_date' => '2026-11-15',
            'file_path' => $path,
            'original_filename' => 'historial.pdf',
            'user_id' => $admin->id,
        ]);

        $editResponse = $this->actingAs($admin)
            ->get("/admin/evidencias/{$evidence->id}/edit")
            ->assertOk()
            ->assertSee($students[0])
            ->assertSee($students[1]);
        $this->assertDoesNotMatchRegularExpression(
            '/<input(?=[^>]*name="file")(?=[^>]*required)[^>]*>/s',
            $editResponse->getContent()
        );

        $this->put("/admin/evidencias/{$evidence->id}", [
            'title' => $evidence->title,
            'activity' => $evidence->activity,
            'evidence_date' => '2026-11-15',
            'participant_name' => $students[1],
        ])->assertRedirect(route('evidences.index'));

        $evidence->refresh();
        $this->assertSame($students[1], $evidence->participant_name);
        $this->assertNull($evidence->participant_id);
        Storage::disk('local')->assertExists($path);
    }

    public function test_admin_can_add_multiple_photos_to_an_existing_evidence(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $students = config('evidence.students');
        $mainPath = UploadedFile::fake()->image('principal.png')->store('evidencias', 'local');
        $evidence = Evidence::create([
            'title' => 'Ponencia sobre IoT',
            'activity' => 'Ponencia académica',
            'evidence_date' => '2026-11-17',
            'evidence_type' => 'individual',
            'participant_name' => $students[0],
            'file_path' => $mainPath,
            'original_filename' => 'principal.png',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get(route('evidences.edit', $evidence))
            ->assertOk()
            ->assertSee('Agregar más fotos')
            ->assertSee('Puedes agregar hasta 7 fotos adicionales');

        $this->put(route('evidences.update', $evidence), [
            'title' => $evidence->title,
            'activity' => $evidence->activity,
            'participant_name' => $students[0],
            'evidence_date' => '2026-11-17',
            'additional_files' => [
                UploadedFile::fake()->image('foto-a.png'),
                UploadedFile::fake()->image('foto-b.png'),
            ],
        ])->assertRedirect(route('evidences.index'));

        $attachments = $evidence->attachments()->get();
        $this->assertCount(2, $attachments);
        $this->assertSame(
            ['foto-a.png', 'foto-b.png'],
            $attachments->pluck('original_filename')->all()
        );
        Storage::disk('local')->assertExists($mainPath);
        Storage::disk('local')->assertExists($attachments[0]->path);
        Storage::disk('local')->assertExists($attachments[1]->path);

        $this->get(route('evidences.attachments.preview', [$evidence, $attachments[0]]))
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png');

        $this->get(route('evidences.index', ['student' => 'companion']))
            ->assertOk()
            ->assertSee('foto-a.png')
            ->assertSee('foto-b.png');

        $this->from(route('evidences.edit', $evidence))
            ->put(route('evidences.update', $evidence), [
                'title' => $evidence->title,
                'activity' => $evidence->activity,
                'participant_name' => $students[0],
                'evidence_date' => '2026-11-17',
                'additional_files' => [
                    UploadedFile::fake()->image('foto-c.png'),
                    UploadedFile::fake()->image('foto-d.png'),
                    UploadedFile::fake()->image('foto-e.png'),
                    UploadedFile::fake()->image('foto-f.png'),
                    UploadedFile::fake()->image('foto-g.png'),
                    UploadedFile::fake()->image('foto-h.png'),
                ],
            ])
            ->assertRedirect(route('evidences.edit', $evidence))
            ->assertSessionHasErrors('additional_files');

        $this->assertCount(2, $evidence->attachments()->get());
    }

    public function test_admin_can_delete_evidence_and_its_private_file(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $path = UploadedFile::fake()->create('eliminar.pdf', 100, 'application/pdf')
            ->store('evidencias', 'local');
        $evidence = Evidence::create([
            'title' => 'Evidencia eliminable',
            'activity' => 'Taller',
            'evidence_date' => '2026-11-17',
            'participant_name' => config('evidence.views.mine.participant_name'),
            'file_path' => $path,
            'original_filename' => 'eliminar.pdf',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get(route('evidences.index'))
            ->assertOk()
            ->assertSee('Eliminar evidencia');

        $this->delete(route('evidences.destroy', $evidence))
            ->assertRedirect(route('evidences.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('evidences', ['id' => $evidence->id]);
        Storage::disk('local')->assertMissing($path);
    }

    public function test_admin_can_register_pair_evidence_as_separate_individual_records(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $students = config('evidence.students');

        $this->actingAs($admin)
            ->post('/admin/evidencias', [
                'title' => 'Proyecto colaborativo IoT',
                'activity' => 'Talleres',
                'evidence_type' => 'pair',
                'participant_names' => $students,
                'description' => 'Trabajo realizado por la pareja.',
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->create('proyecto.pdf', 250, 'application/pdf'),
                'additional_files' => [
                    UploadedFile::fake()->image('proyecto-foto.png'),
                ],
            ])
            ->assertRedirect(route('evidences.index'))
            ->assertSessionHas('status', 'Se registró una evidencia individual para cada estudiante.');

        $evidences = Evidence::query()->where('title', 'Proyecto colaborativo IoT')->get();
        $this->assertCount(2, $evidences);
        $this->assertEqualsCanonicalizing(
            $students,
            $evidences->pluck('participant_name')->all()
        );
        $this->assertNull($evidences->first()->participant_id);
        $this->assertDatabaseCount('users', 1);
        $this->assertSame(['pair'], $evidences->pluck('evidence_type')->unique()->values()->all());
        $this->assertCount(2, $evidences->pluck('file_path')->unique());
        $this->assertCount(2, $evidences->flatMap->attachments->pluck('path')->unique());

        foreach ($evidences as $evidence) {
            Storage::disk('local')->assertExists($evidence->file_path);
            $this->assertSame('proyecto.pdf', $evidence->original_filename);
            $this->assertCount(1, $evidence->attachments);
            Storage::disk('local')->assertExists($evidence->attachments->first()->path);
        }

        $this->get(route('evidences.index'))
            ->assertOk()
            ->assertSee('En pareja');

        $firstEvidence = $evidences->firstOrFail();
        $secondEvidence = $evidences->last();
        $this->delete(route('evidences.destroy', $firstEvidence))
            ->assertRedirect(route('evidences.index'));

        $this->assertDatabaseMissing('evidences', ['id' => $firstEvidence->id]);
        $this->assertDatabaseHas('evidences', ['id' => $secondEvidence->id]);
        Storage::disk('local')->assertMissing($firstEvidence->file_path);
        Storage::disk('local')->assertExists($secondEvidence->file_path);
    }

    public function test_pair_evidence_requires_two_distinct_students(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);
        $students = config('evidence.students');

        $this->actingAs($admin)
            ->from('/admin/evidencias/create')
            ->post('/admin/evidencias', [
                'title' => 'Pareja incompleta',
                'activity' => 'Ponencias',
                'evidence_type' => 'pair',
                'participant_names' => [$students[0]],
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->create('prueba.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect('/admin/evidencias/create')
            ->assertSessionHasErrors('participant_names');

        $this->assertDatabaseCount('evidences', 0);
        Storage::disk('local')->assertDirectoryEmpty('evidencias');
    }

    public function test_evidence_activity_must_be_selected_from_the_options(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from('/admin/evidencias/create')
            ->post('/admin/evidencias', [
                'title' => 'Actividad personalizada',
                'activity' => 'Actividad fuera de la lista',
                'evidence_type' => 'individual',
                'participant_name' => config('evidence.students.0'),
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->create('evidencia.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect('/admin/evidencias/create')
            ->assertSessionHasErrors('activity');

        $this->assertDatabaseCount('evidences', 0);
    }

    public function test_normal_user_cannot_delete_evidence(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();
        $evidence = Evidence::create([
            'title' => 'Evidencia protegida',
            'activity' => 'Taller',
            'evidence_date' => '2026-11-17',
            'file_path' => 'evidencias/protegida.pdf',
            'original_filename' => 'protegida.pdf',
            'user_id' => $admin->id,
        ]);

        $this->actingAs($user)
            ->delete(route('evidences.destroy', $evidence))
            ->assertForbidden();

        $this->assertDatabaseHas('evidences', ['id' => $evidence->id]);
    }

    public function test_team_management_is_no_longer_available(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get('/admin/equipos')
            ->assertNotFound();

        $this->get('/dashboard')
            ->assertOk()
            ->assertDontSee('Equipos');
    }

    public function test_evidence_upload_rejects_unsupported_file_types(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from('/admin/evidencias/create')
            ->post('/admin/evidencias', [
                'title' => 'Archivo inválido',
                'activity' => 'Ponencias',
                'evidence_type' => 'individual',
                'participant_name' => config('evidence.students.0'),
                'evidence_date' => '2026-11-17',
                'file' => UploadedFile::fake()->create('archivo.txt', 10, 'text/plain'),
            ])
            ->assertRedirect('/admin/evidencias/create')
            ->assertSessionHasErrors('file');

        $this->assertDatabaseCount('evidences', 0);
    }
}
