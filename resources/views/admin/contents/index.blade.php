<x-app-layout>

    @php
        $currentUser = Auth::user();

        $currentUser->loadMissing('roleRelation.permissions');

        $isAdmin = $currentUser->roleRelation?->name === 'admin';

        $canCreateContents =
            $isAdmin
            || $currentUser->roleRelation?->permissions?->contains('name', 'contents.create');

        $totalContents = $contents->total();

        $publishedCount = \App\Models\Content::where('status', 'published')->count();

        $draftCount = \App\Models\Content::where('status', 'draft')->count();
    @endphp

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Administración
                </p>

                <div class="mt-1 flex flex-wrap items-center gap-3">

                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Contenido
                    </h1>

                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        {{ $totalContents }}
                    </span>

                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gestiona el contenido de tu aplicación desde un único lugar.
                </p>

            </div>

            @if ($canCreateContents)

                <a
                    href="{{ route('admin.contents.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
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
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    Nuevo contenido

                </a>

            @endif

        </div>


        {{-- Resumen --}}
        <section class="grid gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                    Total
                </p>

                <div class="mt-2 flex items-end justify-between gap-3">

                    <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $totalContents }}
                    </p>

                    <span class="rounded-xl bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        Contenidos
                    </span>

                </div>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                    Publicados
                </p>

                <div class="mt-2 flex items-end justify-between gap-3">

                    <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $publishedCount }}
                    </p>

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Publicado

                    </span>

                </div>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

                <p class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                    Borradores
                </p>

                <div class="mt-2 flex items-end justify-between gap-3">

                    <p class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $draftCount }}
                    </p>

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">

                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                        Borrador

                    </span>

                </div>

            </div>

        </section>


        {{-- Mensaje de éxito --}}
        @if (session('success'))

            <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm font-medium text-green-700 dark:border-green-900/50 dark:bg-green-950/30 dark:text-green-400">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/40">

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

                </div>

                <div class="pt-1">
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- Búsqueda y filtros --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <form
                method="GET"
                action="{{ route('admin.contents.index') }}"
                class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto]"
            >

                {{-- Buscar --}}
                <div>

                    <label
                        for="search"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Buscar
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                            <svg
                                class="h-5 w-5 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                                />
                            </svg>

                        </div>

                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ request('search') }}"
                            placeholder="Buscar por título o descripción..."
                            class="block w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white"
                        >

                    </div>

                </div>


                {{-- Estado --}}
                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        Estado
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                    >

                        <option value="">
                            Todos los estados
                        </option>

                        <option
                            value="published"
                            @selected(request('status') === 'published')
                        >
                            Publicados
                        </option>

                        <option
                            value="draft"
                            @selected(request('status') === 'draft')
                        >
                            Borradores
                        </option>

                    </select>

                </div>


                {{-- Botones --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="inline-flex h-[46px] flex-1 items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 lg:flex-none"
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
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                            />
                        </svg>

                        Buscar

                    </button>

                    @if (request('search') || request('status'))

                        <a
                            href="{{ route('admin.contents.index') }}"
                            class="inline-flex h-[46px] items-center justify-center rounded-xl border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Limpiar
                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- Tabla --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Lista de contenidos
                        </h2>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Mostrando {{ $contents->firstItem() ?? 0 }}–{{ $contents->lastItem() ?? 0 }}
                            de {{ $contents->total() }}
                        </p>

                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full text-left">

                    <thead class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">

                        <tr>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Contenido
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Creado
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse ($contents as $content)

                            <tr class="group transition hover:bg-gray-50 dark:hover:bg-gray-800/50">

                                {{-- Contenido --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white shadow-sm dark:bg-white dark:text-gray-900">

                                            {{ strtoupper(substr($content->title, 0, 1)) }}

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $content->title }}
                                            </p>

                                            @if ($content->description)

                                                <p class="mt-0.5 max-w-md truncate text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $content->description }}
                                                </p>

                                            @else

                                                <p class="mt-0.5 text-sm italic text-gray-400 dark:text-gray-500">
                                                    Sin descripción
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Estado --}}
                                <td class="px-6 py-5">

                                    @if ($content->status === 'published')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Publicado

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">

                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                                            Borrador

                                        </span>

                                    @endif

                                </td>


                                {{-- Fecha --}}
                                <td class="px-6 py-5">

                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $content->created_at?->format('d/m/Y') }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-gray-400 dark:text-gray-500">
                                        {{ $content->created_at?->diffForHumans() }}
                                    </p>

                                </td>


                                {{-- Acción --}}
                                <td class="px-6 py-5 text-right">

                                    <a
                                        href="{{ route('admin.contents.show', $content) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                                    >

                                        Ver

                                        <svg
                                            class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m9 5 7 7-7 7"
                                            />
                                        </svg>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="px-6 py-16 text-center"
                                >

                                    <div class="mx-auto flex max-w-sm flex-col items-center">

                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">

                                            <svg
                                                class="h-7 w-7"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6l5 5v11a2 2 0 0 1-2 2Z"
                                                />
                                            </svg>

                                        </div>

                                        <h3 class="mt-4 text-sm font-semibold text-gray-900 dark:text-white">
                                            No se ha encontrado contenido
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Prueba con otros términos de búsqueda o filtros.
                                        </p>

                                        @if (request('search') || request('status'))

                                            <a
                                                href="{{ route('admin.contents.index') }}"
                                                class="mt-4 text-sm font-semibold text-gray-700 underline underline-offset-4 dark:text-gray-300"
                                            >
                                                Limpiar filtros
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($contents->hasPages())

                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $contents->links() }}
                </div>

            @endif

        </div>

    </div>

</x-app-layout>