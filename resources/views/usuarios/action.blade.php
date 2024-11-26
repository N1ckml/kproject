<!-- Modal para Crear o Editar Usuario -->
<div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <!-- Título del Modal -->
        <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-900">
            Modal Título
        </h2>

        <!-- Formulario -->
        <form id="userForm">
            @csrf

            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nombre
                </label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 bg-gray-50 text-gray-900 rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Campo Correo Electrónico -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Correo Electrónico
                </label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 bg-gray-50 text-gray-900 rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Campo Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Contraseña
                </label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-gray-50 text-gray-900 rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition mr-2">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Guardar
                </button>
            </div>
        </form>

        <!-- Botón para cerrar el modal -->
        <button type="button" onclick="closeModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
