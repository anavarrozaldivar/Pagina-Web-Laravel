<x-app-layout>

<div class="mx-auto w-full max-w-4xl space-y-6">

    {{-- Cabecera --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex min-w-0 items-center gap-3">

            <a
                href="{{ route('admin.users.show', $user) }}"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="Volver al usuario"
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
                    Editar usuario
                </h1>

                <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">
                    {{ $user->name }}
                </p>
            </div>

        </div>

        <div class="hidden items-center rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 sm:inline-flex dark:bg-gray-800 dark:text-gray-300">
            ID #{{ $user->id }}
        </div>

    </div>

    {{-- Formulario --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

        {{-- Cabecera --}}
        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

            <div class="flex items-start gap-4">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M17.5 3.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 8.5-8.5z"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Información de la cuenta
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Modifica los datos básicos y el rol asignado a este usuario.
                    </p>
                </div>

            </div>

        </div>

        <form
            method="POST"
            action="{{ route('admin.users.update', $user) }}"
            class="p-6 sm:p-8"
        >
            @csrf
            @method('PUT')

            <div class="space-y-8">

                {{-- Datos principales --}}
                <div>

                    <div class="mb-5">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Datos principales
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Información utilizada para identificar y acceder a la cuenta.
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Nombre --}}
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                            >
                                Nombre
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                autocomplete="name"
                                class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                            >

                            @error('name')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                            >
                                Correo electrónico
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                                class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                            >

                            @error('email')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Rol --}}
                <div class="border-t border-gray-100 pt-8 dark:border-gray-800">

                    <div class="mb-5">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Permisos y acceso
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            El rol determina las funciones que podrá utilizar este usuario.
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>
                            <label
                                for="role_id"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                            >
                                Rol
                            </label>

                            <div class="relative mt-2">

                                <select
                                    id="role_id"
                                    name="role_id"
                                    required
                                    class="block w-full appearance-none rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm font-medium text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                                >
                                    @foreach ($roles as $role)
                                        <option
                                            value="{{ $role->id }}"
                                            @selected((string) old('role_id', $user->role_id) === (string) $role->id)
                                        >
                                            {{ $role->label }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 dark:text-gray-400">
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
                                            d="m19 9-7 7-7-7"
                                        />
                                    </svg>
                                </div>

                            </div>

                            @error('role_id')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                            @if ($user->roleRelation)
                                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    Rol actual: {{ $user->roleRelation->label }}
                                </p>
                            @endif
                        </div>

                        {{-- ID --}}
                        <div>
                            <label
                                for="user-id"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                            >
                                ID de usuario
                            </label>

                            <div
                                id="user-id"
                                class="mt-2 flex h-[46px] items-center rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm font-medium text-gray-500 dark:border-gray-700 dark:bg-gray-800/60 dark:text-gray-400"
                            >
                                #{{ $user->id }}
                            </div>

                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                El identificador no se puede modificar.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Resumen --}}
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-800/50">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-gray-600 dark:bg-gray-800 dark:text-gray-300">
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
                                    d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                Última actualización
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $user->updated_at?->format('d/m/Y H:i') }}
                                ·
                                {{ $user->updated_at?->diffForHumans() }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Acciones --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end dark:border-gray-800">

                <a
                    href="{{ route('admin.users.show', $user) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
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
                            d="M5 12h14M12 5l7 7-7 7"
                        />
                    </svg>

                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>
