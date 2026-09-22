<x-app-layout>

    @php
        $unreadCount = $notifications->whereNull('read_at')->count();
        $totalCount = $notifications->total();
    @endphp

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                    Centro de notificaciones
                </p>

                <div class="mt-1 flex flex-wrap items-center gap-3">

                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Notificaciones
                    </h1>

                    @if ($unreadCount > 0)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-900 px-2.5 py-1 text-xs font-bold text-white dark:bg-white dark:text-gray-900">
                            <span class="h-1.5 w-1.5 rounded-full bg-white dark:bg-gray-900"></span>
                            {{ $unreadCount }} sin leer
                        </span>
                    @endif

                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Consulta las novedades, avisos y comunicaciones de tu cuenta.
                </p>
            </div>


            {{-- Acción global --}}
            @if ($unreadCount > 0)

                <form
                    method="POST"
                    action="{{ route('notifications.read-all') }}"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:focus:ring-white/10"
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
                                d="M5 12.5l4 4L19 7"
                            />
                        </svg>

                        Marcar todas como leídas
                    </button>

                </form>

            @endif

        </div>


        {{-- Resumen --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Total --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            Total
                        </p>

                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $totalCount }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Notificaciones registradas
                        </p>

                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300">

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

            </div>


            {{-- Sin leer --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            Pendientes
                        </p>

                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $unreadCount }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Sin leer en esta página
                        </p>

                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300">

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
                                d="M12 6v6l4 2"
                            />
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.8"
                            />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Estado --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                            Estado
                        </p>

                        <p class="mt-2 text-lg font-bold text-gray-900 dark:text-white">
                            {{ $unreadCount > 0 ? 'Requiere revisión' : 'Todo al día' }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $unreadCount > 0 ? 'Tienes avisos pendientes.' : 'No tienes avisos pendientes.' }}
                        </p>

                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $unreadCount > 0 ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' }}">

                        @if ($unreadCount > 0)

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
                                    d="M12 9v4m0 4h.01M10.3 3.8L2.8 17a2 2 0 001.74 3h14.92a2 2 0 001.74-3L13.7 3.8a2 2 0 00-3.4 0z"
                                />
                            </svg>

                        @else

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
                                    d="M5 12.5l4 4L19 7"
                                />
                            </svg>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Mensaje de éxito --}}
        @if (session('success'))

            <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/50 dark:bg-emerald-950/30">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400">

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
                            d="M5 12.5l4 4L19 7"
                        />
                    </svg>

                </div>

                <div>

                    <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">
                        Operación completada
                    </p>

                    <p class="mt-0.5 text-sm text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        {{-- Lista --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            @forelse ($notifications as $notification)

                <div
                    class="border-b border-gray-100 px-5 py-5 last:border-b-0 sm:px-6 dark:border-gray-800
                    {{ $notification->read_at
                        ? 'bg-white dark:bg-gray-900'
                        : 'bg-gray-50 dark:bg-gray-800/60' }}"
                >

                    <div class="flex items-start gap-4">


                        {{-- Indicador / icono --}}
                        <div
                            class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                            {{ $notification->read_at
                                ? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'
                                : 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' }}"
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

                            @if (!$notification->read_at)

                                <span class="absolute -right-0.5 -top-0.5 h-3 w-3 rounded-full bg-gray-900 ring-2 ring-gray-50 dark:bg-white dark:ring-gray-800"></span>

                            @endif

                        </div>


                        {{-- Información --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h2 class="truncate text-sm font-bold text-gray-900 dark:text-white sm:text-base">
                                            {{ $notification->title }}
                                        </h2>

                                        @if (!$notification->read_at)

                                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-gray-900 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white dark:bg-white dark:text-gray-900">
                                                Nueva
                                            </span>

                                        @endif

                                    </div>

                                    <p class="mt-1.5 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                        {{ $notification->message }}
                                    </p>

                                </div>

                            </div>


                            {{-- Pie --}}
                            <div class="mt-4 flex flex-col gap-3 border-t border-gray-100 pt-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">

                                    <svg
                                        class="h-3.5 w-3.5"
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
                                            d="M12 6v6l4 2"
                                        />
                                    </svg>

                                    {{ $notification->created_at->diffForHumans() }}

                                </div>


                                <div class="flex flex-wrap items-center gap-2">

                                    @if ($notification->url)

                                        <form
                                            method="POST"
                                            action="{{ route('notifications.read', $notification) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
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
                                                class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                                            >
                                                Marcar como leída
                                            </button>

                                        </form>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-gray-100 px-3 py-2 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">

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
                                                    d="M5 12.5l4 4L19 7"
                                                />
                                            </svg>

                                            Leída

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

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
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0"
                            />
                        </svg>

                    </div>

                    <h2 class="mt-5 text-base font-bold text-gray-900 dark:text-white">
                        No tienes notificaciones
                    </h2>

                    <p class="mx-auto mt-1.5 max-w-md text-sm leading-6 text-gray-500 dark:text-gray-400">
                        Cuando recibas avisos, novedades o comunicaciones aparecerán aquí.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Paginación --}}
        @if ($notifications->hasPages())

            <div class="pt-1">
                {{ $notifications->links() }}
            </div>

        @endif

    </div>

</x-app-layout>