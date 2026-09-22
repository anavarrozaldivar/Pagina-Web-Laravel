<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Content;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $userRole = Role::where('name', 'user')->firstOrFail();
        $admin = User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->firstOrFail();

        $users = collect([
            ['name' => 'Lucía Fernández', 'email' => 'lucia@example.com'],
            ['name' => 'Marco Silva', 'email' => 'marco@example.com'],
            ['name' => 'Sofía Martín', 'email' => 'sofia@example.com'],
            ['name' => 'Daniel Ortega', 'email' => 'daniel@example.com'],
            ['name' => 'Elena Ruiz', 'email' => 'elena@example.com'],
        ])->map(fn (array $attributes): User => User::updateOrCreate(
            ['email' => $attributes['email']],
            [
                'name' => $attributes['name'],
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'status' => true,
                'email_verified_at' => now(),
            ]
        ));

        $contents = [
            ['title' => 'Guía de bienvenida al equipo', 'description' => 'Recursos y pasos para comenzar a trabajar con la plataforma.', 'status' => 'published'],
            ['title' => 'Política de seguridad interna', 'description' => 'Buenas prácticas para proteger cuentas, datos y accesos.', 'status' => 'published'],
            ['title' => 'Plan de lanzamiento Q4', 'description' => 'Borrador de prioridades y acciones para el próximo trimestre.', 'status' => 'draft'],
            ['title' => 'Manual de operaciones', 'description' => 'Procedimientos clave para mantener el trabajo coordinado.', 'status' => 'published'],
            ['title' => 'Encuesta de satisfacción', 'description' => 'Preguntas preparadas para recoger feedback del equipo.', 'status' => 'draft'],
            ['title' => 'Informe mensual de actividad', 'description' => 'Resumen de resultados y evolución de la operación.', 'status' => 'published'],
        ];

        foreach ($contents as $content) {
            Content::updateOrCreate(
                ['title' => $content['title']],
                $content
            );
        }

        $notifications = [
            ['user_id' => $users[0]->id, 'title' => 'Bienvenida al equipo', 'message' => 'Tu espacio de trabajo ya está listo para empezar.', 'type' => 'success', 'url' => '/mi-panel'],
            ['user_id' => $users[1]->id, 'title' => 'Nuevo contenido disponible', 'message' => 'La guía de bienvenida se ha publicado en el espacio común.', 'type' => 'info', 'url' => '/admin/contenidos'],
            ['user_id' => $users[2]->id, 'title' => 'Revisión pendiente', 'message' => 'Hay un borrador esperando revisión antes de su publicación.', 'type' => 'warning', 'url' => '/admin/contenidos'],
            ['user_id' => $admin->id, 'title' => 'Resumen semanal listo', 'message' => 'La actividad de los últimos siete días ya está disponible.', 'type' => 'info', 'url' => '/admin/actividad'],
        ];

        foreach ($notifications as $notification) {
            Notification::updateOrCreate(
                ['user_id' => $notification['user_id'], 'title' => $notification['title']],
                $notification
            );
        }

        $activities = [
            ['user_id' => $admin->id, 'action' => 'login', 'description' => 'Inició sesión en el panel de administración.', 'created_at' => now()->subMinutes(18)],
            ['user_id' => $users[0]->id, 'action' => 'created', 'description' => 'Creó una nueva cuenta de usuario.', 'created_at' => now()->subHours(2)],
            ['user_id' => $admin->id, 'action' => 'updated', 'description' => 'Actualizó la política de seguridad interna.', 'created_at' => now()->subHours(5)],
            ['user_id' => $users[1]->id, 'action' => 'viewed', 'description' => 'Consultó la guía de bienvenida al equipo.', 'created_at' => now()->subDay()],
            ['user_id' => $admin->id, 'action' => 'created', 'description' => 'Publicó el informe mensual de actividad.', 'created_at' => now()->subDays(2)],
            ['user_id' => $users[2]->id, 'action' => 'updated', 'description' => 'Actualizó sus datos de perfil.', 'created_at' => now()->subDays(3)],
            ['user_id' => $admin->id, 'action' => 'updated', 'description' => 'Cambió la configuración general de la aplicación.', 'created_at' => now()->subDays(4)],
            ['user_id' => $users[3]->id, 'action' => 'login', 'description' => 'Inició sesión en el panel de usuario.', 'created_at' => now()->subDays(5)],
        ];

        foreach ($activities as $activity) {
            ActivityLog::firstOrCreate(
                [
                    'user_id' => $activity['user_id'],
                    'action' => $activity['action'],
                    'description' => $activity['description'],
                ],
                ['created_at' => $activity['created_at'], 'updated_at' => $activity['created_at']]
            );
        }
    }
}
