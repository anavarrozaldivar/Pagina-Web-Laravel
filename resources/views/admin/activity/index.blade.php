<x-app-layout>

    @php
        $actionLabels = [
            'created' => 'Creado',
            'updated' => 'Modificado',
            'deleted' => 'Eliminado',
            'login' => 'Inicio de sesión',
            'logout' => 'Cierre de sesión',
            'viewed' => 'Consultado',
            'restored' => 'Restaurado',
        ];

        $actionIcons = [
            'created' => 'plus',
            'updated' => 'edit',
            'deleted' => 'trash',
            'login' => 'login',
            'logout' => 'logout',
            'viewed' => 'eye',
            'restored' => 'restore',
        ];

        $hasFilters =
            request('search')
            || request('action')
            || request('user_id')
            || request('date');

        $currentActionLabel = request('action')
            ? ($actionLabels[request('action')] ?? ucfirst(request('action')))
            : null;
    @endphp

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                    Administración
                </p>

                <div class="mt-1 flex flex-wrap items-center gap-3">

                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Auditoría
                    </h1>

                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {{ $activities->total() }}
                        {{ $activities->total() === 1 ? 'registro' : 'registros' }}
                    </span>

                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Consulta el historial de acciones realizadas dentro de la aplicación.
                </p>

            </div>

            @if ($hasFilters)

                <div class="inline-flex items-center gap-2 self-start rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-gray-600 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 lg:self-auto">

                    <span class="h-2 w-2 rounded-full bg-gray-900 dark:bg-white"></span>

                    Filtros activos

                </div>

            @endif

        </div>


        {{-- Resumen --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Registros totales', 'value' => $activityStats['total'], 'detail' => 'Historial completo', 'tone' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/30 dark:text-blue-300'],
                ['label' => 'Hoy', 'value' => $activityStats['today'], 'detail' => 'Acciones registradas', 'tone' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300'],
                ['label' => 'Esta semana', 'value' => $activityStats['thisWeek'], 'detail' => 'Desde el lunes', 'tone' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-300'],
                ['label' => 'Usuarios activos', 'value' => $activityStats['activeUsers'], 'detail' => 'Últimos 7 días', 'tone' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/30 dark:text-indigo-300'],
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


        {{-- Filtros --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Filtros de actividad
                        </h2>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Filtra el historial por acción, usuario, fecha o texto.
                        </p>
                    </div>

                    @if ($hasFilters)

                        <a
                            href="{{ route('admin.activity.index') }}"
                            class="text-xs font-semibold text-gray-500 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        >
                            Restablecer filtros
                        </a>

                    @endif

                </div>

            </div>


            <form
                method="GET"
                action="{{ route('admin.activity.index') }}"
                class="p-6"
            >

                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">

                    {{-- Buscar --}}
                    <div>

                        <label
                            for="search"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Buscar
                        </label>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Acción o descripción
                        </p>

                        <div class="relative mt-3">

                            <svg
                                class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                            <input
                                id="search"
                                name="search"
                                type="text"
                                value="{{ request('search') }}"
                                placeholder="Buscar actividad..."
                                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white dark:focus:ring-white/10"
                            >

                        </div>

                    </div>


                    {{-- Acción --}}
                    <div>

                        <label
                            for="action"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Acción
                        </label>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Tipo de actividad registrada
                        </p>

                        <select
                            id="action"
                            name="action"
                            class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white/10"
                        >

                            <option value="">
                                Todas las acciones
                            </option>

                            @foreach ($actions as $action)

                                <option
                                    value="{{ $action }}"
                                    @selected(request('action') === $action)
                                >
                                    {{ $actionLabels[$action] ?? ucfirst($action) }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Usuario --}}
                    <div>

                        <label
                            for="user_id"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Usuario
                        </label>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Usuario que realizó la acción
                        </p>

                        <select
                            id="user_id"
                            name="user_id"
                            class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white/10"
                        >

                            <option value="">
                                Todos los usuarios
                            </option>

                            @foreach ($users as $user)

                                <option
                                    value="{{ $user->id }}"
                                    @selected((string) request('user_id') === (string) $user->id)
                                >
                                    {{ $user->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Fecha --}}
                    <div>

                        <label
                            for="date"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Fecha
                        </label>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Día concreto de actividad
                        </p>

                        <input
                            id="date"
                            name="date"
                            type="date"
                            value="{{ request('date') }}"
                            class="mt-3 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white/10"
                        >

                    </div>

                </div>


                {{-- Acciones filtros --}}
                <div class="mt-5 flex flex-col gap-3 border-t border-gray-100 pt-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">

                    <div class="text-xs text-gray-500 dark:text-gray-400">

                        @if ($hasFilters)

                            Mostrando resultados filtrados

                        @else

                            Mostrando toda la actividad registrada

                        @endif

                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row">

                        @if ($hasFilters)

                            <a
                                href="{{ route('admin.activity.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                            >
                                Limpiar
                            </a>

                        @endif

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 dark:focus:ring-white/20"
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
                                    d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                            Aplicar filtros

                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- Resumen de filtros --}}
        @if ($hasFilters)

            <div class="flex flex-wrap items-center gap-2">

                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                    Filtros:
                </span>

                @if (request('search'))

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        Búsqueda: {{ request('search') }}
                    </span>

                @endif

                @if ($currentActionLabel)

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        Acción: {{ $currentActionLabel }}
                    </span>

                @endif

                @if (request('user_id'))

                    @php
                        $selectedUser = $users->firstWhere('id', (int) request('user_id'));
                    @endphp

                    @if ($selectedUser)

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            Usuario: {{ $selectedUser->name }}
                        </span>

                    @endif

                @endif

                @if (request('date'))

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        Fecha: {{ request('date') }}
                    </span>

                @endif

            </div>

        @endif


        {{-- Registro --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Registro de actividad
                        </h2>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Mostrando
                            {{ $activities->firstItem() ?? 0 }}–{{ $activities->lastItem() ?? 0 }}
                            de {{ $activities->total() }} registros
                        </p>

                    </div>

                    @if ($activities->total() > 0)

                        <span class="text-xs font-medium text-gray-400 dark:text-gray-500">
                            Más recientes primero
                        </span>

                    @endif

                </div>

            </div>


            @forelse ($activities as $activity)

                @php
                    $label = $actionLabels[$activity->action] ?? ucfirst($activity->action);
                    $icon = $actionIcons[$activity->action] ?? 'default';
                @endphp

                <a
                    href="{{ route('admin.activity.show', $activity) }}"
                    class="group block border-b border-gray-100 px-5 py-5 transition last:border-b-0 hover:bg-gray-50 sm:px-6 dark:border-gray-800 dark:hover:bg-gray-800/50"
                >

                    <div class="flex items-start gap-4">

                        {{-- Icono --}}
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-600 transition group-hover:bg-gray-900 group-hover:text-white dark:bg-gray-800 dark:text-gray-300 dark:group-hover:bg-white dark:group-hover:text-gray-900">

                            @if ($icon === 'plus')

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
                                        d="M12 5v14M5 12h14"
                                    />
                                </svg>

                            @elseif ($icon === 'edit')

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
                                        d="M15.232 5.232l3.536 3.536M4 20h4l10.768-10.768a2.5 2.5 0 00-3.536-3.536L4 16.464V20z"
                                    />
                                </svg>

                            @elseif ($icon === 'trash')

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
                                        d="M6 7h12m-9 0v10m6-10v10M9 7l1-3h4l1 3m-7 0h8m-9 0-1 13h12L17 7"
                                    />
                                </svg>

                            @elseif ($icon === 'login')

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
                                        d="M10 17l5-5-5-5M15 12H3M21 4v16"
                                    />
                                </svg>

                            @elseif ($icon === 'logout')

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
                                        d="M14 17l5-5-5-5M19 12H7M3 4v16"
                                    />
                                </svg>

                            @elseif ($icon === 'eye')

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
                                        d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                        stroke-width="1.8"
                                    />
                                </svg>

                            @elseif ($icon === 'restore')

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
                                        d="M4 7v5h5M20 17v-5h-5M5.2 12a7 7 0 0112.9-3.7L20 12M4 12a7 7 0 0012.9 3.7L20 12"
                                    />
                                </svg>

                            @else

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="8"
                                        stroke-width="1.8"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="1"
                                        fill="currentColor"
                                        stroke="none"
                                    />
                                </svg>

                            @endif

                        </div>


                        {{-- Contenido --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                            {{ $label }}
                                        </span>

                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $activity->user?->name ?? 'Sistema' }}
                                        </span>

                                    </div>


                                    <p class="mt-2 text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                                        {{ $activity->description }}
                                    </p>


                                    <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-400 dark:text-gray-500">

                                        <span>
                                            {{ $activity->created_at->format('d/m/Y H:i') }}
                                        </span>

                                        <span class="text-gray-300 dark:text-gray-700">
                                            ·
                                        </span>

                                        <span>
                                            {{ $activity->created_at->diffForHumans() }}
                                        </span>

                                        <span class="text-gray-300 dark:text-gray-700">
                                            ·
                                        </span>

                                        <span>
                                            ID #{{ $activity->id }}
                                        </span>

                                    </div>

                                </div>


                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-gray-300 transition group-hover:bg-gray-100 group-hover:text-gray-700 dark:text-gray-600 dark:group-hover:bg-gray-800 dark:group-hover:text-gray-300">

                                    <svg
                                        class="h-4 w-4 transition group-hover:translate-x-0.5"
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

                                </div>

                            </div>

                        </div>

                    </div>

                </a>

            @empty

                {{-- Estado vacío --}}
                <div class="px-6 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 8v4l3 2"
                            />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-base font-bold text-gray-900 dark:text-white">
                        No hay actividad registrada
                    </h3>

                    <p class="mx-auto mt-1.5 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400">
                        No se encontraron registros que coincidan con los filtros seleccionados.
                    </p>


                    @if ($hasFilters)

                        <a
                            href="{{ route('admin.activity.index') }}"
                            class="mt-5 inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Limpiar filtros
                        </a>

                    @endif

                </div>

            @endforelse


            {{-- Paginación --}}
            @if ($activities->hasPages())

                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $activities->links() }}
                </div>

            @endif

        </div>

    </div>

</x-app-layout>