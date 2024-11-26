<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <button onclick="openModal('create')">Nuevo Usuario</button>

    <table id="users-table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

    @include('usuarios.action')

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
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
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
</body>
</html>
