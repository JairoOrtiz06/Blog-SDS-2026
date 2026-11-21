<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (! $email || ! $password) {
            throw new RuntimeException('Define ADMIN_EMAIL y ADMIN_PASSWORD para crear la cuenta administradora inicial.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            throw new RuntimeException('ADMIN_EMAIL debe ser un correo válido y ADMIN_PASSWORD debe tener al menos 8 caracteres.');
        }

        $admin = User::firstOrNew(['email' => $email]);
        $admin->name = config('admin.name') ?: 'Administrador SDS';
        $admin->password = $password;
        $admin->is_admin = true;
        $admin->save();
    }
}
