<x-app-layout>
    <x-slot name="header">
        <div class="me-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
            </svg>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agregar Credenciales de WordPress') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('wordpress.credentials.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="site_url" class="block font-medium text-sm text-gray-700 dark:text-gray-300">URL del
                            Sitio</label>
                        <input type="url" class="form-input w-full" id="site_url" name="site_url" required>
                    </div>

                    <div class="mb-4">
                        <label for="username"
                            class="block font-medium text-sm text-gray-700 dark:text-gray-300">Usuario</label>
                        <input type="text" class="form-input w-full" id="username" name="username" required>
                    </div>

                    <div class="mb-4">
                        <label for="password"
                            class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contraseña</label>
                        <input type="password" class="form-input w-full" id="password" name="password" required>
                    </div>

                    <div class="mb-4">
                        <label for="site_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nombre
                            del Sitio</label>
                        <input type="text" class="form-input w-full" id="site_name" name="site_name">
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
