<x-app-layout>

    @php
        $currentUser = Auth::user();

        $currentUser->loadMissing('roleRelation.permissions');

        $isAdmin = $currentUser->roleRelation?->name === 'admin';

        $canEditRoles =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'roles.edit');

        $canDeleteRoles =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'roles.delete');

        $isBaseRole = in_array($role->name, ['admin', 'user'], true);

        $permissionCount = $role->permissions->count();
    @endphp

    <div class="mx-auto w-full max-w-6xl space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex min-w-0 items-center gap-3">

                <a
                    href="{{ route('admin.roles.index') }}"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    aria-label="Volver a roles"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M19 12H5m6-6-6 6 6 6"
                        />
                    </svg>
                </a>

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Administración
                    </p>

                    <h1 class="truncate text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $role->label }}
                    </h1>

                    <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">
                        Información, permisos y usuarios asociados a este rol.
                    </p>

                </div>

            </div>

            @if ($canEditRoles)

                <a
                    href="{{ route('admin.roles.edit', $role) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M17.5 3.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 8.5-8.5z"
                        />
                    </svg>

                    Editar rol
                </a>

            @endif

        </div>


        {{-- Mensajes --}}
        @if (session('success'))

            <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm font-medium text-green-700 dark:border-green-900/50 dark:bg-green-950/30 dark:text-green-400">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/40">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

                <div class="pt-1">
                    {{ session('success') }}
                </div>

            </div>

        @endif


        @if (session('error'))

            <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm font-medium text-red-700 dark:border-red-900/50 dark:bg-red-950/30 dark:text-red-400">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/40">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>

                </div>

                <div class="pt-1">
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- Información principal --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="relative overflow-hidden px-6 py-8 sm:px-8">

                <div class="absolute -right-12 -top-16 h-40 w-40 rounded-full bg-gray-100 dark:bg-gray-800"></div>

                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">

                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-3xl bg-gray-900 text-2xl font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">
                        {{ strtoupper(substr($role->label, 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $role->label }}
                            </h2>

                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                {{ $isBaseRole ? 'Rol base' : 'Personalizado' }}
                            </span>

                        </div>

                        <code class="mt-2 inline-flex rounded-lg bg-gray-100 px-2.5 py-1.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                            {{ $role->name }}
                        </code>

                        <p class="mt-4 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">
                            {{ $role->description ?: 'Este rol no tiene una descripción.' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Resumen --}}
            <div class="grid border-t border-gray-100 sm:grid-cols-3 dark:border-gray-800">

                <div class="border-b border-gray-100 px-6 py-5 sm:border-b-0 sm:border-r dark:border-gray-800">

                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                        Usuarios
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $role->users_count }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Usuarios con este rol.
                    </p>

                </div>


                <div class="border-b border-gray-100 px-6 py-5 sm:border-b-0 sm:border-r dark:border-gray-800">

                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                        Permisos
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $permissionCount }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Capacidades asignadas.
                    </p>

                </div>


                <div class="px-6 py-5">

                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                        Identificador
                    </p>

                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $role->name }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Nombre interno del rol.
                    </p>

                </div>

            </div>

        </section>


        {{-- Permisos --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Permisos del rol
                        </h2>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Capacidades que tienen los usuarios con este rol.
                        </p>

                    </div>

                    <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1.5 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ $permissionCount }}
                        {{ $permissionCount === 1 ? 'permiso' : 'permisos' }}
                    </span>

                </div>

            </div>


            <div class="p-6">

                @if ($permissionCount > 0)

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($role->permissions as $permission)

                            <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-4 dark:border-gray-800 dark:bg-gray-800/50">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-gray-600 shadow-sm dark:bg-gray-900 dark:text-gray-300">

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M12 3l7 4v5c0 4.5-3 8-7 9-4-1-7-4.5-7-9V7l7-4z"
                                            />
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $permission->label }}
                                        </p>

                                        <code class="mt-1 block truncate text-[10px] font-medium text-gray-400 dark:text-gray-500">
                                            {{ $permission->name }}
                                        </code>

                                        @if ($permission->description)

                                            <p class="mt-2 text-xs leading-5 text-gray-500 dark:text-gray-400">
                                                {{ $permission->description }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="py-10 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 6v12m6-6H6"
                                />
                            </svg>

                        </div>

                        <p class="mt-4 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Este rol no tiene permisos asignados
                        </p>

                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                            Puedes asignarlos desde la edición del rol.
                        </p>

                    </div>

                @endif

            </div>

        </section>


        {{-- Acciones --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Acciones
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gestiona este rol según los permisos de tu cuenta.
                </p>

            </div>

            <div class="flex flex-col gap-3 px-6 py-5 sm:flex-row sm:flex-wrap sm:justify-end">

                @if ($canEditRoles)

                    <a
                        href="{{ route('admin.roles.edit', $role) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M17.5 3.5a2.1 2.1 0 013 3L12 15l-4 1-1-4 8.5-8.5z"
                            />
                        </svg>

                        Editar rol

                    </a>

                @endif


                @if ($canDeleteRoles && ! $isBaseRole)

                    <form
                        method="POST"
                        action="{{ route('admin.roles.destroy', $role) }}"
                        onsubmit="return confirm('¿Seguro que quieres eliminar este rol? Esta acción no se puede deshacer.')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/10 dark:border-red-900/50 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-950/30 sm:w-auto"
                        >

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M6 7h12m-9 0v10m6-10v10M9 7l1-3h4l1 3m-7 0h8m-9 0-1 13h12L17 7"
                                />
                            </svg>

                            Eliminar rol

                        </button>

                    </form>

                @elseif ($isBaseRole)

                    <div class="w-full rounded-xl bg-gray-50 px-4 py-3 text-center sm:w-auto dark:bg-gray-800/60">

                        <p class="text-xs font-medium leading-5 text-gray-500 dark:text-gray-400">
                            Los roles base
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                admin
                            </span>
                            y
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                user
                            </span>
                            no se pueden eliminar.
                        </p>

                    </div>

                @endif


                @if (! $canEditRoles && ! $canDeleteRoles)

                    <div class="w-full rounded-xl bg-gray-50 px-4 py-3 text-center dark:bg-gray-800/60">

                        <p class="text-xs font-medium leading-5 text-gray-500 dark:text-gray-400">
                            No tienes permisos para modificar este rol.
                        </p>

                    </div>

                @endif

            </div>

        </section>


        {{-- Usuarios del rol --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Usuarios con este rol
                        </h2>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Usuarios que actualmente tienen asignado este rol.
                        </p>

                    </div>

                    <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1.5 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ $role->users_count }}
                        {{ $role->users_count === 1 ? 'usuario' : 'usuarios' }}
                    </span>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full text-left">

                    <thead class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">

                        <tr>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Usuario
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Email
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Alta
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse ($users as $user)

                            <tr class="group transition hover:bg-gray-50 dark:hover:bg-gray-800/50">

                                {{-- Usuario --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-xs font-bold text-white dark:bg-white dark:text-gray-900">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Estado --}}
                                <td class="px-6 py-5">

                                    @if ($user->isActive())

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Activo

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                                            Inactivo

                                        </span>

                                    @endif

                                </td>


                                {{-- Email --}}
                                <td class="px-6 py-5 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->email }}
                                </td>


                                {{-- Alta --}}
                                <td class="px-6 py-5">

                                    <div>

                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $user->created_at?->format('d/m/Y') }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                            {{ $user->created_at?->diffForHumans() }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Acción --}}
                                <td class="px-6 py-5 text-right">

                                    <a
                                        href="{{ route('admin.users.show', $user) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                                    >

                                        Ver

                                        <svg
                                            class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m9 5 7 7-7 7"
                                            />
                                        </svg>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-14 text-center"
                                >

                                    <div class="mx-auto max-w-sm">

                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500">

                                            <svg
                                                class="h-6 w-6"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8"
                                                />
                                            </svg>

                                        </div>

                                        <p class="mt-4 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            No hay usuarios con este rol
                                        </p>

                                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                            Los usuarios asignados aparecerán aquí.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($users->hasPages())

                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $users->links() }}
                </div>

            @endif

        </section>

    </div>

</x-app-layout>