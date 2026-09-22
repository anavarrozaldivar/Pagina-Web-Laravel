<x-app-layout>

    @php
        $currentUser = Auth::user();

        $currentUser->loadMissing('roleRelation.permissions');

        $canCreateUsers =
            $currentUser->roleRelation?->name === 'admin'
            || $currentUser->roleRelation?->permissions?->contains('name', 'users.create');

        $totalUsers = $users->total();
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
                        Usuarios
                    </h1>

                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        {{ $totalUsers }}
                    </span>

                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gestiona los usuarios y sus roles dentro de la aplicación.
                </p>

            </div>

            @if ($canCreateUsers)

                <a
                    href="{{ route('admin.users.create') }}"
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

                    Nuevo usuario

                </a>

            @endif

        </div>


        {{-- Resumen --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            @foreach ([
                ['label' => 'Total usuarios', 'value' => $userStats['total'], 'detail' => 'En el sistema', 'tone' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-300'],
                ['label' => 'Activos', 'value' => $userStats['active'], 'detail' => 'Acceso habilitado', 'tone' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300'],
                ['label' => 'Inactivos', 'value' => $userStats['inactive'], 'detail' => 'Revisar acceso', 'tone' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-300'],
                ['label' => 'Administradores', 'value' => $userStats['admins'], 'detail' => 'Acceso completo', 'tone' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/30 dark:text-indigo-300'],
            ] as $stat)
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            {{ $stat['label'] }}
                        </p>
                        <span class="h-2 w-2 rounded-full {{ $stat['tone'] }}"></span>
                    </div>
                    <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $stat['value'] }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ $stat['detail'] }}
                    </p>
                </div>
            @endforeach

        </div>


        {{-- Mensaje de éxito --}}
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


        {{-- Errores --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-950/30 dark:text-red-400">

                <div class="flex items-start gap-3">

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
                                d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.85 21h16.3a2 2 0 001.74-3.14l-8.18-14a2 2 0 00-3.42 0Z"
                            />
                        </svg>

                    </div>

                    <div class="space-y-1">

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>

                </div>

            </div>

        @endif


        {{-- Búsqueda y filtros --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <form
                method="GET"
                action="{{ route('admin.users.index') }}"
                class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_200px_200px_auto]"
            >

                {{-- Buscar --}}
                <div>

                    <label
                        for="search"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Buscar
                    </label>

                    <div class="relative">

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
                                    d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                                />
                            </svg>

                        </div>

                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ request('search') }}"
                            placeholder="Buscar por nombre o email..."
                            class="block w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white"
                        >

                    </div>

                </div>


                {{-- Rol --}}
                <div>

                    <label
                        for="role"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Rol
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                    >

                        <option value="">
                            Todos los roles
                        </option>

                        @foreach ($roles as $role)

                            <option
                                value="{{ $role->name }}"
                                @selected(request('role') === $role->name)
                            >
                                {{ $role->label }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Estado --}}
                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Estado
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                    >

                        <option value="">
                            Todos
                        </option>

                        <option
                            value="1"
                            @selected(request('status') === '1')
                        >
                            Activos
                        </option>

                        <option
                            value="0"
                            @selected(request('status') === '0')
                        >
                            Inactivos
                        </option>

                    </select>

                </div>


                {{-- Botones --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="inline-flex h-[46px] flex-1 items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 lg:flex-none"
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
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                            />
                        </svg>

                        Buscar

                    </button>

                    @if (request('search') || request('role') || request('status') !== null)

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="inline-flex h-[46px] items-center justify-center rounded-xl border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Limpiar
                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- Tabla --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            {{-- Cabecera tabla --}}
            <div class="flex flex-col gap-1 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

                <div>

                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Lista de usuarios
                    </h2>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Mostrando {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}
                        de {{ $users->total() }}
                    </p>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">

                        <tr>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Usuario
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Rol
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Registrado
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse ($users as $user)

                            <tr class="group transition hover:bg-gray-50 dark:hover:bg-gray-800/50">

                                {{-- Usuario --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="relative">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <span
                                                class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white dark:border-gray-900 {{ $user->isActive() ? 'bg-emerald-500' : 'bg-gray-400' }}"
                                                title="{{ $user->isActive() ? 'Activo' : 'Inactivo' }}"
                                            ></span>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">

                                                {{ $user->name }}

                                                @if ($user->id === $currentUser->id)

                                                    <span class="ml-1 text-xs font-medium text-gray-400">
                                                        Tú
                                                    </span>

                                                @endif

                                            </p>

                                            <p class="mt-0.5 truncate text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->email }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Rol --}}
                                <td class="px-6 py-4">

                                    @if ($user->roleRelation?->name === 'admin')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700 dark:bg-purple-950/40 dark:text-purple-400">

                                            <span class="h-1.5 w-1.5 rounded-full bg-purple-500"></span>

                                            {{ $user->roleRelation->label }}

                                        </span>

                                    @elseif ($user->roleRelation)

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">

                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                                            {{ $user->roleRelation->label }}

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-950/30 dark:text-red-400">

                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                            Sin rol

                                        </span>

                                    @endif

                                </td>


                                {{-- Estado --}}
                                <td class="px-6 py-4">

                                    @if ($user->isActive())

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-400 dark:ring-emerald-900/50">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Activo

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                                            Inactivo

                                        </span>

                                    @endif

                                </td>


                                {{-- Fecha --}}
                                <td class="px-6 py-4">

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
                                <td class="px-6 py-4 text-right">

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
                                                    stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6l5 5v11a2 2 0 0 1-2 2Z"
                                                />
                                            </svg>

                                        </div>

                                        <h3 class="mt-4 text-sm font-semibold text-gray-900 dark:text-white">
                                            No se han encontrado usuarios
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Prueba con otros términos de búsqueda o filtros.
                                        </p>

                                        @if (request('search') || request('role') || request('status') !== null)

                                            <a
                                                href="{{ route('admin.users.index') }}"
                                                class="mt-4 text-sm font-semibold text-gray-700 underline underline-offset-4 dark:text-gray-300"
                                            >
                                                Limpiar filtros
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginación --}}
            @if ($users->hasPages())

                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $users->links() }}
                </div>

            @endif

        </div>

    </div>

</x-app-layout>