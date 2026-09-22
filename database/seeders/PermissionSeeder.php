<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'users.view',
                'label' => 'Ver usuarios',
                'description' => 'Permite consultar la lista y los perfiles de usuarios.',
            ],
            [
                'name' => 'users.create',
                'label' => 'Crear usuarios',
                'description' => 'Permite crear nuevos usuarios.',
            ],
            [
                'name' => 'users.edit',
                'label' => 'Editar usuarios',
                'description' => 'Permite modificar usuarios existentes.',
            ],
            [
                'name' => 'users.delete',
                'label' => 'Eliminar usuarios',
                'description' => 'Permite eliminar usuarios.',
            ],

            [
                'name' => 'roles.view',
                'label' => 'Ver roles',
                'description' => 'Permite consultar los roles disponibles.',
            ],
            [
                'name' => 'roles.create',
                'label' => 'Crear roles',
                'description' => 'Permite crear nuevos roles.',
            ],
            [
                'name' => 'roles.edit',
                'label' => 'Editar roles',
                'description' => 'Permite modificar roles existentes.',
            ],
            [
                'name' => 'roles.delete',
                'label' => 'Eliminar roles',
                'description' => 'Permite eliminar roles personalizados.',
            ],

            [
                'name' => 'contents.view',
                'label' => 'Ver contenido',
                'description' => 'Permite consultar el contenido de la aplicación.',
            ],
            [
                'name' => 'contents.create',
                'label' => 'Crear contenido',
                'description' => 'Permite crear contenido.',
            ],
            [
                'name' => 'contents.edit',
                'label' => 'Editar contenido',
                'description' => 'Permite modificar contenido existente.',
            ],
            [
                'name' => 'contents.delete',
                'label' => 'Eliminar contenido',
                'description' => 'Permite eliminar contenido.',
            ],

            [
                'name' => 'notifications.create',
                'label' => 'Crear notificaciones',
                'description' => 'Permite enviar notificaciones a usuarios.',
            ],
            [
                'name' => 'activity.view',
                'label' => 'Ver actividad',
                'description' => 'Permite consultar el registro de actividad y auditoría.',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        $admin = Role::where('name', 'admin')->first();
        $user = Role::where('name', 'user')->first();

        if ($admin) {
            $admin->permissions()->sync(
                Permission::pluck('id')->toArray()
            );
        }

        if ($user) {
            $user->permissions()->sync(
                Permission::whereIn('name', [
                    'users.view',
                    'contents.view',
                ])->pluck('id')->toArray()
            );
        }
    }
}
