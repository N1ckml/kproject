<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Gestión de Tareas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-300 flex">

    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content -->
    <div class="flex-1 ml-[250px]">
        <!-- Header -->
        <header class="bg-white shadow-md px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Gestión de Tareas</h1>
                <p class="text-sm text-gray-600">Bienvenido, <span class="font-medium text-gray-800">Usuario</span></p>
            </div>
        </header>

        <!-- Main Section -->
        <main class="p-6">
            <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-black">
                Administración de <mark class="px-1 text-white bg-blue-600 rounded dark:bg-blue-500">Tareas</mark>
            </h1>
            <hr class="border-t-2 border-black mb-4">

            <!-- Botón para Crear Tarea -->
            <button onclick="openModal('createTaskModal')" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4">
                Nueva Tarea
            </button>

<!-- Modal para Crear Nueva Tarea -->
<div id="createTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-lg p-6 relative">
        <h2 class="text-xl font-bold mb-4 text-gray-900">Crear Nueva Tarea</h2>
        <form id="createTaskForm">
            @csrf
            <div class="mb-4">
    <label for="project_id" class="block text-sm font-medium text-gray-700">Proyecto</label>
    <select name="project_id" id="project_id" class="w-full px-3 py-2 border rounded-md" required>
        <option value="" disabled selected>Seleccione un proyecto</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="phase_id" class="block text-sm font-medium text-gray-700">Fase (Opcional)</label>
    <select name="phase_id" id="phase_id" class="w-full px-3 py-2 border rounded-md">
        <option value="">Sin asignar</option>
    </select>
</div>

            <!-- Título -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="title" id="title" class="w-full px-3 py-2 border rounded-md" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" id="description" class="w-full px-3 py-2 border rounded-md"></textarea>
            </div>

            <!-- Estado -->
            <div class="mb-4">
                <label for="completed" class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="completed" id="completed" class="w-full px-3 py-2 border rounded-md">
                    <option value="0">Pendiente</option>
                    <option value="1">Completada</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('createTaskModal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancelar</button>
                <button type="button" onclick="createTask()" class="bg-green-500 text-white px-4 py-2 rounded-md">Crear</button>
            </div>
        </form>
    </div>
</div>


            <!-- Tabla de Tareas -->
            <div class="overflow-x-auto">
                <table id="tasks-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-200">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Proyecto</th>
                            <th class="px-4 py-2">Fase</th>
                            <th class="px-4 py-2">Título</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable manejará el contenido -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function () {
        // Inicializar DataTable
        $('#tasks-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tareas.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'project', name: 'project' },
                { data: 'phase', name: 'phase' },
                { data: 'title', name: 'title' },
                {
                    data: 'completed',
                    name: 'completed',
                    render: function (data) {
                        return data ? 'Completada' : 'Pendiente';
                    }
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            language: { url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json" }
        });

        // Manejar cambios en el select de proyectos al crear tareas
        $('#project_id').on('change', function () {
            const projectId = this.value;
            const phaseSelect = $('#phase_id');

            // Limpiar las opciones anteriores
            phaseSelect.empty();
            phaseSelect.append('<option value="">Sin asignar</option>'); // Opción predeterminada

            if (projectId) {
                fetch(`/proyectos/${projectId}/fases`)
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            phaseSelect.append('<option disabled>No hay fases disponibles</option>');
                        } else {
                            data.forEach(phase => {
                                phaseSelect.append(`<option value="${phase.id}">${phase.name}</option>`);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar las fases:', error);
                        Swal.fire('Error', 'No se pudieron cargar las fases del proyecto.', 'error');
                    });
            }
        });
    });

    // Abrir modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    // Cerrar modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Crear tarea
    function createTask() {
        const form = document.getElementById('createTaskForm');
        const formData = new FormData(form);

        fetch('/tareas', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            Swal.fire('Éxito', data.message, 'success');
            closeModal('createTaskModal');
            $('#tasks-table').DataTable().ajax.reload();
        })
        .catch(error => {
            console.error('Error al crear tarea:', error);
            Swal.fire('Error', 'No se pudo crear la tarea.', 'error');
        });
    }

    // Actualizar tarea
    function updateTask(taskId) {
        const form = document.getElementById(`editForm-${taskId}`);
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(`/tareas/${taskId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            Swal.fire('Éxito', data.message, 'success');
            closeModal(`editModal-${taskId}`);
            $('#tasks-table').DataTable().ajax.reload();
        })
        .catch(error => {
            console.error('Error al actualizar tarea:', error);
            Swal.fire('Error', 'No se pudo actualizar la tarea.', 'error');
        });
    }

    // Eliminar tarea
    function deleteTask(taskId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/tareas/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    Swal.fire('Eliminado', data.message, 'success');
                    $('#tasks-table').DataTable().ajax.reload();
                })
                .catch(error => console.error('Error al eliminar tarea:', error));
            }
        });
    }

    // Mover tarea
    function moveTask(taskId) {
        const form = document.getElementById(`moveForm-${taskId}`);
        const formData = new FormData(form);

        fetch(`/tareas/${taskId}/assign-phase`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            Swal.fire('Éxito', data.message, 'success');
            closeModal(`moveModal-${taskId}`);
            $('#tasks-table').DataTable().ajax.reload();
        })
        .catch(error => {
            console.error('Error al mover tarea:', error);
            Swal.fire('Error', 'No se pudo mover la tarea.', 'error');
        });
    }
</script>

</body>
</html>
