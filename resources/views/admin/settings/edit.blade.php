<x-app-layout>

<div class="mx-auto max-w-5xl space-y-6">

    <div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Sistema
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Configuración
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Personaliza la identidad y el comportamiento de la aplicación.
        </p>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm font-medium text-emerald-700 dark:border-emerald-900/50 dark:bg-emerald-950/30 dark:text-emerald-400">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/40">
                ✓
            </div>

            <div class="pt-1">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 dark:border-red-900/50 dark:bg-red-950/30">
            <p class="text-sm font-semibold text-red-700 dark:text-red-400">
                Hay algunos errores que debes corregir.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
        class="space-y-6"
    >
        @csrf
        @method('PUT')

        {{-- Identidad --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Identidad
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Información principal que identifica la aplicación.
                </p>
            </div>

            <div class="grid gap-5 px-6 py-6 md:grid-cols-2">

                <div>
                    <label
                        for="app_name"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Nombre de la aplicación
                    </label>

                    <input
                        id="app_name"
                        name="app_name"
                        type="text"
                        value="{{ old('app_name', $settings['app_name'] ?? 'Laravel Admin Kit') }}"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                </div>

                <div>
                    <label
                        for="contact_email"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Email de contacto
                    </label>

                    <input
                        id="contact_email"
                        name="contact_email"
                        type="email"
                        value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                        placeholder="support@example.com"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                </div>

                <div class="md:col-span-2">
                    <label
                        for="app_description"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Descripción
                    </label>

                    <textarea
                        id="app_description"
                        name="app_description"
                        rows="4"
                        placeholder="Descripción breve de la aplicación..."
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >{{ old('app_description', $settings['app_description'] ?? '') }}</textarea>
                </div>

            </div>
        </section>

        {{-- Apariencia --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Apariencia
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Define el aspecto visual de la aplicación.
                </p>
            </div>

            <div class="grid gap-5 px-6 py-6 md:grid-cols-2">

                <div>
                    <label
                        for="theme_mode"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Tema
                    </label>

                    <select
                        id="theme_mode"
                        name="theme_mode"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                        <option
                            value="light"
                            @selected(old('theme_mode', $settings['theme_mode'] ?? 'system') === 'light')
                        >
                            Claro
                        </option>

                        <option
                            value="dark"
                            @selected(old('theme_mode', $settings['theme_mode'] ?? 'system') === 'dark')
                        >
                            Oscuro
                        </option>

                        <option
                            value="system"
                            @selected(old('theme_mode', $settings['theme_mode'] ?? 'system') === 'system')
                        >
                            Automático
                        </option>
                    </select>
                </div>

                <div>
                    
                    <div class="flex gap-3">

                    </div>
                </div>

            </div>
        </section>

        {{-- Branding --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Branding
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Configura el logo y favicon de tu aplicación.
                </p>
            </div>

            <div class="space-y-5 px-6 py-6">

                <div>
                    <label
                        for="logo_path"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Logo
                    </label>

                    <input
                        id="logo_path"
                        name="logo_path"
                        type="text"
                        value="{{ old('logo_path', $settings['logo_path'] ?? '') }}"
                        placeholder="/storage/logo.png"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >

                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                        Introduce una ruta pública o URL. Más adelante podremos conectarlo al gestor de archivos.
                    </p>
                </div>

                <div>
                    <label
                        for="favicon_path"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Favicon
                    </label>

                    <input
                        id="favicon_path"
                        name="favicon_path"
                        type="text"
                        value="{{ old('favicon_path', $settings['favicon_path'] ?? '') }}"
                        placeholder="/favicon.ico"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                </div>

            </div>
        </section>

        {{-- Sistema --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Sistema
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Ajustes generales del entorno.
                </p>
            </div>

            <div class="grid gap-5 px-6 py-6 md:grid-cols-2">

                <div>
                    <label
                        for="timezone"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Zona horaria
                    </label>

                    <input
                        id="timezone"
                        name="timezone"
                        type="text"
                        value="{{ old('timezone', $settings['timezone'] ?? config('app.timezone')) }}"
                        required
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                </div>

                <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-4 dark:border-gray-700 dark:bg-gray-800">

                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            Modo mantenimiento
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Activa el mantenimiento de la aplicación.
                        </p>
                    </div>

                    <label class="relative inline-flex cursor-pointer items-center">

                        <input
                            type="checkbox"
                            name="maintenance_mode"
                            value="1"
                            class="peer sr-only"
                            @checked((bool) old('maintenance_mode', $settings['maintenance_mode'] ?? false))
                        >

                        <div class="h-6 w-11 rounded-full bg-gray-300 transition peer-checked:bg-gray-900 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-900/10 dark:bg-gray-700 dark:peer-checked:bg-white"></div>

                        <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5 dark:bg-gray-300"></div>

                    </label>
                </div>

            </div>
        </section>

        {{-- Acciones --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

</x-app-layout>
