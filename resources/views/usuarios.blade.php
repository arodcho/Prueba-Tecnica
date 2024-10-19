{{-- 
    Vista de usuarios en Laravel utilizando Blade y AdminLTE.
--}}

@extends('adminlte::page')

<!-- TITULO -->
@section('title', 'Usuarios')

<!-- HEADER -->
@section('content_header')
    <h1>Usuarios</h1>
    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stop

<!-- CONTENT -->
@section('content')
    <div class="mb-3">
        <!-- Botón para abrir el modal de creación de usuario -->
        @if (auth()->user()->is_admin)
            <button type="button" class="btn p-2 rounded" title="Crear usuario"
                style="background-color: #001c56; color: white;" data-toggle="modal" data-target="#createUserModal">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <i class="fas fa-users fa-2x mr-2"></i>
            </button>
        @else
            <button type="button" class="btn p-2 rounded"
                style="background-color: #001c56; color: white;"data-toggle="modal"
                title="Solo los administradores pueden crear usuarios." data-target="#createUserModal" disabled>
                <i class="fa fa-plus"></i>
                <i class="fas fa-users fa-2x mr-2"></i>
            </button>
        @endif
    </div>

    <!-- Modal para crear usuario -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" action="usuarios/crear" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="userName">Nombre</label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Contraseña</label>
                            <input type="password" class="form-control" id="userPassword" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="userRole">Rol</label>
                            <select class="form-control" id="userRole" name="role" required>
                                <option value="0">Usuario</option>
                                <option value="1">Administrador</option>
                            </select>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary p-2">Crear</button>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId" name="user_id">
                        <div class="form-group">
                            <label for="editUserName">Nombre</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserEmail">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary p-2">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de Creación</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                <!-- Inserccion de las filas de usuarios dinámicamente -->
            </tbody>
        </table>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
            });
        </script>
    @endif
@stop

<!-- FOOTER -->
@section('footer')
    <footer class="w-100 bg-light text-black pt-3 mt-6 pb-3 border-top text-left"
        style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 1030;">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                    <div>Versión 1.0.0.</div>
                </div>
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                    <strong>&copy; 2024 Prueba Técnica.</strong>
                </div>
                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                    <div>Desarrollado por <b>Álvaro Rodríguez Chofles.</b></div>
                </div>
            </div>
        </div>
    </footer>
@stop



<!-- CSS -->
@section('css')
<style>
      footer {
    margin-top: 6rem;
}
</style>

@stop

<!-- JS -->
@section('js')

    <script>
        $(document).ready(function() {
            function loadUsers() {
                $.ajax({
                    url: "{{ route('usuarios') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        let tbody = $('#user-table-body');
                        let isAdmin = {{ auth()->user()->is_admin ? 'true' : 'false' }};
                        tbody.empty();

                        data.forEach(function(user) {
                            let role = user.is_admin ? 'Administrador' : 'Usuario';
                            let selectRole = `
                            <select class="form-control role-select" data-user-id="${user.id}" data-original-role="${user.is_admin}">
                                <option value="0" ${user.is_admin ? '' : 'selected'}>Usuario</option>
                                <option value="1" ${user.is_admin ? 'selected' : ''}>Administrador</option>
                            </select>
                        `;

                            // Botones de editar y eliminar
                            let editButton =
                                `<button class="btn btn-warning btn-sm edit-user" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" ${isAdmin ? '' : 'disabled'}><i class="fa fa-paint-brush" aria-hidden="true"></i></button>`;
                            let deleteButton =
                                `<button class="btn btn-danger btn-sm delete-user" data-id="${user.id}" ${isAdmin ? '' : 'disabled'}><i class="fa fa-trash" aria-hidden="true"></i></button>`;


                            let row = `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${new Date(user.created_at).toLocaleDateString('es-ES')}</td>
                                    <td>${selectRole}</td>
                                    <td>
                                        ${editButton} 
                                        ${deleteButton}
                                    </td>
                                </tr>
                            `;

                            tbody.append(row);
                        });

                        // Manejo de la acción de editar
                        $('.edit-user').click(function() {
                            let userId = $(this).data('id');
                            let userName = $(this).data('name');
                            let userEmail = $(this).data('email');

                            // Cargar los datos en el modal
                            $('#editUserId').val(userId);
                            $('#editUserName').val(userName);
                            $('#editUserEmail').val(userEmail);

                            // Mostrar el modal
                            $('#editUserModal').modal('show');
                        });

                        // Manejo de la acción de eliminar
                        $('.delete-user').click(function() {
                            let userId = $(this).data('id');
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "No podrás recuperar este usuario después de eliminarlo.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Sí, eliminarlo!',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Realizar la llamada AJAX para eliminar el usuario
                                    $.ajax({
                                        url: `{{ url('usuarios/${userId}/eliminar') }}`,   
                                        method: "DELETE",
                                        data: {
                                            _token: '{{ csrf_token() }}' // Token CSRF
                                        },
                                        success: function(response) {
                                            Swal.fire(
                                                'Eliminado!',
                                                'El usuario ha sido eliminado.',
                                                'success'
                                            );
                                            loadUsers
                                        (); // Recargar la lista de usuarios
                                        },
                                        error: function() {
                                            Swal.fire(
                                                'Error!',
                                                'Hubo un problema al eliminar el usuario.',
                                                'error'
                                            );
                                        }
                                    });
                                }
                            });
                        });

                      
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al recuperar los datos.',
                        });
                    }
                });
            }

            loadUsers(); // Cargar los usuarios al iniciar

            // Manejo del formulario de edición de usuario
            $('#editUserForm').submit(function(event) {
                event.preventDefault(); // Prevenir el envío del formulario por defecto
                let userId = $('#editUserId').val();

                $.ajax({
                    url: `{{ url('usuarios/${userId}/actualizar') }}`, 
                    method: "POST",
                    data: $(this).serialize() + `&_token={{ csrf_token() }}`, // Añadir token CSRF
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario actualizado',
                                text: 'El usuario ha sido actualizado exitosamente.',
                            });
                            $('#editUserModal').modal('hide'); // Ocultar modal
                            loadUsers(); // Recargar la lista de usuarios
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        if (errors) {
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage ||
                                'Hubo un error al actualizar el usuario.',
                        });
                    }
                });
            });
        });
    </script>


@stop
