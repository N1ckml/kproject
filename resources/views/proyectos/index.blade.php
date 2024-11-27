<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>cyc</title>
    ////////////////
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Proyectos</title>
    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Estilos personalizados -->
    <style>
        .table-container {
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #f4f4f4;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        th {
            text-transform: uppercase;
            font-weight: bold;
            color: #444;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-create {
            background-color: #007bff;
            margin-bottom: 20px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-create:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-300 flex">

    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content -->
    <div class="flex-1 ml-[250px]"> <!-- Ajustamos el margen izquierdo para respetar el ancho del sidebar -->
        <!-- Header -->
        <header class="bg-white shadow-md px-6 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-sm text-gray-600">Bienvenido, <span class="font-medium text-gray-800">Usuario</span></p>
            </div>
        </header>

        <!-- Main Section -->
        <main class="p-6">
            <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-black">GESTIÓN <mark class="px-1 text-white bg-green-600 rounded dark:bg-green-500">PROYECTOS</mark></h1>
            <hr class="border-t-2 border-black">
            
            <!-- Botón para Crear Proyecto -->
            <button onclick="openProjectModal('create')" class="btn btn-create">
                Nuevo Proyecto
            </button>

            <!-- Contenedor de la tabla -->
            <div class="table-container">
                <table id="projects-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </main>
        @include('proyectos.action')
    </div>
</body>

</html>

<!-- Scripts -->
<script>
    $(document).ready(function () {
        $('#projects-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('proyectos.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' }, // Asegúrate de usar 'name' en vez de 'nombre'
                { data: 'description', name: 'description' },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="flex gap-2">
                                <button class="btn btn-edit" onclick="openProjectModal('edit', ${row.id})">
                                    Editar
                                </button>
                                <button class="btn btn-delete" onclick="deleteProject(${row.id})">
                                    Eliminar
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: { url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json" }
        });
    });

    function openProjectModal(action, projectId = null) {
        const modal = document.getElementById('projectModal');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('projectForm');

        form.reset();

        if (action === 'create') {
            title.textContent = 'Registrar Proyecto';
            form.onsubmit = function (e) {
                e.preventDefault();
                createProject();
            };
        } else if (action === 'edit') {
            title.textContent = 'Editar Proyecto';
            loadProjectData(projectId);
            form.onsubmit = function (e) {
                e.preventDefault();
                updateProject(projectId);
            };
        }

        modal.classList.remove('hidden');
    }

    function closeProjectModal() {
        const modal = document.getElementById('projectModal');
        modal.classList.add('hidden');
    }

    function loadProjectData(projectId) {
        fetch(`/proyectos/${projectId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
            });
    }

    function createProject() {
        const formData = new FormData(document.getElementById('projectForm'));
        fetch('/proyectos', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                Swal.fire('Éxito', 'Proyecto creado exitosamente', 'success');
                closeProjectModal();
                $('#projects-table').DataTable().ajax.reload();
            });
    }

    function updateProject(projectId) {
        const form = document.getElementById('projectForm');
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(`/proyectos/${projectId}`, { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                Swal.fire('Éxito', 'Proyecto actualizado exitosamente', 'success');
                closeProjectModal();
                $('#projects-table').DataTable().ajax.reload();
            });
    }

    function deleteProject(projectId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Este proyecto será eliminado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/proyectos/${projectId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire('Eliminado', 'Proyecto eliminado correctamente', 'success');
                        $('#projects-table').DataTable().ajax.reload();
                    });
            }
        });
    }
</script>
