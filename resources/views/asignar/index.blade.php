<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/styles.css', 'resources/css/app.css']) <!-- Importar estilos -->
    <title>Asignar Usuarios</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-300 flex">
    <!-- Sidebar -->
    <x-sidebar />

    <!-- Contenido principal -->
    <div class="flex-1 ml-[250px]">
        <!-- Encabezado -->
        <header class="bg-white shadow-md px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Asignar Usuarios a Proyectos</h1>
            </div>
        </header>

        <!-- Contenido -->
        <main class="p-6">
            <h1 class="mb-4 text-2xl font-extrabold text-gray-900">ASIGNACIÓN DE <mark class="px-1 text-white bg-blue-600 rounded">USUARIOS</mark></h1>
            <hr class="border-t-2 border-black">

            <!-- Tabla de asignaciones -->
            <div class="table-container">
                <table id="assign-table">
                    <thead>
                        <tr>
                            <th>ID Proyecto</th>
                            <th>Nombre Proyecto</th>
                            <th>Usuarios Asignados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </main>
    </div>
</body>

<!-- Scripts -->
<script>
    $('#assign-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('asignar.projects') }}", // Ruta del controlador
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        {
            data: 'users',
            name: 'users',
            render: function(users) {
                if (users && users.length > 0) {
                    return users.map(user => user.name).join(', ');
                }
                return 'Sin usuarios asignados';
            }
        },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false,
        }
    ],
    language: { url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json" }
});

    // Abrir modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    // Cerrar modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Asignar usuario a un proyecto
    function assignUser(projectId) {
        const form = document.getElementById(`assignForm-${projectId}`);
        const formData = new FormData(form);

        fetch('/asignar/assign', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire('Éxito', 'Usuario asignado correctamente.', 'success');
            closeModal(`assignModal-${projectId}`);
            $('#assign-table').DataTable().ajax.reload();
        })
        .catch(error => console.error('Error:', error));
    }

    // Retirar usuario de un proyecto
    function removeUser(projectId) {
        const form = document.getElementById(`removeForm-${projectId}`);
        const formData = new FormData(form);

        fetch('/asignar/remove', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire('Éxito', 'Usuario retirado correctamente.', 'success');
            closeModal(`removeModal-${projectId}`);
            $('#assign-table').DataTable().ajax.reload();
        })
        .catch(error => console.error('Error:', error));
    }
</script>
</html>
