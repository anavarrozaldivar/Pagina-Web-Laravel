<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Panel de administración
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'active', 'verified', 'admin'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Administración de usuarios
|--------------------------------------------------------------------------
*/

Route::get('/admin/usuarios', [UserController::class, 'index'])
    ->middleware(['auth', 'active', 'permission:users.view'])
    ->name('admin.users.index');

Route::get('/admin/usuarios/crear', [UserController::class, 'create'])
    ->middleware(['auth', 'active', 'permission:users.create'])
    ->name('admin.users.create');

Route::post('/admin/usuarios', [UserController::class, 'store'])
    ->middleware(['auth', 'active', 'permission:users.create'])
    ->name('admin.users.store');

Route::get('/admin/usuarios/{user}', [UserController::class, 'show'])
    ->middleware(['auth', 'active', 'permission:users.view'])
    ->name('admin.users.show');

Route::get('/admin/usuarios/{user}/editar', [UserController::class, 'edit'])
    ->middleware(['auth', 'active', 'permission:users.edit'])
    ->name('admin.users.edit');

Route::put('/admin/usuarios/{user}', [UserController::class, 'update'])
    ->middleware(['auth', 'active', 'permission:users.edit'])
    ->name('admin.users.update');

Route::patch('/admin/usuarios/{user}/estado', [UserController::class, 'toggleStatus'])
    ->middleware(['auth', 'active', 'permission:users.edit'])
    ->name('admin.users.toggle-status');    

Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])
    ->middleware(['auth', 'active', 'permission:users.delete'])
    ->name('admin.users.destroy');


/*
|--------------------------------------------------------------------------
| Auditoría / Actividad
|--------------------------------------------------------------------------
*/

Route::get('/admin/actividad', [ActivityController::class, 'index'])
    ->middleware(['auth', 'active', 'permission:activity.view'])
    ->name('admin.activity.index');

Route::get('/admin/actividad/{activity}', [ActivityController::class, 'show'])
    ->middleware(['auth', 'active', 'permission:activity.view'])
    ->name('admin.activity.show');


/*
|--------------------------------------------------------------------------
| Administración de roles
|--------------------------------------------------------------------------
*/

Route::get('/admin/roles', [RoleController::class, 'index'])
    ->middleware(['auth', 'active', 'permission:roles.view'])
    ->name('admin.roles.index');

Route::get('/admin/roles/crear', [RoleController::class, 'create'])
    ->middleware(['auth', 'active', 'permission:roles.create'])
    ->name('admin.roles.create');

Route::post('/admin/roles', [RoleController::class, 'store'])
    ->middleware(['auth', 'active', 'permission:roles.create'])
    ->name('admin.roles.store');

Route::get('/admin/roles/{role}', [RoleController::class, 'show'])
    ->middleware(['auth', 'active', 'permission:roles.view'])
    ->name('admin.roles.show');

Route::get('/admin/roles/{role}/editar', [RoleController::class, 'edit'])
    ->middleware(['auth', 'active', 'permission:roles.edit'])
    ->name('admin.roles.edit');

Route::put('/admin/roles/{role}', [RoleController::class, 'update'])
    ->middleware(['auth', 'active', 'permission:roles.edit'])
    ->name('admin.roles.update');

Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])
    ->middleware(['auth', 'active', 'permission:roles.delete'])
    ->name('admin.roles.destroy');


/*
|--------------------------------------------------------------------------
| Administración de contenidos
|--------------------------------------------------------------------------
*/

Route::get('/admin/contenidos', [ContentController::class, 'index'])
    ->middleware(['auth', 'active', 'permission:contents.view'])
    ->name('admin.contents.index');

Route::get('/admin/contenidos/crear', [ContentController::class, 'create'])
    ->middleware(['auth', 'active', 'permission:contents.create'])
    ->name('admin.contents.create');

Route::post('/admin/contenidos', [ContentController::class, 'store'])
    ->middleware(['auth', 'active', 'permission:contents.create'])
    ->name('admin.contents.store');

Route::get('/admin/contenidos/{content}', [ContentController::class, 'show'])
    ->middleware(['auth', 'active', 'permission:contents.view'])
    ->name('admin.contents.show');

Route::get('/admin/contenidos/{content}/editar', [ContentController::class, 'edit'])
    ->middleware(['auth', 'active', 'permission:contents.edit'])
    ->name('admin.contents.edit');

Route::put('/admin/contenidos/{content}', [ContentController::class, 'update'])
    ->middleware(['auth', 'active', 'permission:contents.edit'])
    ->name('admin.contents.update');

Route::delete('/admin/contenidos/{content}', [ContentController::class, 'destroy'])
    ->middleware(['auth', 'active', 'permission:contents.delete'])
    ->name('admin.contents.destroy');


/*
|--------------------------------------------------------------------------
| Configuración
|--------------------------------------------------------------------------
*/

Route::get('/admin/configuracion', [SettingController::class, 'edit'])
    ->middleware(['auth', 'active', 'admin'])
    ->name('admin.settings.edit');

Route::put('/admin/configuracion', [SettingController::class, 'update'])
    ->middleware(['auth', 'active', 'admin'])
    ->name('admin.settings.update');


/*
|--------------------------------------------------------------------------
| Panel de usuario
|--------------------------------------------------------------------------
*/

Route::get('/mi-panel', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'active'])
    ->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| Notificaciones
|--------------------------------------------------------------------------
*/

// Administración: crear y enviar notificaciones

Route::get('/admin/notificaciones/crear', [NotificationController::class, 'create'])
    ->middleware(['auth', 'active', 'permission:notifications.create'])
    ->name('admin.notifications.create');

Route::post('/admin/notificaciones', [NotificationController::class, 'store'])
    ->middleware(['auth', 'active', 'permission:notifications.create'])
    ->name('admin.notifications.store');


// Usuario: consultar y gestionar sus notificaciones

Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/notificaciones', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notificaciones/leer-todas', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read-all');

    Route::patch('/notificaciones/{notification}/leer', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

});


/*
|--------------------------------------------------------------------------
| Perfil
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';