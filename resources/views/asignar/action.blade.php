<!-- Modal para Asignar Usuarios -->
<div id="assignModal-{{ $project->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <!-- Título del Modal -->
        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Asignar Usuarios al Proyecto: {{ $project->name }}
        </h2>

        <!-- Formulario para asignar usuarios -->
        <form id="assignForm-{{ $project->id }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <!-- Seleccionar Usuario -->
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">
                    Seleccionar Usuario
                </label>
                <select name="user_id" id="user_id-{{ $project->id }}" class="mt-1 block w-full px-3 py-2 bg-gray-50 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('assignModal-{{ $project->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition mr-2">
                    Cancelar
                </button>
                <button type="button" onclick="assignUser({{ $project->id }})" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                    Asignar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Retirar Usuarios -->
<div id="removeModal-{{ $project->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <!-- Título del Modal -->
        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Retirar Usuarios del Proyecto: {{ $project->name }}
        </h2>

        <!-- Formulario para retirar usuarios -->
        <form id="removeForm-{{ $project->id }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <!-- Seleccionar Usuario -->
            <div class="mb-4">
                <label for="remove_user_id" class="block text-sm font-medium text-gray-700">
                    Seleccionar Usuario
                </label>
                <select name="user_id" id="remove_user_id-{{ $project->id }}" class="mt-1 block w-full px-3 py-2 bg-gray-50 border rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500">
                    @foreach($project->users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('removeModal-{{ $project->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition mr-2">
                    Cancelar
                </button>
                <button type="button" onclick="removeUser({{ $project->id }})" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                    Retirar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Botones -->
<div class="flex gap-2">
    <button class="btn btn-edit" onclick="openModal('assignModal-{{ $project->id }}')">
        Asignar Usuario
    </button>
    <button class="btn btn-delete" onclick="openModal('removeModal-{{ $project->id }}')">
        Retirar Usuario
    </button>
</div>
