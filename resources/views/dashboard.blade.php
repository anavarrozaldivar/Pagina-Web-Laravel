<x-app-layout>

<x-slot name="header">
    <div>
        <h2 class="text-xl font-semibold leading-tight text-gray-900 dark:text-white">
            Dashboard
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Resumen general de la aplicación
        </p>
    </div>
</x-slot>

@php
    $user = Auth::user();

    $user->loadMissing('roleRelation.permissions');

    $role = $user->roleRelation;

    $isAdmin = $role?->name === 'admin';

    $roleLabel = $role?->label ?? 'Usuario';

    $hasPermission = function (string $permission) use ($user, $isAdmin): bool {
        if ($isAdmin) {
            return true;
        }

        return $user->roleRelation?->permissions?->contains('name', $permission) ?? false;
    };

    $recentActivities = \App\Models\ActivityLog::with('user')
        ->latest()
        ->take(6)
        ->get();

    $usersCount = \App\Models\User::count();

    $contentsCount = \App\Models\Content::count();

    $notificationsCount = \App\Models\Notification::count();

    $activitiesCount = \App\Models\ActivityLog::count();

    $todayActivities = \App\Models\ActivityLog::whereDate(
        'created_at',
        today()
    )->count();

    $unreadNotificationsCount = \App\Models\Notification::whereNull(
        'read_at'
    )->count();

    $publishedContentsCount = \App\Models\Content::where(
        'status',
        'published'
    )->count();

    $newUsersToday = \App\Models\User::whereDate(
        'created_at',
        today()
    )->count();

    $usersLast7Days = \App\Models\User::where(
        'created_at',
        '>=',
        now()->subDays(6)->startOfDay()
    )->count();

    $activitiesLast7Days = \App\Models\ActivityLog::where(
        'created_at',
        '>=',
        now()->subDays(6)->startOfDay()
    )->count();

    $activityByDay = \App\Models\ActivityLog::query()
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->where(
            'created_at',
            '>=',
            now()->subDays(6)->startOfDay()
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $activityChart = collect(range(6, 0))->map(
        function ($daysAgo) use ($activityByDay) {
            $date = now()
                ->subDays($daysAgo)
                ->startOfDay();

            $activity = $activityByDay->firstWhere(
                'date',
                $date->format('Y-m-d')
            );

            return [
                'label' => $date->format('d/m'),
                'value' => (int) ($activity?->total ?? 0),
            ];
        }
    );

    $chartMax = max(
        1,
        (int) $activityChart->max('value')
    );

    $chartPoints = $activityChart
        ->values()
        ->map(function ($item, $index) use ($activityChart, $chartMax) {
            $width = 720;
            $height = 240;

            $paddingX = 24;
            $paddingY = 24;

            $usableWidth = $width - ($paddingX * 2);
            $usableHeight = $height - ($paddingY * 2);

            $steps = max(1, $activityChart->count() - 1);

            $x = $paddingX + (
                $index / $steps
            ) * $usableWidth;

            $y = $height - $paddingY - (
                $item['value'] / $chartMax
            ) * $usableHeight;

            return [
                'x' => round($x, 2),
                'y' => round($y, 2),
            ];
        });

    $chartPolyline = $chartPoints
        ->map(fn ($point) => $point['x'] . ',' . $point['y'])
        ->implode(' ');

    $lastActivityPoint = $chartPoints->last();

    $firstPoint = $chartPoints->first();

    $lastPoint = $chartPoints->last();

    $areaPath = '';

    if ($firstPoint && $lastPoint) {
        $areaPath = 'M ' .
            $firstPoint['x'] . ' ' . 264 .
            ' L ' .
            collect($chartPoints)
                ->map(fn ($point) => $point['x'] . ' ' . $point['y'])
                ->implode(' L ') .
            ' L ' .
            $lastPoint['x'] . ' ' . 264 .
            ' Z';
    }
@endphp

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Bienvenida --}}
    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

        <div class="relative overflow-hidden p-6 sm:p-8">

            <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gray-100 dark:bg-gray-800"></div>

            <div class="absolute -bottom-20 right-32 h-40 w-40 rounded-full bg-gray-50 dark:bg-gray-800/60"></div>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">

                <div class="min-w-0">

                    <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Sistema operativo
                    </div>

                    <p class="mt-5 text-sm font-medium text-gray-500 dark:text-gray-400">
                        Bienvenido de nuevo
                    </p>

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-3xl">
                        {{ $user->name }}
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Gestiona usuarios, contenido, notificaciones y actividad
                        desde un único espacio de administración.
                    </p>

                </div>

                <div class="shrink-0 rounded-2xl border border-gray-200 bg-white px-5 py-4 dark:border-gray-700 dark:bg-gray-900">

                    <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">
                        Tu rol
                    </p>

                    <div class="mt-2 flex items-center gap-2">

                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-900 text-xs font-bold text-white dark:bg-white dark:text-gray-900">
                            {{ strtoupper(substr($roleLabel, 0, 1)) }}
                        </div>

                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $roleLabel }}
                        </p>

                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- KPIs principales --}}
    <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

        @if ($hasPermission('users.view'))

            <a
                href="{{ route('admin.users.index') }}"
                class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
            >
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            Usuarios
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $usersCount }}
                        </p>

                        <div class="mt-2 flex items-center gap-2 text-xs">
                            <span class="rounded-full bg-gray-100 px-2 py-1 font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                +{{ $newUsersToday }}
                            </span>

                            <span class="text-gray-400">
                                nuevos hoy
                            </span>
                        </div>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">

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
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-1a4 4 0 100-8 4 4 0 000 8zm4 11v-2a4 4 0 00-3-3.87"
                            />
                        </svg>

                    </div>

                </div>
            </a>

        @endif

        @if ($hasPermission('contents.view'))

            <a
                href="{{ route('admin.contents.index') }}"
                class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
            >
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            Contenido
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $contentsCount }}
                        </p>

                        <div class="mt-2 flex items-center gap-2 text-xs">
                            <span class="rounded-full bg-gray-100 px-2 py-1 font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                {{ $publishedContentsCount }}
                            </span>

                            <span class="text-gray-400">
                                publicados
                            </span>
                        </div>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">

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
                                d="M4 5h16M4 12h16M4 19h16"
                            />
                        </svg>

                    </div>

                </div>
            </a>

        @endif

        <a
            href="{{ route('notifications.index') }}"
            class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
        >
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                        Notificaciones
                    </p>

                    <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $notificationsCount }}
                    </p>

                    <div class="mt-2 flex items-center gap-2 text-xs">
                        <span class="rounded-full bg-gray-100 px-2 py-1 font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                            {{ $unreadNotificationsCount }}
                        </span>

                        <span class="text-gray-400">
                            sin leer
                        </span>
                    </div>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">

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

                </div>

            </div>
        </a>

        @if ($isAdmin)

            <a
                href="{{ route('admin.activity.index') }}"
                class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-lg dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
            >
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            Auditoría
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $activitiesCount }}
                        </p>

                        <div class="mt-2 flex items-center gap-2 text-xs">
                            <span class="rounded-full bg-gray-100 px-2 py-1 font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                {{ $todayActivities }}
                            </span>

                            <span class="text-gray-400">
                                hoy
                            </span>
                        </div>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">

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
                                d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                    </div>

                </div>
            </a>

        @endif

    </section>

    {{-- Gráfico + resumen --}}
    <section class="grid gap-5 xl:grid-cols-[minmax(0,1.6fr)_minmax(320px,0.8fr)]">

        {{-- Actividad --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Actividad del sistema
                    </h2>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Acciones registradas durante los últimos 7 días.
                    </p>
                </div>

                <div class="flex items-center gap-2">

                    <div class="rounded-xl bg-gray-50 px-3 py-2 dark:bg-gray-800">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">
                            Usuarios
                        </p>

                        <p class="mt-0.5 text-sm font-bold text-gray-900 dark:text-white">
                            {{ $usersLast7Days }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-gray-50 px-3 py-2 dark:bg-gray-800">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-gray-400">
                            Eventos
                        </p>

                        <p class="mt-0.5 text-sm font-bold text-gray-900 dark:text-white">
                            {{ $activitiesLast7Days }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="p-5 sm:p-6">

                <div class="h-72 w-full">

                    <svg
                        viewBox="0 0 720 280"
                        class="h-full w-full overflow-visible"
                        preserveAspectRatio="none"
                    >

                        {{-- Grid --}}
                        <line
                            x1="24"
                            y1="24"
                            x2="696"
                            y2="24"
                            stroke="currentColor"
                            class="text-gray-100 dark:text-gray-800"
                            stroke-width="1"
                        />

                        <line
                            x1="24"
                            y1="84"
                            x2="696"
                            y2="84"
                            stroke="currentColor"
                            class="text-gray-100 dark:text-gray-800"
                            stroke-width="1"
                        />

                        <line
                            x1="24"
                            y1="144"
                            x2="696"
                            y2="144"
                            stroke="currentColor"
                            class="text-gray-100 dark:text-gray-800"
                            stroke-width="1"
                        />

                        <line
                            x1="24"
                            y1="204"
                            x2="696"
                            y2="204"
                            stroke="currentColor"
                            class="text-gray-100 dark:text-gray-800"
                            stroke-width="1"
                        />

                        <line
                            x1="24"
                            y1="264"
                            x2="696"
                            y2="264"
                            stroke="currentColor"
                            class="text-gray-100 dark:text-gray-800"
                            stroke-width="1"
                        />

                        {{-- Área --}}
                        @if ($areaPath)
                            <path
                                d="{{ $areaPath }}"
                                fill="currentColor"
                                class="text-gray-100 dark:text-gray-800/80"
                            />
                        @endif

                        {{-- Línea --}}
                        @if ($chartPolyline)
                            <polyline
                                points="{{ $chartPolyline }}"
                                fill="none"
                                stroke="currentColor"
                                class="text-gray-900 dark:text-white"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        @endif

                        {{-- Puntos --}}
                        @foreach ($chartPoints as $point)
                            <circle
                                cx="{{ $point['x'] }}"
                                cy="{{ $point['y'] }}"
                                r="4"
                                fill="currentColor"
                                class="text-gray-900 dark:text-white"
                            />

                            <circle
                                cx="{{ $point['x'] }}"
                                cy="{{ $point['y'] }}"
                                r="7"
                                fill="none"
                                stroke="currentColor"
                                class="text-gray-900/10 dark:text-white/10"
                                stroke-width="1"
                            />
                        @endforeach

                    </svg>

                </div>

                <div class="mt-3 grid grid-cols-7 gap-2">
                    @foreach ($activityChart as $day)
                        <div class="text-center text-[11px] font-medium text-gray-400 dark:text-gray-500">
                            {{ $day['label'] }}
                        </div>
                    @endforeach
                </div>

            </div>

        </div>

        {{-- Resumen --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Resumen
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Estado actual de la aplicación.
                </p>
            </div>

            <div class="mt-6 space-y-3">

                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 dark:bg-gray-800">
                    <div>
                        <p class="text-xs text-gray-400">
                            Usuarios
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $usersCount }}
                        </p>
                    </div>

                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ $newUsersToday }} hoy
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 dark:bg-gray-800">
                    <div>
                        <p class="text-xs text-gray-400">
                            Contenido publicado
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $publishedContentsCount }}
                        </p>
                    </div>

                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ $contentsCount }} total
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 dark:bg-gray-800">
                    <div>
                        <p class="text-xs text-gray-400">
                            Notificaciones
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $notificationsCount }}
                        </p>
                    </div>

                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ $unreadNotificationsCount }} sin leer
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 dark:bg-gray-800">
                    <div>
                        <p class="text-xs text-gray-400">
                            Actividad
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $activitiesCount }}
                        </p>
                    </div>

                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ $todayActivities }} hoy
                    </span>
                </div>

            </div>

        </div>

    </section>

    {{-- Actividad reciente --}}
    @if ($isAdmin)

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Actividad reciente
                    </h2>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Últimas acciones realizadas en la aplicación.
                    </p>
                </div>

                <a
                    href="{{ route('admin.activity.index') }}"
                    class="inline-flex items-center text-sm font-semibold text-gray-700 transition hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                >
                    Ver todo

                    <svg
                        class="ml-1.5 h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M5 12h14m-5-5l5 5-5 5"
                        />
                    </svg>
                </a>

            </div>

            <div class="divide-y divide-gray-100 dark:divide-gray-800">

                @forelse ($recentActivities as $activity)

                    @php
                        $action = strtolower($activity->action);

                        $activityStyle = match ($action) {
                            'created', 'create' => [
                                'label' => 'Creado',
                                'icon' => '+',
                            ],
                            'updated', 'update' => [
                                'label' => 'Actualizado',
                                'icon' => '↻',
                            ],
                            'deleted', 'delete' => [
                                'label' => 'Eliminado',
                                'icon' => '−',
                            ],
                            'login' => [
                                'label' => 'Inicio de sesión',
                                'icon' => '→',
                            ],
                            'logout' => [
                                'label' => 'Cierre de sesión',
                                'icon' => '←',
                            ],
                            default => [
                                'label' => ucfirst($activity->action),
                                'icon' => '•',
                            ],
                        };
                    @endphp

                    <a
                        href="{{ route('admin.activity.show', $activity) }}"
                        class="group flex items-center gap-4 px-6 py-4 transition hover:bg-gray-50 dark:hover:bg-gray-800/60"
                    >

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-sm font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                            {{ $activityStyle['icon'] }}
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $activity->description }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->user?->name ?? 'Sistema' }}

                                <span class="mx-1">
                                    ·
                                </span>

                                {{ $activity->created_at->diffForHumans() }}
                            </p>

                        </div>

                        <span class="hidden shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300 sm:inline-flex">
                            {{ $activityStyle['label'] }}
                        </span>

                        <svg
                            class="h-4 w-4 shrink-0 text-gray-300 transition group-hover:translate-x-0.5 group-hover:text-gray-600 dark:text-gray-600 dark:group-hover:text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M5 12h14m-5-5l5 5-5 5"
                            />
                        </svg>

                    </a>

                @empty

                    <div class="px-6 py-14 text-center">

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
                                    d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>

                        <p class="mt-4 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Todavía no hay actividad
                        </p>

                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                            Las acciones realizadas aparecerán aquí automáticamente.
                        </p>

                    </div>

                @endforelse

            </div>

        </section>

    @endif

    {{-- Acciones rápidas --}}
    @if (
        $hasPermission('users.create') ||
        $hasPermission('contents.create') ||
        $hasPermission('notifications.create')
    )

        <section>

            <div class="mb-4">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Acciones rápidas
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Accede directamente a las tareas más utilizadas.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                @if ($hasPermission('users.create'))

                    <a
                        href="{{ route('admin.users.create') }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
                    >
                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">
                                +
                            </div>

                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    Crear usuario
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Añade una nueva cuenta.
                                </p>
                            </div>

                        </div>
                    </a>

                @endif

                @if ($hasPermission('contents.create'))

                    <a
                        href="{{ route('admin.contents.create') }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
                    >
                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">
                                +
                            </div>

                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    Crear contenido
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Añade contenido nuevo.
                                </p>
                            </div>

                        </div>
                    </a>

                @endif

                @if ($hasPermission('notifications.create'))

                    <a
                        href="{{ route('admin.notifications.create') }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700"
                    >
                        <div class="flex items-center gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-200 dark:group-hover:bg-white dark:group-hover:text-gray-900">
                                +
                            </div>

                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    Enviar notificación
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Envía un aviso a un usuario.
                                </p>
                            </div>

                        </div>
                    </a>

                @endif

            </div>

        </section>

    @endif

</div>

</x-app-layout>
