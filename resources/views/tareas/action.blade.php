<!-- Botones de acciones -->
<div class="flex gap-2">
    <!-- Botón Editar -->
    <button onclick="openModal('editModal-{{ $task->id }}')" class="bg-blue-500 text-white px-4 py-2 rounded-md">
        Editar
    </button>

    <!-- Botón Eliminar -->
    <button onclick="deleteTask({{ $task->id }})" class="bg-red-500 text-white px-4 py-2 rounded-md">
        Eliminar
    </button>

    <!-- Botón Mover -->
    <button onclick="openModal('moveModal-{{ $task->id }}')" class="bg-green-500 text-white px-4 py-2 rounded-md">
        Mover
    </button>
</div>

<!-- Modal para Editar Tarea -->
<div id="editModal-{{ $task->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Editar Tarea: {{ $task->title }}
        </h2>
        <form id="editForm-{{ $task->id }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="task_id" value="{{ $task->id }}">

            <!-- Proyecto -->
            <div class="mb-4">
                <label for="project_id-{{ $task->id }}" class="block text-sm font-medium text-gray-700">Proyecto</label>
                <select name="project_id" id="project_id-{{ $task->id }}" class="w-full px-3 py-2 border rounded-md">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Título -->
            <div class="mb-4">
                <label for="title-{{ $task->id }}" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" id="title-{{ $task->id }}" name="title" value="{{ $task->title }}" class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="description-{{ $task->id }}" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="description-{{ $task->id }}" name="description" class="w-full px-3 py-2 border rounded-md">{{ $task->description }}</textarea>
            </div>

            <!-- Estado -->
            <div class="mb-4">
                <label for="completed-{{ $task->id }}" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="completed-{{ $task->id }}" name="completed" class="w-full px-3 py-2 border rounded-md">
                    <option value="0" {{ !$task->completed ? 'selected' : '' }}>Pendiente</option>
                    <option value="1" {{ $task->completed ? 'selected' : '' }}>Completada</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('editModal-{{ $task->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancelar</button>
                <button type="button" onclick="updateTask({{ $task->id }})" class="bg-blue-500 text-white px-4 py-2 rounded-md">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Mover Tarea -->
<div id="moveModal-{{ $task->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Mover Tarea: {{ $task->title }}
        </h2>
        <form id="moveForm-{{ $task->id }}">
            @csrf
            <input type="hidden" name="task_id" value="{{ $task->id }}">

            <!-- Seleccionar Fase -->
            <div class="mb-4">
                <label for="phase_id-{{ $task->id }}" class="block text-sm font-medium text-gray-700">Fase</label>
                <select id="phase_id-{{ $task->id }}" name="phase_id" class="w-full px-3 py-2 border rounded-md">
                    <option value="">Sin asignar</option>
                    @if($task->project && $task->project->phases->count())
                        @foreach($task->project->phases as $phase)
                            <option value="{{ $phase->id }}" {{ $task->phase_id == $phase->id ? 'selected' : '' }}>
                                {{ $phase->name }}
                            </option>
                        @endforeach
                    @else
                        <option disabled>No hay fases disponibles para este proyecto</option>
                    @endif
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('moveModal-{{ $task->id }}')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancelar</button>
                <button type="button" onclick="moveTask({{ $task->id }})" class="bg-green-500 text-white px-4 py-2 rounded-md">Mover</button>
            </div>
        </form>
    </div>
</div>
