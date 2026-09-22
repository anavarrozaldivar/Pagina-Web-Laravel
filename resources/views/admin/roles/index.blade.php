<x-app-layout>

    @php
        $currentUser = Auth::user();

        $currentUser->loadMissing('roleRelation.permissions');

        $isAdmin = $currentUser->roleRelation?->name === 'admin';

        $canCreateRoles =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'roles.create');

        $totalRoles = $roles->total();
    @endphp

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Administración
                </p>

                <div class="mt-1 flex flex-wrap items-center gap-3">

                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Roles
                    </h1>

                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        {{ $totalRoles }}
                    </span>

                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gestiona los roles y permisos disponibles para los usuarios.
                </p>
            </div>

            @if ($canCreateRoles)

                <a
                    href="{{ route('admin.roles.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
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
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    Nuevo rol
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


        {{-- Búsqueda --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <form
                method="GET"
                action="{{ route('admin.roles.index') }}"
                class="flex flex-col gap-3 sm:flex-row"
            >

                <div class="relative flex-1">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                        <svg
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                            />
                        </svg>

                    </div>

                    <label
                        for="search"
                        class="sr-only"
                    >
                        Buscar rol
                    </label>

                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar por nombre, etiqueta o descripción..."
                        class="block w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm font-medium text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white"
                    >

                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
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
                            stroke-width="2"
                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                        />
                    </svg>

                    Buscar
                </button>

                @if (request('search'))

                    <a
                        href="{{ route('admin.roles.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                    >
                        Limpiar
                    </a>

                @endif

            </form>

        </div>


        {{-- Tabla --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Lista de roles
                        </h2>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Mostrando {{ $roles->firstItem() ?? 0 }}–{{ $roles->lastItem() ?? 0 }}
                            de {{ $roles->total() }}
                        </p>

                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full text-left">

                    <thead class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">

                        <tr>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Rol
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Identificador
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Usuarios
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Permisos
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Descripción
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse ($roles as $role)

                            <tr class="group transition hover:bg-gray-50 dark:hover:bg-gray-800/50">

                                {{-- Rol --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">
                                            {{ strtoupper(substr($role->label, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $role->label }}
                                                </p>

                                                <span class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                    {{ in_array($role->name, ['admin', 'user'], true) ? 'Base' : 'Personalizado' }}
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Identificador --}}
                                <td class="px-6 py-5">

                                    <code class="rounded-lg bg-gray-100 px-2.5 py-1.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $role->name }}
                                    </code>

                                </td>


                                {{-- Usuarios --}}
                                <td class="px-6 py-5">

                                    <a
                                        href="{{ route('admin.roles.show', $role) }}"
                                        class="inline-flex min-w-10 items-center justify-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                    >
                                        {{ $role->users_count }}
                                    </a>

                                </td>


                                {{-- Permisos --}}
                                <td class="px-6 py-5">

                                    <div class="flex flex-wrap gap-1.5">

                                        @forelse ($role->permissions->take(3) as $permission)

                                            <span class="inline-flex items-center rounded-full border border-gray-200 bg-white px-2.5 py-1 text-[10px] font-semibold text-gray-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                                {{ $permission->label }}
                                            </span>

                                        @empty

                                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                                Sin permisos
                                            </span>

                                        @endforelse

                                        @if ($role->permissions->count() > 3)

                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-bold text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                +{{ $role->permissions->count() - 3 }}
                                            </span>

                                        @endif

                                    </div>

                                    @if ($role->permissions->count() > 0)

                                        <p class="mt-1.5 text-[11px] text-gray-400 dark:text-gray-500">
                                            {{ $role->permissions->count() }} permiso{{ $role->permissions->count() === 1 ? '' : 's' }}
                                        </p>

                                    @endif

                                </td>


                                {{-- Descripción --}}
                                <td class="max-w-md px-6 py-5">

                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                        {{ $role->description ?: 'Sin descripción' }}
                                    </p>

                                </td>


                                {{-- Acción --}}
                                <td class="px-6 py-5 text-right">

                                    <a
                                        href="{{ route('admin.roles.show', $role) }}"
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
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >

                                    <div class="mx-auto flex max-w-sm flex-col items-center">

                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">

                                            <svg
                                                class="h-7 w-7"
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

                                        <h2 class="mt-4 text-sm font-bold text-gray-900 dark:text-white">
                                            No se han encontrado roles
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Prueba con otro término de búsqueda.
                                        </p>

                                        @if (request('search'))

                                            <a
                                                href="{{ route('admin.roles.index') }}"
                                                class="mt-4 text-sm font-semibold text-gray-700 underline underline-offset-4 dark:text-gray-300"
                                            >
                                                Limpiar filtro
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($roles->hasPages())

                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $roles->links() }}
                </div>

            @endif

        </div>

    </div>

</x-app-layout>