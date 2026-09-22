<x-app-layout>

    <div class="mx-auto max-w-7xl space-y-6">

        <!-- Welcome -->
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Hola, {{ Auth::user()->name }} 👋
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Bienvenido a tu panel personal.
            </p>
        </div>

        <!-- Main card -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Tu cuenta
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Desde aquí podrás gestionar tu perfil y consultar tu actividad.
                    </p>
                </div>

                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    Editar perfil
                </a>

            </div>
        </div>

        <!-- Stats -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Mi actividad
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                    0
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Proyectos
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                    0
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Estado
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                    Activo
                </p>
            </div>

        </div>

    </div>

</x-app-layout>

