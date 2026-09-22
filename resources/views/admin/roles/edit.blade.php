<x-app-layout>

    @php
        $isBaseRole = in_array($role->name, ['admin', 'user'], true);

        $selectedPermissions = old('permissions', $rolePermissionIds ?? []);
    @endphp

    <div class="mx-auto w-full max-w-5xl space-y-6">

        {{-- Cabecera --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex min-w-0 items-center gap-3">

                <a
                    href="{{ route('admin.roles.show', $role) }}"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    aria-label="Volver al rol"
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
                            d="M19 12H5m6-6-6 6 6 6"
                        />
                    </svg>
                </a>

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Administración
                    </p>

                    <div class="mt-1 flex flex-wrap items-center gap-2">

                        <h1 class="truncate text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Editar rol
                        </h1>

                        @if ($isBaseRole)

                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                Rol base
                            </span>

                        @endif

                    </div>

                    <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">
                        {{ $role->label }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Formulario --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">

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
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M17.5 3.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 8.5-8.5z"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Configuración del rol
                        </h2>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Los cambios afectarán a todos los usuarios que tengan asignado este rol.
                        </p>

                    </div>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('admin.roles.update', $role) }}"
                class="p-6 sm:p-8"
            >

                @csrf
                @method('PUT')


                <div class="space-y-8">

                    {{-- Información básica --}}
                    <section>

                        <div class="mb-5">

                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                Información básica
                            </h3>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Define cómo se identifica el rol dentro de la aplicación.
                            </p>

                        </div>


                        <div class="grid gap-6 md:grid-cols-2">

                            {{-- Identificador --}}
                            <div>

                                <label
                                    for="name"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                                >
                                    Identificador
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $role->name) }}"
                                    required
                                    maxlength="50"
                                    pattern="[A-Za-z0-9_-]+"
                                    autocomplete="off"
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                                >

                                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    Letras, números, guiones y guiones bajos.
                                </p>

                                @error('name')

                                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Nombre visible --}}
                            <div>

                                <label
                                    for="label"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                                >
                                    Nombre visible
                                </label>

                                <input
                                    type="text"
                                    id="label"
                                    name="label"
                                    value="{{ old('label', $role->label) }}"
                                    required
                                    maxlength="100"
                                    class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                                >

                                @error('label')

                                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Descripción --}}
                            <div class="md:col-span-2">

                                <label
                                    for="description"
                                    class="block text-sm font-semibold text-gray-800 dark:text-gray-200"
                                >
                                    Descripción
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    maxlength="1000"
                                    class="mt-2 block w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white"
                                >{{ old('description', $role->description) }}</textarea>

                                <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    Máximo 1000 caracteres.
                                </p>

                                @error('description')

                                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- Permisos --}}
                    <section
                        x-data="{
                            selected: @js(array_map('intval', $selectedPermissions)),

                            isSelected(id) {
                                return this.selected.includes(Number(id));
                            },

                            togglePermission(id) {
                                id = Number(id);

                                if (this.selected.includes(id)) {
                                    this.selected = this.selected.filter(permissionId => permissionId !== id);
                                } else {
                                    this.selected.push(id);
                                }
                            },

                            selectGroup(ids) {
                                ids.map(Number).forEach(id => {
                                    if (!this.selected.includes(id)) {
                                        this.selected.push(id);
                                    }
                                });
                            },

                            deselectGroup(ids) {
                                const groupIds = ids.map(Number);

                                this.selected = this.selected.filter(
                                    id => !groupIds.includes(id)
                                );
                            }
                        }"
                        class="border-t border-gray-100 pt-8 dark:border-gray-800"
                    >

                        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                            <div>

                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Permisos
                                </h3>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Selecciona las acciones que podrá realizar este rol.
                                </p>

                            </div>

                            <span class="inline-flex w-fit rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">

                                <span x-text="selected.length"></span>

                                <span class="ml-1">
                                    seleccionados
                                </span>

                            </span>

                        </div>


                        @php
                            $permissionGroups = $permissions->groupBy(function ($permission) {
                                return str($permission->name)->before('.')->value();
                            });
                        @endphp


                        <div class="space-y-5">

                            @foreach ($permissionGroups as $group => $groupPermissions)

                                @php
                                    $groupIds = $groupPermissions
                                        ->pluck('id')
                                        ->values()
                                        ->all();
                                @endphp

                                <div
                                    x-data
                                    class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700"
                                >

                                    <div class="flex flex-col gap-3 border-b border-gray-100 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800 dark:bg-gray-800/50">

                                        <div>

                                            <h4 class="text-sm font-bold capitalize text-gray-900 dark:text-white">
                                                {{ $group }}
                                            </h4>

                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $groupPermissions->count() }}
                                                {{ $groupPermissions->count() === 1 ? 'permiso' : 'permisos' }}
                                            </p>

                                        </div>


                                        <div class="flex items-center gap-2">

                                            <button
                                                type="button"
                                                @click="selectGroup(@js($groupIds))"
                                                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-600 transition hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                                            >
                                                Seleccionar
                                            </button>

                                            <button
                                                type="button"
                                                @click="deselectGroup(@js($groupIds))"
                                                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-500 transition hover:bg-white hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                                            >
                                                Limpiar
                                            </button>

                                        </div>

                                    </div>


                                    <div class="divide-y divide-gray-100 dark:divide-gray-800">

                                        @foreach ($groupPermissions as $permission)

                                            <label
                                                for="permission_{{ $permission->id }}"
                                                class="flex cursor-pointer items-start gap-4 px-5 py-4 transition hover:bg-gray-50 dark:hover:bg-gray-800/40"
                                            >

                                                <input
                                                    type="checkbox"
                                                    id="permission_{{ $permission->id }}"
                                                    name="permissions[]"
                                                    value="{{ $permission->id }}"
                                                    @checked(in_array($permission->id, $selectedPermissions))
                                                    :checked="isSelected({{ $permission->id }})"
                                                    @change="togglePermission({{ $permission->id }})"
                                                    class="mt-0.5 h-5 w-5 cursor-pointer rounded border-gray-300 bg-white accent-gray-900 focus:ring-2 focus:ring-gray-900/20 dark:border-gray-600 dark:bg-gray-800"
                                                >

                                                <div class="min-w-0 flex-1">

                                                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                            {{ $permission->label }}
                                                        </p>

                                                        <code class="w-fit rounded-lg bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                            {{ $permission->name }}
                                                        </code>

                                                    </div>

                                                    @if ($permission->description)

                                                        <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400">
                                                            {{ $permission->description }}
                                                        </p>

                                                    @endif

                                                </div>

                                            </label>

                                        @endforeach

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        @error('permissions')

                            <p class="mt-4 text-sm font-medium text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>

                        @enderror

                        @error('permissions.*')

                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>

                        @enderror

                    </section>


                    {{-- Información adicional --}}
                    <section class="rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-800/50">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-gray-600 dark:bg-gray-800 dark:text-gray-300">

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
                                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Usuarios asignados
                                </p>

                                @php
                                    $assignedUsersCount = $role->users()->count();
                                @endphp

                                <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-gray-400">

                                    Este rol está asignado actualmente a

                                    <span class="font-semibold text-gray-700 dark:text-gray-300">
                                        {{ $assignedUsersCount }}
                                    </span>

                                    {{ $assignedUsersCount === 1 ? 'usuario' : 'usuarios' }}.

                                </p>

                            </div>

                        </div>

                    </section>

                </div>


                {{-- Acciones --}}
                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end dark:border-gray-800">

                    <a
                        href="{{ route('admin.roles.show', $role) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900/20 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
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
                                d="M5 12h14"
                            />
                        </svg>

                        Guardar cambios

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>