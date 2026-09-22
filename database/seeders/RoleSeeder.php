<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['name' => 'admin'],
            [
                'label' => 'Administrador',
                'description' => 'Acceso completo a la aplicación.',
            ]
        );

        Role::updateOrCreate(
            ['name' => 'user'],
            [
                'label' => 'Usuario',
                'description' => 'Acceso estándar a la aplicación.',
            ]
        );
    }
}
