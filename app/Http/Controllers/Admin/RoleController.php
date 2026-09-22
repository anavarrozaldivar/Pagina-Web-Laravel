<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Lista de roles.
     */
    public function index(Request $request): View
    {
        $roles = Role::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('label', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->withCount('users')
            ->with('permissions')
            ->orderBy('label')
            ->paginate(10)
            ->withQueryString();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('admin.roles.create');
    }

    /**
     * Crea un rol.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:roles,name',
            ],

            'label' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $role = Role::create($validated);

        return redirect()
            ->route('admin.roles.show', $role)
            ->with('success', 'Rol creado correctamente.');
    }

    /**
     * Muestra un rol.
     */
    public function show(Role $role): View
    {
        $role->loadCount('users');

        $users = $role->users()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.roles.show', compact('role', 'users'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Role $role): View
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        $role->load('permissions');

        $rolePermissionIds = $role->permissions
            ->pluck('id')
            ->toArray();

        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'rolePermissionIds'
        ));
    }

    /**
     * Actualiza un rol y sus permisos.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],

            'label' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],
        ]);

        $role->update([
            'name' => $validated['name'],
            'label' => $validated['label'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()
            ->route('admin.roles.show', $role)
            ->with('success', 'Rol y permisos actualizados correctamente.');
    }

    /**
     * Elimina un rol.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $usersCount = $role->users()->count();

        if ($usersCount > 0) {
            return redirect()
                ->route('admin.roles.show', $role)
                ->with('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
        }

        if (in_array($role->name, ['admin', 'user'], true)) {
            return redirect()
                ->route('admin.roles.show', $role)
                ->with('error', 'Los roles base del Starter Kit no se pueden eliminar.');
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}