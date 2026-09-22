<x-app-layout>

    <div class="w-full space-y-6">

        {{-- Cabecera --}}
        <div class="flex items-start gap-4">

            <a
                href="{{ route('admin.contents.show', $content) }}"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="Volver al contenido"
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
                        Editar contenido
                    </h1>

                    @if ($content->status === 'published')
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
                    Modifica la información y el estado de este contenido.
                </p>
            </div>

        </div>


        {{-- Errores generales --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 dark:border-red-900/50 dark:bg-red-950/30">

                <div class="flex items-start gap-3">

                    <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400">
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
                    </div>

                    <div>

                        <p class="text-sm font-semibold text-red-800 dark:text-red-300">
                            Revisa los datos introducidos
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-red-700 dark:text-red-400">

                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2">
                                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"></span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Formulario --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <form
                method="POST"
                action="{{ route('admin.contents.update', $content) }}"
            >

                @csrf
                @method('PUT')

                {{-- Contenido --}}
                <div class="p-6 sm:p-8">

                    <div class="max-w-3xl space-y-7">

                        {{-- Información principal --}}
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                                Información principal
                            </h2>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Actualiza los datos principales de este contenido.
                            </p>
                        </div>


                        {{-- Título --}}
                        <div>

                            <label
                                for="title"
                                class="block text-sm font-semibold text-gray-900 dark:text-white"
                            >
                                Título
                            </label>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Utiliza un título claro y fácil de identificar.
                            </p>

                            <input
                                id="title"
                                name="title"
                                type="text"
                                value="{{ old('title', $content->title) }}"
                                required
                                autofocus
                                maxlength="255"
                                placeholder="Ej. Bienvenida a la plataforma"
                                class="mt-3 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white dark:focus:ring-white/10"
                            >

                            @error('title')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Descripción --}}
                        <div>

                            <label
                                for="description"
                                class="block text-sm font-semibold text-gray-900 dark:text-white"
                            >
                                Descripción
                            </label>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Modifica el texto asociado a este contenido.
                            </p>

                            <textarea
                                id="description"
                                name="description"
                                rows="8"
                                placeholder="Escribe una descripción del contenido..."
                                class="mt-3 block w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-white dark:focus:ring-white/10"
                            >{{ old('description', $content->description) }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Publicación --}}
                        <div class="border-t border-gray-100 pt-7 dark:border-gray-800">

                            <h2 class="text-sm font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                                Publicación
                            </h2>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Cambia la visibilidad del contenido dentro de la aplicación.
                            </p>


                            <div class="mt-5">

                                <label
                                    for="status"
                                    class="block text-sm font-semibold text-gray-900 dark:text-white"
                                >
                                    Estado
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    required
                                    class="mt-3 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white/10"
                                >

                                    <option
                                        value="published"
                                        @selected(old('status', $content->status) === 'published')
                                    >
                                        Publicado
                                    </option>

                                    <option
                                        value="draft"
                                        @selected(old('status', $content->status) === 'draft')
                                    >
                                        Borrador
                                    </option>

                                </select>

                                @error('status')
                                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- Información adicional --}}
                        <div class="border-t border-gray-100 pt-7 dark:border-gray-800">

                            <h2 class="text-sm font-bold uppercase tracking-[0.12em] text-gray-400 dark:text-gray-500">
                                Información del contenido
                            </h2>

                            <div class="mt-4 grid gap-4 sm:grid-cols-2">

                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/40">

                                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                        Identificador
                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                                        #{{ $content->id }}
                                    </p>

                                </div>

                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/40">

                                    <p class="text-xs font-semibold uppercase tracking-[0.1em] text-gray-400 dark:text-gray-500">
                                        Creado
                                    </p>

                                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $content->created_at?->format('d/m/Y H:i') ?? '—' }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Acciones --}}
                <div class="flex flex-col gap-3 border-t border-gray-100 bg-gray-50 px-6 py-5 dark:border-gray-800 dark:bg-gray-800/30 sm:flex-row sm:items-center sm:justify-between sm:px-8">

                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Los cambios se guardarán al confirmar la actualización.
                    </p>

                    <div class="flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('admin.contents.show', $content) }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Cancelar
                        </a>

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
                                    d="M5 12.5l4 4L19 7"
                                />
                            </svg>

                            Guardar cambios
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>