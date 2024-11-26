<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios</title>
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
            <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-black">GESTION <mark class="px-1 text-white bg-blue-600 rounded dark:bg-blue-500">USUARIOS</mark></h1>
            <hr class="border-t-2 border-black">
            <!-- Botón para Crear Usuario -->
        <button onclick="openModal('create')" class="btn btn-create">
            Nuevo Usuario
        </button>

        <!-- Contenedor de la tabla -->
        <div class="table-container">
            <table id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        </main>
        @include('usuarios.action')
    </div>
</body>

</html>

<!-- Scripts -->
<script>
        $(document).ready(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('usuarios.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <div class="flex gap-2">
                                    <button class="btn btn-edit" onclick="openModal('edit', ${row.id})">
                                        Editar
                                    </button>
                                    <button class="btn btn-delete" onclick="deleteUser(${row.id})">
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

        function openModal(action, userId = null) {
            const modal = document.getElementById('userModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('userForm');

            form.reset();

            if (action === 'create') {
                title.textContent = 'Registrar Usuario';
                form.onsubmit = function (e) {
                    e.preventDefault();
                    createUser();
                };
            } else if (action === 'edit') {
                title.textContent = 'Editar Usuario';
                loadUserData(userId);
                form.onsubmit = function (e) {
                    e.preventDefault();
                    updateUser(userId);
                };
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('userModal');
            modal.classList.add('hidden');
        }

        function loadUserData(userId) {
            fetch(`/usuarios/${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                });
        }

        function createUser() {
            const formData = new FormData(document.getElementById('userForm'));
            fetch('/usuarios', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    Swal.fire('Éxito', 'Usuario creado exitosamente', 'success');
                    closeModal();
                    $('#users-table').DataTable().ajax.reload();
                });
        }

        function updateUser(userId) {
            const form = document.getElementById('userForm');
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            fetch(`/usuarios/${userId}`, { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    Swal.fire('Éxito', 'Usuario actualizado exitosamente', 'success');
                    closeModal();
                    $('#users-table').DataTable().ajax.reload();
                });
        }

        function deleteUser(userId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Este usuario será eliminado.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/usuarios/${userId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire('Eliminado', 'Usuario eliminado correctamente', 'success');
                            $('#users-table').DataTable().ajax.reload();
                        });
                }
            });
        }
    </script>