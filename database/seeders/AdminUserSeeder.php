<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD');

        if (app()->environment('production') && (! $password || strlen($password) < 12)) {
            throw new \RuntimeException('ADMIN_PASSWORD debe configurarse con al menos 12 caracteres en producción.');
        }

        $password ??= 'password';

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrador'),
                'password' => Hash::make($password),
                'role_id' => $adminRole->id,
                'status' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
