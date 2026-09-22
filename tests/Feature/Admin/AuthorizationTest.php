<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed([
        RoleSeeder::class,
        PermissionSeeder::class,
    ]);
});

test('regular users can access only the permissions assigned to their role', function () {
    $role = Role::where('name', 'user')->firstOrFail();
    $user = User::factory()->create([
        'role_id' => $role->id,
        'status' => true,
    ]);

    $this->actingAs($user)
        ->get(route('admin.users.index'))
        ->assertOk();

    $this->actingAs($user)
        ->get(route('admin.roles.index'))
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('admin.settings.edit'))
        ->assertForbidden();
});

test('regular users cannot access the administrator dashboard', function () {
    $role = Role::where('name', 'user')->firstOrFail();
    $user = User::factory()->create([
        'role_id' => $role->id,
        'status' => true,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertForbidden();
});

test('administrators can access the administrator dashboard', function () {
    $role = Role::where('name', 'admin')->firstOrFail();
    $admin = User::factory()->create([
        'role_id' => $role->id,
        'status' => true,
    ]);

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertOk();
});
