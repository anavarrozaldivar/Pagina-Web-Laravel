<x-app-layout>

    @php
        $currentUser = Auth::user();

        $currentUser->loadMissing('roleRelation.permissions');

        $isAdmin = $currentUser->roleRelation?->name === 'admin';

        $canEditContents =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'contents.edit');

        $canDeleteContents =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'contents.delete');

        $isPublished = $content->status === 'published';
    @endphp

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

            <div class="flex items-start gap-4">

                <a
                    href="{{ route('admin.contents.index') }}"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    aria-label="Volver a contenidos"
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
                        Gestión de contenidos
                    </p>

                    <div class="mt-1 flex flex-wrap items-center gap-3">

                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $content->title }}
                        </h1>

                        @if ($isPublished)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Publicado
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                Borrador
                            </span>
                        @endif

                    </div>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Consulta la información y gestiona este contenido.
                    </p>

                </div>

            </div>


            {{-- Acción principal --}}
            @if ($canEditContents)

                <a
                    href="{{ route('admin.contents.edit', $content) }}"
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
                            d="M15.232 5.232l3.536 3.536M4 20h4l10.768-10.768a2.5 2.5 0 00-3.536-3.536L4 16.464V20z"
                        />
                    </svg>

                    Editar contenido
                </a>

            @endif

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


        {{-- Contenido principal --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Resumen --}}
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <div class="p-6">

                    <div class="flex flex-col items-center text-center">

                        {{-- Icono / inicial --}}
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gray-900 text-3xl font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">
                            {{ strtoupper(substr($content->title, 0, 1)) }}
                        </div>

                        <h2 class="mt-5 text-xl font-bold text-gray-900 dark:text-white">
                            {{ $content->title }}
                        </h2>

                        <div class="mt-3">

                            @if ($isPublished)

                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Publicado
                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                    Borrador
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Resumen --}}
                    <div class="mt-7 space-y-3">

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/40">

                            <div class="flex items-center justify-between gap-4">

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                        Identificador
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-gray-900 dark:text-white">
                                        #{{ $content->id }}
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
                                            d="M5 4h14v16H5zM9 8h6M9 12h6M9 16h3"
                                        />
                                    </svg>
                                </div>

                            </div>

                        </div>


                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/40">

                            <div class="flex items-center justify-between gap-4">

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                        Estado
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $isPublished ? 'Publicado' : 'Borrador' }}
                                    </p>
                                </div>

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-500 shadow-sm dark:bg-gray-900 dark:text-gray-400">

                                    @if ($isPublished)
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
                                    @else
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
                                                d="M12 7v5l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Información --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">

                <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Información del contenido
                            </h2>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Datos y contenido asociado a este registro.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="p-6">

                    <div class="space-y-7">

                        {{-- Título --}}
                        <div>

                            <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                Título
                            </p>

                            <p class="mt-2 text-base font-semibold text-gray-900 dark:text-white">
                                {{ $content->title }}
                            </p>

                        </div>


                        {{-- Descripción --}}
                        <div>

                            <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                Descripción
                            </p>

                            @if ($content->description)

                                <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/40">

                                    <p class="whitespace-pre-line text-sm leading-7 text-gray-700 dark:text-gray-300">
                                        {{ $content->description }}
                                    </p>

                                </div>

                            @else

                                <div class="mt-3 rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-5 dark:border-gray-700 dark:bg-gray-800/40">

                                    <p class="text-sm italic text-gray-400 dark:text-gray-500">
                                        Este contenido no tiene descripción.
                                    </p>

                                </div>

                            @endif

                        </div>


                        {{-- Metadatos --}}
                        <div class="border-t border-gray-100 pt-7 dark:border-gray-800">

                            <p class="text-xs font-bold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                Metadatos
                            </p>

                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">

                                {{-- ID --}}
                                <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        ID
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                        #{{ $content->id }}
                                    </p>

                                </div>


                                {{-- Estado --}}
                                <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Estado
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $isPublished ? 'Publicado' : 'Borrador' }}
                                    </p>

                                </div>


                                {{-- Creación --}}
                                <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Fecha de creación
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $content->created_at?->format('d/m/Y H:i') ?? '—' }}
                                    </p>

                                </div>


                                {{-- Actualización --}}
                                <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        Última actualización
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $content->updated_at?->format('d/m/Y H:i') ?? '—' }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Acciones --}}
                @if ($canEditContents || $canDeleteContents)

                    <div class="flex flex-col gap-3 border-t border-gray-100 bg-gray-50 px-6 py-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">

                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Gestiona este contenido desde las acciones disponibles.
                        </p>

                        <div class="flex flex-col gap-3 sm:flex-row">

                            {{-- Editar --}}
                            @if ($canEditContents)

                                <a
                                    href="{{ route('admin.contents.edit', $content) }}"
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
                                            d="M15.232 5.232l3.536 3.536M4 20h4l10.768-10.768a2.5 2.5 0 00-3.536-3.536L4 16.464V20z"
                                        />
                                    </svg>

                                    Editar contenido
                                </a>

                            @endif


                            {{-- Eliminar --}}
                            @if ($canDeleteContents)

                                <form
                                    method="POST"
                                    action="{{ route('admin.contents.destroy', $content) }}"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar este contenido? Esta acción no se puede deshacer.')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/10 dark:border-red-900/50 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-950/30 dark:focus:ring-red-400/10 sm:w-auto"
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
                                                d="M6 7h12m-9 0v10m6-10v10M9 7l1-3h4l1 3m-7 0h8m-9 0-1 13h12L17 7"
                                            />
                                        </svg>

                                        Eliminar contenido
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>