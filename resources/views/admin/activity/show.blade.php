<x-app-layout>

    @php
        $actionStyles = [
            'created' => [
                'label' => 'Creado',
                'classes' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
            ],
            'updated' => [
                'label' => 'Modificado',
                'classes' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            ],
            'deleted' => [
                'label' => 'Eliminado',
                'classes' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400',
            ],
            'login' => [
                'label' => 'Inicio de sesión',
                'classes' => 'bg-violet-50 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400',
            ],
            'logout' => [
                'label' => 'Cierre de sesión',
                'classes' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
            ],
        ];

        $style = $actionStyles[$activity->action] ?? [
            'label' => ucfirst($activity->action),
            'classes' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
        ];
    @endphp

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex items-start gap-4">

            <a
                href="{{ route('admin.activity.index') }}"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="Volver a auditoría"
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </a>

            <div class="min-w-0">

                <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                    Administración
                </p>

                <div class="mt-1 flex flex-wrap items-center gap-3">

                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Detalle de actividad
                    </h1>

                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold {{ $style['classes'] }}">
                        {{ $style['label'] }}
                    </span>

                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Registro #{{ $activity->id }} · {{ $activity->created_at->diffForHumans() }}
                </p>

            </div>

        </div>


        {{-- Tarjeta principal --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            {{-- Cabecera --}}
            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800 sm:px-8">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-bold {{ $style['classes'] }}">
                                {{ $style['label'] }}
                            </span>

                            <span class="text-xs font-medium text-gray-400 dark:text-gray-500">
                                ID #{{ $activity->id }}
                            </span>

                        </div>

                        <h2 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">
                            {{ $activity->description }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Actividad registrada el
                            {{ $activity->created_at->format('d/m/Y \a \l\a\s H:i:s') }}.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Información general --}}
            <div class="grid gap-4 border-b border-gray-100 p-6 dark:border-gray-800 sm:grid-cols-2 sm:p-8">

                {{-- Usuario --}}
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/40">

                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                Usuario
                            </p>

                            <p class="mt-2 text-sm font-bold text-gray-900 dark:text-white">
                                {{ $activity->user?->name ?? 'Sistema' }}
                            </p>

                            @if ($activity->user)
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $activity->user->email }}
                                </p>
                            @endif
                        </div>

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm dark:bg-gray-900 dark:text-gray-400">
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
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm8-1a3 3 0 100-6 3 3 0 000 6zm0 3a4 4 0 014 4v1"
                                />
                            </svg>
                        </div>

                    </div>

                </div>


                {{-- Fecha --}}
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/40">

                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                Fecha y hora
                            </p>

                            <p class="mt-2 text-sm font-bold text-gray-900 dark:text-white">
                                {{ $activity->created_at->format('d/m/Y H:i:s') }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm dark:bg-gray-900 dark:text-gray-400">
                            <svg
                                class="h-4 w-4"
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
                                    d="M12 7v5l3 2"
                                />
                            </svg>
                        </div>

                    </div>

                </div>


                {{-- IP --}}
                @if ($activity->ip_address)

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/40">

                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                    Dirección IP
                                </p>

                                <p class="mt-2 break-all font-mono text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $activity->ip_address }}
                                </p>
                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm dark:bg-gray-900 dark:text-gray-400">
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
                                        d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4zM9.5 12l1.7 1.7L15 9.8"
                                    />
                                </svg>
                            </div>

                        </div>

                    </div>

                @endif


                {{-- Objeto afectado --}}
                @if ($activity->subject_type)

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/40">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                    Objeto afectado
                                </p>

                                <p class="mt-2 text-sm font-bold text-gray-900 dark:text-white">
                                    {{ class_basename($activity->subject_type) }}
                                </p>

                                @if ($activity->subject_id)
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Identificador #{{ $activity->subject_id }}
                                    </p>
                                @endif

                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm dark:bg-gray-900 dark:text-gray-400">
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
                                        d="M5 4h14v16H5zM9 8h6M9 12h6M9 16h3"
                                    />
                                </svg>
                            </div>

                        </div>

                    </div>

                @endif

            </div>


            {{-- Descripción --}}
            <div class="border-b border-gray-100 px-6 py-6 dark:border-gray-800 sm:px-8">

                <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                    Descripción
                </p>

                <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/40">

                    <p class="whitespace-pre-line text-sm leading-7 text-gray-700 dark:text-gray-300">
                        {{ $activity->description }}
                    </p>

                </div>

            </div>


            {{-- Propiedades --}}
            @if (!empty($activity->properties))

                <div class="border-b border-gray-100 px-6 py-6 dark:border-gray-800 sm:px-8">

                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            Datos del registro
                        </h3>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Información adicional asociada a esta actividad.
                        </p>
                    </div>

                    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200 bg-gray-950 dark:border-gray-700">

                        <pre class="max-h-[500px] overflow-auto p-5 text-xs leading-6 text-gray-200">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>

                    </div>

                </div>

            @endif


            {{-- Navegador --}}
            @if ($activity->user_agent)

                <div class="border-b border-gray-100 px-6 py-6 dark:border-gray-800 sm:px-8">

                    <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                        Navegador / dispositivo
                    </p>

                    <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/40">

                        <p class="break-words text-xs leading-6 text-gray-600 dark:text-gray-400">
                            {{ $activity->user_agent }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- Pie --}}
            <div class="flex flex-col gap-3 bg-gray-50 px-6 py-5 dark:bg-gray-800/30 sm:flex-row sm:items-center sm:justify-between sm:px-8">

                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Registro de auditoría #{{ $activity->id }}
                </div>

                <a
                    href="{{ route('admin.activity.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Volver a auditoría
                </a>

            </div>

        </div>

    </div>

</x-app-layout>