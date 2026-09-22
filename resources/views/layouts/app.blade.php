<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    @php
        $appName = \App\Models\Setting::where('key', 'app_name')->value('value')
            ?? config('app.name', 'Starter Kit');

        $themeMode = \App\Models\Setting::where('key', 'theme_mode')->value('value')
            ?? 'system';

        $faviconPath = \App\Models\Setting::where('key', 'favicon_path')->value('value');
    @endphp

    <title>{{ $appName }}</title>

    <script>
        (() => {
            const theme = @json($themeMode);

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                return;
            }

            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
                return;
            }

            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @if ($faviconPath)
        <link
            rel="icon"
            href="{{ filter_var($faviconPath, FILTER_VALIDATE_URL)
                ? $faviconPath
                : asset(ltrim($faviconPath, '/')) }}"
        >
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 font-sans antialiased text-gray-900 dark:bg-gray-950 dark:text-white">

    @include('layouts.navigation')

    <div class="lg:pl-64">

        {{-- Cabecera desktop --}}
        <header class="hidden h-16 items-center justify-between border-b border-gray-200 bg-white px-8 dark:border-gray-800 dark:bg-gray-900 lg:flex">

            <div class="min-w-0">
                @isset($header)
                    {{ $header }}
                @else
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 rounded-full bg-gray-900 dark:bg-white"></span>

                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                            Panel de administración
                        </span>
                    </div>
                @endisset
            </div>

            <div class="flex items-center gap-2">

               @auth

    @php
        $unreadNotifications = auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->count();

        $latestNotifications = auth()->user()
            ->notifications()
            ->latest()
            ->limit(5)
            ->get();
    @endphp

    <div
        class="relative"
        x-data="{ open: false }"
        @keydown.escape.window="open = false"
    >

        {{-- Botón de notificaciones --}}
        <button
            type="button"
            @click="open = !open"
            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white dark:focus:ring-white/10"
            aria-label="Notificaciones"
            :aria-expanded="open.toString()"
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
                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"
                />
            </svg>

            @if ($unreadNotifications > 0)
                <span class="absolute right-1 top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-gray-900 px-1 text-[9px] font-bold leading-none text-white ring-2 ring-white dark:bg-white dark:text-gray-900 dark:ring-gray-900">
                    {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                </span>
            @endif
        </button>


        {{-- Desplegable --}}
        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
            @click.outside="open = false"
            class="absolute right-0 z-50 mt-3 w-[380px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl shadow-gray-900/10 dark:border-gray-800 dark:bg-gray-900 dark:shadow-black/30"
        >

            {{-- Cabecera --}}
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">

                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        Notificaciones
                    </p>

                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                        {{ $unreadNotifications }} sin leer
                    </p>
                </div>

                <a
                    href="{{ route('notifications.index') }}"
                    class="text-xs font-semibold text-gray-600 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                    @click="open = false"
                >
                    Ver todas
                </a>

            </div>


            {{-- Lista --}}
            <div class="max-h-[420px] overflow-y-auto">

                @forelse ($latestNotifications as $notification)

                    <div
                        class="border-b border-gray-100 px-5 py-4 last:border-b-0 dark:border-gray-800 {{ $notification->read_at ? '' : 'bg-gray-50 dark:bg-gray-800/50' }}"
                    >

                        <div class="flex items-start gap-3">

                            {{-- Icono --}}
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $notification->read_at ? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' : 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' }}"
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
                                        d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"
                                    />
                                </svg>
                            </div>


                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <div class="flex items-center gap-2">

                                            <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $notification->title }}
                                            </p>

                                            @if (!$notification->read_at)
                                                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-gray-900 dark:bg-white"></span>
                                            @endif

                                        </div>

                                        <p class="mt-1 line-clamp-2 text-xs leading-5 text-gray-500 dark:text-gray-400">
                                            {{ $notification->message }}
                                        </p>

                                        <p class="mt-2 text-[11px] text-gray-400 dark:text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Acción --}}
                                <div class="mt-3">

                                    @if ($notification->url)

                                        <form
                                            method="POST"
                                            action="{{ route('notifications.read', $notification) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 transition hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                                                @click="open = false"
                                            >
                                                Ver contenido

                                                <svg
                                                    class="h-3.5 w-3.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M9 5l7 7-7 7"
                                                    />
                                                </svg>
                                            </button>
                                        </form>

                                    @elseif (!$notification->read_at)

                                        <form
                                            method="POST"
                                            action="{{ route('notifications.read', $notification) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="text-xs font-semibold text-gray-600 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                                                @click="open = false"
                                            >
                                                Marcar como leída
                                            </button>
                                        </form>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-10 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">

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
                                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"
                                />
                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-semibold text-gray-900 dark:text-white">
                            No tienes notificaciones
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Aquí aparecerán tus próximos avisos.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Pie --}}
            @if ($latestNotifications->count() > 0)

                <div class="border-t border-gray-100 bg-gray-50 px-5 py-3 dark:border-gray-800 dark:bg-gray-800/30">

                    <a
                        href="{{ route('notifications.index') }}"
                        class="flex items-center justify-center text-xs font-semibold text-gray-600 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        @click="open = false"
                    >
                        Abrir centro de notificaciones
                    </a>

                </div>

            @endif

        </div>

    </div>

@endauth

                <div class="mx-1 h-6 w-px bg-gray-200 dark:bg-gray-800"></div>

                <a
                    href="{{ route('profile.edit') }}"
                    class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                >
                    Perfil
                </a>

            </div>

        </header>

        {{-- Cabecera móvil --}}
        <div class="lg:hidden">
            @isset($header)
                <div class="border-b border-gray-200 bg-white px-5 py-4 dark:border-gray-800 dark:bg-gray-900">
                    {{ $header }}
                </div>
            @endisset
        </div>

        {{-- Contenido --}}
        <main class="p-5 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>

    </div>

</body>
</html>