<x-app-layout>

@php
    $currentUser = Auth::user();

    $currentUser->loadMissing('roleRelation.permissions');

    $isAdmin = $currentUser->roleRelation?->name === 'admin';

    $canCreateNotifications =
        $isAdmin
        || $currentUser->roleRelation?->permissions?->contains('name', 'notifications.create');
@endphp

@if ($canCreateNotifications)

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Administración
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Enviar notificación
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Envía un aviso directamente a un usuario de la aplicación.
            </p>
        </div>

        {{-- Errores --}}
        @if ($errors->any())

            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 dark:border-red-900/50 dark:bg-red-950/30">

                <p class="text-sm font-semibold text-red-700 dark:text-red-400">
                    Revisa los siguientes errores:
                </p>

                <ul class="mt-2 list-inside list-disc text-sm text-red-600 dark:text-red-400">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Formulario --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                    Nueva notificación
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Completa los datos del aviso que quieres enviar.
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('admin.notifications.store') }}"
            >

                @csrf

                <div class="space-y-6 p-6">

                    {{-- Usuario --}}
                    <div>

                        <label
                            for="user_id"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Usuario destinatario
                        </label>

                        <select
                            id="user_id"
                            name="user_id"
                            required
                            class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >

                            <option value="">
                                Selecciona un usuario
                            </option>

                            @foreach ($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected(old('user_id') == $user->id)
                                >
                                    {{ $user->name }} — {{ $user->email }}
                                </option>

                            @endforeach

                        </select>

                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Título --}}
                    <div>

                        <label
                            for="title"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Título
                        </label>

                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            placeholder="Ej. Nueva actualización disponible"
                            required
                            class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500"
                        >

                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Mensaje --}}
                    <div>

                        <label
                            for="message"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Mensaje
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            placeholder="Escribe aquí el contenido de la notificación..."
                            required
                            class="mt-2 block w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500"
                        >{{ old('message') }}</textarea>

                        @error('message')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Tipo --}}
                    <div>

                        <label
                            for="type"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Tipo de notificación
                        </label>

                        <select
                            id="type"
                            name="type"
                            required
                            class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >

                            <option
                                value="info"
                                @selected(old('type', 'info') === 'info')
                            >
                                Información
                            </option>

                            <option
                                value="success"
                                @selected(old('type') === 'success')
                            >
                                Éxito
                            </option>

                            <option
                                value="warning"
                                @selected(old('type') === 'warning')
                            >
                                Aviso
                            </option>

                        </select>

                        @error('type')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- URL --}}
                    <div>

                        <label
                            for="url"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Enlace opcional
                        </label>

                        <input
                            id="url"
                            name="url"
                            type="text"
                            value="{{ old('url') }}"
                            placeholder="/admin/contenidos"
                            class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500"
                        >

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Si añades un enlace, el usuario podrá pulsar «Ver» y acceder directamente a esa página.
                        </p>

                        @error('url')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- Botones --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-5 sm:flex-row sm:justify-end dark:border-gray-800 dark:bg-gray-800/30">

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Enviar notificación

                    </button>

                </div>

            </form>

        </div>

    </div>

@else

    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900">

        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
            Sin permiso
        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            No tienes permisos para crear notificaciones.
        </p>

    </div>

@endif

</x-app-layout>
