<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Lista de usuarios.
     */
    public function index(Request $request): View
    {
        $users = User::query()
            ->with('roleRelation')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->whereHas('roleRelation', function ($roleQuery) use ($role) {
                    $roleQuery->where('name', $role);
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->boolean('status'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $roles = Role::query()
            ->orderBy('label')
            ->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Muestra un usuario.
     */
    public function show(User $user): View
    {
        $user->load('roleRelation');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(User $user): View
    {
        $roles = Role::query()
            ->orderBy('label')
            ->get();

        $user->load('roleRelation');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza un usuario.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'role_id' => [
                'required',
                'exists:roles,id',
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        $roles = Role::query()
            ->orderBy('label')
            ->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Crea un usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],

            'role_id' => [
                'required',
                'exists:roles,id',
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'status' => true,
        ]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Activa o desactiva un usuario.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && $currentUser->id === $user->id) {
            return redirect()
                ->route('admin.users.show', $user)
                ->withErrors([
                    'status' => 'No puedes desactivar tu propia cuenta.',
                ]);
        }

        $user->update([
            'status' => ! $user->status,
        ]);

        $message = $user->status
            ? 'Usuario activado correctamente.'
            : 'Usuario desactivado correctamente.';

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', $message);
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser && $currentUser->id === $user->id) {
            return redirect()
                ->route('admin.users.show', $user)
                ->withErrors([
                    'delete' => 'No puedes eliminar tu propia cuenta.',
                ]);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}