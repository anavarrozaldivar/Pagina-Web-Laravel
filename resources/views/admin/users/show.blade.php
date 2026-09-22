<x-app-layout>

    @php
        $currentUser = Auth::user();

        $currentUser->loadMissing('roleRelation.permissions');

        $isAdmin = $currentUser->roleRelation?->name === 'admin';

        $canEditUsers =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'users.edit');

        $canDeleteUsers =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'users.delete');

        $isCurrentUser = $currentUser->id === $user->id;

        $isActive = $user->isActive();
    @endphp

    <div class="mx-auto w-full max-w-6xl space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex min-w-0 items-center gap-3">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    aria-label="Volver a usuarios"
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
                        Detalles del usuario
                    </h1>

                </div>

            </div>

            @if ($canEditUsers)

                <a
                    href="{{ route('admin.users.edit', $user) }}"
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

                    Editar usuario
                </a>

            @endif

        </div>


        {{-- Perfil principal --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="relative overflow-hidden px-6 py-8 sm:px-8">

                <div class="absolute -right-12 -top-16 h-40 w-40 rounded-full bg-gray-100 dark:bg-gray-800"></div>

                <div class="absolute -bottom-20 right-24 h-32 w-32 rounded-full bg-gray-50 dark:bg-gray-800/60"></div>

                <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center">

                    {{-- Avatar --}}
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-3xl bg-gray-900 text-3xl font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    {{-- Información del usuario --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </h2>

                            @if ($isCurrentUser)

                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    Tu cuenta
                                </span>

                            @endif

                        </div>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->email }}
                        </p>

                        <div class="mt-4 flex flex-wrap items-center gap-2">

                            {{-- Rol --}}
                            @if ($user->roleRelation)

                                @if ($user->roleRelation->name === 'admin')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white dark:bg-white dark:text-gray-900">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white dark:bg-gray-900"></span>
                                        {{ $user->roleRelation->label }}
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                        {{ $user->roleRelation->label }}
                                    </span>

                                @endif

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 dark:bg-red-950/30 dark:text-red-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                    Sin rol
                                </span>

                            @endif


                            {{-- Estado --}}
                            @if ($isActive)

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


                            {{-- ID --}}
                            <span class="inline-flex items-center rounded-full border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                ID #{{ $user->id }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- Información --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Información de la cuenta
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Datos principales asociados a este usuario.
                </p>

            </div>

            <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Nombre --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Nombre
                    </p>

                    <p class="mt-2 break-words text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </p>

                </div>


                {{-- Email --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Correo electrónico
                    </p>

                    <p class="mt-2 break-all text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $user->email }}
                    </p>

                </div>


                {{-- Rol --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Rol
                    </p>

                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $user->roleRelation?->label ?? 'Sin rol' }}
                    </p>

                </div>


                {{-- Estado --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Estado
                    </p>

                    <div class="mt-2">

                        @if ($isActive)

                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Cuenta activa
                            </span>

                        @else

                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                Cuenta inactiva
                            </span>

                        @endif

                    </div>

                </div>


                {{-- ID --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Identificador
                    </p>

                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                        #{{ $user->id }}
                    </p>

                </div>


                {{-- Registro --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Fecha de registro
                    </p>

                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $user->created_at?->format('d/m/Y H:i') }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                        {{ $user->created_at?->diffForHumans() }}
                    </p>

                </div>


                {{-- Actualización --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">

                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Última actualización
                    </p>

                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $user->updated_at?->format('d/m/Y H:i') }}
                    </p>

                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                        {{ $user->updated_at?->diffForHumans() }}
                    </p>

                </div>

            </div>

        </section>


        {{-- Acciones --}}
        @if ($canEditUsers || $canDeleteUsers)

            <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Acciones
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Gestiona esta cuenta según los permisos disponibles.
                    </p>

                </div>

                <div class="flex flex-col gap-3 px-6 py-5 sm:flex-row sm:flex-wrap sm:justify-end">

                    {{-- Activar / desactivar --}}
                    @if ($canEditUsers && ! $isCurrentUser)

                        <form
                            method="POST"
                            action="{{ route('admin.users.toggle-status', $user) }}"
                            onsubmit="return confirm('{{ $isActive ? '¿Quieres desactivar este usuario?' : '¿Quieres activar este usuario?' }}')"
                        >
                            @csrf
                            @method('PATCH')

                            @if ($isActive)

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 sm:w-auto"
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
                                            d="M18 8A6 6 0 116.7 5.2M18 4v4h-4"
                                        />
                                    </svg>

                                    Desactivar usuario
                                </button>

                            @else

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 sm:w-auto"
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
                                            d="M12 5v14m-7-7h14"
                                        />
                                    </svg>

                                    Activar usuario
                                </button>

                            @endif

                        </form>

                    @endif


                    {{-- Editar --}}
                    @if ($canEditUsers)

                        <a
                            href="{{ route('admin.users.edit', $user) }}"
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
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M17.5 3.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 8.5-8.5z"
                                />
                            </svg>

                            Editar usuario
                        </a>

                    @endif


                    {{-- Eliminar --}}
                    @if ($canDeleteUsers && ! $isCurrentUser)

                        <form
                            method="POST"
                            action="{{ route('admin.users.destroy', $user) }}"
                            onsubmit="return confirm('¿Seguro que quieres eliminar este usuario? Esta acción no se puede deshacer.')"
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

                                Eliminar usuario
                            </button>

                        </form>

                    @endif

                </div>

            </section>

        @endif

    </div>

</x-app-layout>