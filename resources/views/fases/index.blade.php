<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/styles.css', 'resources/css/app.css']) <!-- Importar estilos -->
    <title>Gestión de Fases</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="antialiased bg-gray-50 dark:bg-gray-300 flex">

    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content -->
    <div class="flex-1 ml-[250px]">
        <!-- Header -->
        <header class="bg-white shadow-md px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-sm text-gray-600">Bienvenido, <span class="font-medium text-gray-800">Usuario</span></p>
            </div>
        </header>

        <!-- Main Section -->
        <main class="p-6">
            <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-black">
                Gestión de <mark class="px-1 text-white bg-green-600 rounded dark:bg-green-500">Fases</mark>
            </h1>
            <hr class="border-t-2 border-black">

            <!-- Botón para Crear Fase -->
            <button onclick="openPhaseModal('create')" class="btn btn-create">
                Nueva Fase
            </button>

            <!-- Contenedor de la tabla -->
            <div class="table-container">
                <table id="phases-table">
                    <thead>
                    <tr>
                        <th>PROYECTO</th>
                        <th>FASE</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    
                </table>
            </div>
        </main>
        @include('fases.action')
    </div>
</body>

</html>

<!-- Scripts -->
<script>
$(document).ready(function () {
    let table = $('#phases-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('fases.data') }}",
        columns: [
            { data: 'project_name', name: 'project_name' },  // Nombre del proyecto
            { data: 'name', name: 'name' },                  // Nombre de la fase
            { data: 'description', name: 'description' },    // Descripción de la fase
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="flex gap-2">
                            <button class="btn btn-edit" onclick="openPhaseModal('edit', ${row.id})">
                                Editar
                            </button>
                            <button class="btn btn-delete" onclick="deletePhase(${row.id})">
                                Eliminar
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json" },
        drawCallback: function (settings) {
            // Agrupamiento visual por nombre del proyecto
            let api = this.api();
            let rows = api.rows({ page: 'current' }).nodes();
            let lastProjectName = null;

            api.column(0, { page: 'current' }).data().each(function (projectName, i) {
                if (projectName !== lastProjectName) {
                    // Si cambia el proyecto, combinamos celdas para las filas correspondientes
                    $(rows).eq(i).find('td:first').attr('rowspan', api
                        .rows({ page: 'current' })
                        .data()
                        .filter(row => row.project_name === projectName).length);
                    
                    lastProjectName = projectName;
                } else {
                    // Si el proyecto es el mismo, ocultamos las celdas redundantes
                    $(rows).eq(i).find('td:first').remove();
                }
            });

            // Reasignar eventos a los botones
            rebindActions();
        }
    });

    // Función para reasignar eventos de botones
    function rebindActions() {
        $('.btn-edit').off('click').on('click', function () {
            let phaseId = $(this).attr('onclick').match(/\d+/)[0];
            openPhaseModal('edit', phaseId);
        });

        $('.btn-delete').off('click').on('click', function () {
            let phaseId = $(this).attr('onclick').match(/\d+/)[0];
            deletePhase(phaseId);
        });
    }
});

    function openPhaseModal(action, phaseId = null) {
        const modal = document.getElementById('phaseModal');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('phaseForm');

        form.reset();

        if (action === 'create') {
            title.textContent = 'Registrar Fase';
            form.onsubmit = function (e) {
                e.preventDefault();
                createPhase();
            };
        } else if (action === 'edit') {
            title.textContent = 'Editar Fase';
            loadPhaseData(phaseId);
            form.onsubmit = function (e) {
                e.preventDefault();
                updatePhase(phaseId);
            };
        }

        modal.classList.remove('hidden');
    }

    function closePhaseModal() {
        const modal = document.getElementById('phaseModal');
        modal.classList.add('hidden');
    }

    function loadPhaseData(phaseId) {
        fetch(`/fases/${phaseId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('project_id').value = data.project_id; // Asignar el proyecto seleccionado
            });
    }

    function createPhase() {
        const formData = new FormData(document.getElementById('phaseForm'));
        fetch('/fases', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                Swal.fire('Éxito', 'Fase creada exitosamente', 'success');
                closePhaseModal();
                $('#phases-table').DataTable().ajax.reload();
            });
    }

    function updatePhase(phaseId) {
        const form = document.getElementById('phaseForm');
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(`/fases/${phaseId}`, { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                Swal.fire('Éxito', 'Fase actualizada exitosamente', 'success');
                closePhaseModal();
                $('#phases-table').DataTable().ajax.reload();
            });
    }

    function deletePhase(phaseId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta fase será eliminada.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/fases/${phaseId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Eliminada', 'Fase eliminada correctamente', 'success');
                        $('#phases-table').DataTable().ajax.reload();
                    });
            }
        });
    }
</script>
