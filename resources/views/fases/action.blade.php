<!-- Modal para Crear o Editar Fase -->
<div id="phaseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <!-- Título del Modal -->
        <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-900">Modal Título</h2>

        <!-- Formulario -->
        <form id="phaseForm">
            @csrf

            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nombre
                </label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 bg-gray-50 text-gray-900 rounded-md border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>

            <!-- Campo Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Descripción
                </label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-3 py-2 bg-gray-50 text-gray-900 rounded-md border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500" required></textarea>
            </div>

            <!-- Proyecto -->
            <div class="mb-4">
                <label for="project_id" class="block text-sm font-medium text-gray-700">
                    Proyecto
                </label>
                <select id="project_id" name="project_id" class="mt-1 block w-full px-3 py-2 bg-gray-50 text-gray-900 rounded-md border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500" required>
                    <option value="">Selecciona un Proyecto</option>
                    <!-- Poblamos el select con los proyectos disponibles -->
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closePhaseModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition mr-2">
                    Cancelar
                </button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                    Guardar
                </button>
            </div>
        </form>

        <!-- Botón para cerrar el modal -->
        <button type="button" onclick="closePhaseModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
