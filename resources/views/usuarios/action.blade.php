<!-- Modal para Crear o Editar Usuario -->
<div id="userModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg">
    <div id="userModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
        <h2 id="modalTitle" class="text-lg font-bold mb-4">Modal</h2>
        <form id="userForm">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
            </div>
        </form>
    </div>
</div>
