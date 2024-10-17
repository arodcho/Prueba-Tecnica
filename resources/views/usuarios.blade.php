@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')


    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Fecha de Creación</th>
        </tr>
    </thead>
    <tbody id="user-table-body">
        <!-- Aquí se insertarán las filas de usuarios dinámicamente -->
    </tbody>
</table>

<script>
    $(document).ready(function() {
        // Hacer la petición AJAX al cargar la página
        $.ajax({
            url: "{{ route('usuarios') }}", // Ruta al controlador
            method: "GET",
            dataType: "json",
            success: function(data) {

                console.log(data);
                let tbody = $('#user-table-body'); // Seleccionar el cuerpo de la tabla
                tbody.empty(); // Limpiar el contenido existente

                // Iterar sobre los usuarios y agregarlos a la tabla
                data.forEach(function(user) {

                    let row = `<tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                <td>${new Date(user.created_at).toLocaleDateString('es-ES')}</td> 
                    </tr>`;
                    tbody.append(row); // Agregar la fila a la tabla
                });
            },
            error: function() {
                alert('Hubo un error al recuperar los datos.');
            }
        });
    });
</script>


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop