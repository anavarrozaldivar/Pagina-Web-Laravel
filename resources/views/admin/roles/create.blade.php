<x-app-layout>

<div class="mx-auto w-full max-w-4xl space-y-6">

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
                    Nuevo rol
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Crea un nuevo rol para organizar los permisos de los usuarios.
                </p>

            </div>

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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                </div>

                <div>

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Información del rol
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Define el identificador, nombre y descripción que tendrá el rol.
                    </p>

                </div>

            </div>

        </div>

        <form
            method="POST"
            action="{{ route('admin.roles.store') }}"
            class="p-6 sm:p-8"
        >

            @csrf

            <div class="space-y-8">

                {{-- Identidad --}}
                <div>

                    <div class="mb-5">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Identidad del rol
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            El identificador se utiliza internamente y el nombre visible aparecerá en la interfaz.
                        </p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Nombre interno --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                            >
                                Identificador
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                maxlength="50"
                                pattern="[A-Za-z0-9_-]+"
                                autocomplete="off"
                                placeholder="editor"
                                class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white"
                            >

                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                Letras, números, guiones y guiones bajos.
                            </p>

                            @error('name')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Nombre visible --}}
                        <div>

                            <label
                                for="label"
                                class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                            >
                                Nombre visible
                            </label>

                            <input
                                type="text"
                                id="label"
                                name="label"
                                value="{{ old('label') }}"
                                required
                                maxlength="100"
                                placeholder="Editor"
                                class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white"
                            >

                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                Nombre que verán los administradores.
                            </p>

                            @error('label')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                {{-- Descripción --}}
                <div class="border-t border-gray-100 pt-8 dark:border-gray-800">

                    <div class="mb-5">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Descripción
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Explica brevemente el objetivo de este rol.
                        </p>
                    </div>

                    <div>

                        <label
                            for="description"
                            class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                        >
                            Descripción
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            maxlength="1000"
                            placeholder="Describe qué puede hacer un usuario con este rol..."
                            class="mt-2 block w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white"
                        >{{ old('description') }}</textarea>

                        <div class="mt-2 flex items-center justify-between gap-3">

                            @error('description')
                                <p class="text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    Máximo 1000 caracteres.
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                {{-- Vista previa --}}
                <div class="border-t border-gray-100 pt-8 dark:border-gray-800">

                    <div class="mb-5">

                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Vista previa
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Así se identificará el rol dentro de la administración.
                        </p>

                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-800/50">

                        <div class="flex items-center gap-4">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gray-900 text-lg font-bold text-white dark:bg-white dark:text-gray-900">
                                R
                            </div>

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">

                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        Nuevo rol
                                    </p>

                                    <span class="inline-flex rounded-full bg-white px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        Personalizado
                                    </span>

                                </div>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    El rol estará disponible al crear o editar usuarios.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Acciones --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end dark:border-gray-800">

                <a
                    href="{{ route('admin.roles.index') }}"
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
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    Crear rol
                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>
