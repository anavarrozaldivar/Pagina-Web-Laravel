@php
$currentUser = Auth::user();

if ($currentUser) {
    $currentUser->loadMissing('roleRelation.permissions');
}

$isAdmin = $currentUser?->roleRelation?->name === 'admin';

$appName = \App\Models\Setting::where('key', 'app_name')->value('value')
    ?? config('app.name', 'Starter Kit');

$appName = in_array($appName, ['Laravel', 'Laravel Admin Kit'], true)
    ? 'Admin Kit'
    : $appName;

$logoPath = \App\Models\Setting::where('key', 'logo_path')->value('value');

$hasPermission = function (string $permission) use ($currentUser, $isAdmin): bool {
    if ($isAdmin) {
        return true;
    }

    return $currentUser?->roleRelation?->permissions?->contains('name', $permission) ?? false;
};

@endphp

<nav x-data="{ open: false }" class="relative">

{{-- Sidebar desktop --}}
<aside
    class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-gray-200 bg-white lg:flex lg:flex-col dark:border-gray-800 dark:bg-gray-900"
>

    {{-- Brand --}}
    <div class="flex h-16 shrink-0 items-center border-b border-gray-200 px-5 dark:border-gray-800">
        <a
            href="{{ $isAdmin ? route('dashboard') : route('user.dashboard') }}"
            class="flex min-w-0 items-center gap-3"
        >

            @if ($logoPath)
                <img
                    src="{{ filter_var($logoPath, FILTER_VALIDATE_URL) ? $logoPath : asset(ltrim($logoPath, '/')) }}"
                    alt="{{ $appName }}"
                    class="h-9 w-9 shrink-0 rounded-xl object-cover shadow-sm"
                >
            @else
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">
                    {{ strtoupper(substr($appName, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0">
                <div class="truncate text-sm font-bold text-gray-900 dark:text-white">
                    {{ $appName }}
                </div>

                <div class="mt-0.5 text-[11px] font-medium text-gray-400 dark:text-gray-500">
                    Administration
                </div>
            </div>

        </a>
    </div>

    {{-- Navigation --}}
    <div class="flex-1 overflow-y-auto px-3 py-5">

        {{-- Overview --}}
        <div class="mb-7">
            <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[0.16em] text-gray-400 dark:text-gray-500">
                Overview
            </p>

            <a
                href="{{ $isAdmin ? route('dashboard') : route('user.dashboard') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                {{ request()->routeIs($isAdmin ? 'dashboard' : 'user.dashboard')
                    ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
            >
                <svg
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                    />
                </svg>

                <span>{{ $isAdmin ? 'Dashboard' : 'Mi panel' }}</span>
            </a>
        </div>

        {{-- Gestión --}}
        <div>
            <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[0.16em] text-gray-400 dark:text-gray-500">
                Gestión
            </p>

            <div class="space-y-1">

                {{-- Usuarios --}}
                @if ($hasPermission('users.view'))
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.users.*')
                            ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-1a4 4 0 100-8 4 4 0 000 8zm4 11v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                            />
                        </svg>

                        <span>Usuarios</span>
                    </a>
                @endif

                {{-- Roles --}}
                @if ($hasPermission('roles.view'))
                    <a
                        href="{{ route('admin.roles.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.roles.*')
                            ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
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

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9.5 12l1.8 1.8L15 10"
                            />
                        </svg>

                        <span>Roles</span>
                    </a>
                @endif

                {{-- Contenido --}}
                @if ($hasPermission('contents.view'))
                    <a
                        href="{{ route('admin.contents.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.contents.*')
                            ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 7h8M8 11h8M8 15h5"
                            />
                        </svg>

                        <span>Contenido</span>
                    </a>
                @endif

                {{-- Notificaciones --}}
                <a
                    href="{{ route('notifications.index') }}"
                    class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('notifications.*') || request()->routeIs('admin.notifications.*')
                        ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
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

                    <span>Notificaciones</span>
                </a>

                {{-- Enviar notificación --}}
                @if ($hasPermission('notifications.create'))
                    <a
                        href="{{ route('admin.notifications.create') }}"
                        class="ml-4 flex items-center gap-3 rounded-xl px-3 py-2 text-xs font-medium transition
                        {{ request()->routeIs('admin.notifications.create')
                            ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white'
                            : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300' }}"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                        <span>Enviar notificación</span>
                    </a>
                @endif

                {{-- Actividad --}}
                @if ($hasPermission('activity.view'))
                    <a
                        href="{{ route('admin.activity.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.activity.*')
                            ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 19h16M4 15h10M4 11h16M4 7h10M4 3h16"
                            />
                        </svg>

                        <span>Actividad</span>
                    </a>
                @endif

                {{-- Configuración --}}
                @if ($isAdmin)

                    <div class="my-3 border-t border-gray-100 dark:border-gray-800"></div>

                    <a
                        href="{{ route('admin.settings.edit') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.settings.*')
                            ? 'bg-gray-900 text-white shadow-sm dark:bg-white dark:text-gray-900'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.8 1.8-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V20h-2.55v-.1a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.8-1.8-.06-.06A1.7 1.7 0 008.1 15a1.7 1.7 0 00-1.56-1.03H6V11.4h.54A1.7 1.7 0 008.1 10.37a1.7 1.7 0 00-.34-1.88L7.7 8.43l1.8-1.8.06.06a1.7 1.7 0 001.88.34A1.7 1.7 0 0012.47 5.5V5h2.55v.5a1.7 1.7 0 001.03 1.53 1.7 1.7 0 001.88-.34l-.06-.06 1.8 1.8-.06.06a1.7 1.7 0 00-.34 1.88A1.7 1.7 0 0019.95 11H20v2.55h-.54A1.7 1.7 0 0019.4 15z"
                            />
                        </svg>

                        <span>Configuración</span>
                    </a>

                @endif

            </div>
        </div>
    </div>
</div>

{{-- Usuario --}}
<div class="border-t border-gray-200 p-3 dark:border-gray-800">

    <div class="rounded-xl bg-gray-50 px-3 py-3 dark:bg-gray-800/70">
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-xs font-bold text-white dark:bg-white dark:text-gray-900">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                    {{ Auth::user()->name }}
                </p>

                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    {{ Auth::user()->email }}
                </p>
            </div>

        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf

        <button
            type="submit"
            class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
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
                    d="M15 12H3m0 0l4-4m-4 4l4 4M21 5v14a2 2 0 01-2 2h-6"
                />
            </svg>

            <span>Cerrar sesión</span>
        </button>
    </form>

</div>

</aside>

{{-- Mobile header --}}
<div class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4 lg:hidden dark:border-gray-800 dark:bg-gray-900">

    <a
        href="{{ $isAdmin ? route('dashboard') : route('user.dashboard') }}"
        class="flex min-w-0 items-center gap-3"
    >

        @if ($logoPath)
            <img
                src="{{ filter_var($logoPath, FILTER_VALIDATE_URL) ? $logoPath : asset(ltrim($logoPath, '/')) }}"
                alt="{{ $appName }}"
                class="h-9 w-9 shrink-0 rounded-xl object-cover shadow-sm"
            >
        @else
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">
                {{ strtoupper(substr($appName, 0, 1)) }}
            </div>
        @endif

        <span class="truncate text-sm font-bold text-gray-900 dark:text-white">
            {{ $appName }}
        </span>

    </a>

    <button
        type="button"
        @click="open = !open"
        class="rounded-xl p-2 text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
        aria-label="Abrir menú"
    >
        <svg
            x-show="!open"
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.8"
                d="M4 6h16M4 12h16M4 18h16"
            />
        </svg>

        <svg
            x-show="open"
            x-cloak
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.8"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
    </button>

</div>

{{-- Mobile menu --}}
<div
    x-show="open"
    x-cloak
    x-transition
    @click.outside="open = false"
    class="absolute left-0 right-0 top-16 z-50 border-b border-gray-200 bg-white shadow-xl lg:hidden dark:border-gray-800 dark:bg-gray-900"
>
    <div class="max-h-[calc(100vh-4rem)] space-y-1 overflow-y-auto p-4">

        <a
            href="{{ $isAdmin ? route('dashboard') : route('user.dashboard') }}"
            @click="open = false"
            class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
            {{ request()->routeIs($isAdmin ? 'dashboard' : 'user.dashboard')
                ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
        >
            {{ $isAdmin ? 'Dashboard' : 'Mi panel' }}
        </a>

        @if ($hasPermission('users.view'))
            <a
                href="{{ route('admin.users.index') }}"
                @click="open = false"
                class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
                {{ request()->routeIs('admin.users.*')
                    ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
            >
                Usuarios
            </a>
        @endif

        @if ($hasPermission('roles.view'))
            <a
                href="{{ route('admin.roles.index') }}"
                @click="open = false"
                class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
                {{ request()->routeIs('admin.roles.*')
                    ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
            >
                Roles
            </a>
        @endif

        @if ($hasPermission('contents.view'))
            <a
                href="{{ route('admin.contents.index') }}"
                @click="open = false"
                class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
                {{ request()->routeIs('admin.contents.*')
                    ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
            >
                Contenido
            </a>
        @endif

        <a
            href="{{ route('notifications.index') }}"
            @click="open = false"
            class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
            {{ request()->routeIs('notifications.*') || request()->routeIs('admin.notifications.*')
                ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
        >
            Notificaciones
        </a>

        @if ($hasPermission('notifications.create'))
            <a
                href="{{ route('admin.notifications.create') }}"
                @click="open = false"
                class="ml-4 flex items-center rounded-xl px-3 py-2 text-xs font-medium
                {{ request()->routeIs('admin.notifications.create')
                    ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white'
                    : 'text-gray-500 hover:bg-gray-50 dark:text-gray-500 dark:hover:bg-gray-800' }}"
            >
                Enviar notificación
            </a>
        @endif

        @if ($hasPermission('activity.view'))
            <a
                href="{{ route('admin.activity.index') }}"
                @click="open = false"
                class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
                {{ request()->routeIs('admin.activity.*')
                    ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
            >
                Actividad
            </a>
        @endif

        @if ($isAdmin)
            <a
                href="{{ route('admin.settings.edit') }}"
                @click="open = false"
                class="flex items-center rounded-xl px-3 py-3 text-sm font-medium
                {{ request()->routeIs('admin.settings.*')
                    ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
            >
                Configuración
            </a>
        @endif

        <div class="my-3 border-t border-gray-200 dark:border-gray-800"></div>

        <a
            href="{{ route('profile.edit') }}"
            @click="open = false"
            class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
        >
            Perfil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
            >
                Cerrar sesión
            </button>
        </form>

    </div>
</div>

</nav>
