{{-- 
    Vista del Dashboard principal de la aplicación.

    Extiende la plantilla de 'adminlte::page' y define varias secciones:
    - title: Título de la página.
    - content_header: Encabezado del contenido con el título "Dashboard".
    - content: Contenido principal que incluye tarjetas con información sobre el total de usuarios y proyectos, 
      así como información de la empresa.
    - footer: Pie de página fijo con información de derechos de autor, versión y desarrollador.
    - css: Sección para incluir estilos CSS adicionales (actualmente vacía).
    - js: Sección para incluir scripts JavaScript adicionales. 
      Incluye scripts para cargar datos de usuarios y proyectos mediante AJAX y actualizar el contenido de la página.

    El contenido principal incluye:
    - Dos tarjetas que muestran el número total de usuarios y proyectos.
    - Una tarjeta con información de la empresa.

    Los scripts JavaScript realizan peticiones AJAX a las rutas 'api.proyectos' y 'api.usuarios' para obtener 
    los datos y actualizar los elementos correspondientes en la página.
--}}
@extends('adminlte::page')

<!-- TITULO -->
@section('title', 'Inicio')

<!-- HEADER -->
@section('content_header')
    <h1>Inicio</h1>
@stop

<!-- CONTENT -->
@section('content')
    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="card bg-secondary text-white">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-users fa-2x mr-2"></i>
                    <h3 class="card-title mb-0">Total Usuarios</h3>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <div>
                        <p class="mb-0">Número total de usuarios:</p>
                        <h4 id="totalUsuarios" class="mb-0"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card bg-warning text-dark">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-project-diagram fa-2x mr-2"></i>
                    <h3 class="card-title mb-0">Total Proyectos</h3>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-tasks fa-3x"></i>
                    </div>
                    <div>
                        <p class="mb-0">Número total de proyectos:</p>
                        <h4 id="totalProyectos" class="mb-0"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card bg-info text-white">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-tasks fa-2x mr-2"></i>
                    <h3 class="card-title mb-0">Total Tareas Realizadas</h3>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-check fa-3x"></i>
                    </div>
                    <div>
                        <p class="mb-0">Número total de tareas realizadas:</p>
                        <h4 id="totalTareas" class="mb-0"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Empresa</h3>
        </div>
        <div class="card-body">
            <p>Nombre: Prueba Técnica</p>
            <p>Dirección: Córdoba, España</p>
            <p>Teléfono: 624 35 46 87</p>
            <p>Email:
                <a href="mailto:prueba@gmail.com">prueba@gmail.com</a>
            </p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 col-12">
            <a href="usuarios" class="card text-white text-decoration-none" style="background-color: #001c56;">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-users fa-2x mr-2"></i>
                    <h3 class="card-title mb-0">Ver Usuarios</h3>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="mb-0">Ir a la vista de usuarios</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-6 col-12">
            <a href="proyectos" class="card text-white text-decoration-none" style="background-color: #001c56;">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-project-diagram fa-2x mr-2"></i>
                    <h3 class="card-title mb-0">Ver Proyectos y Tareas</h3>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="mb-0">Ir a la vista de proyectos y tareas</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

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
            /**
             * Carga los proyectos mediante una solicitud AJAX GET y los agrega como opciones en el selector de proyectos.
             * También actualiza el contador de proyectos en el elemento con ID 'totalProyectos'.
             */
            $.ajax({
                url: "{{ route('api.proyectos') }}", // Ruta de la API para obtener los proyectos.
                method: "GET", // Método HTTP utilizado para la solicitud.
                success: function(data) {


                    // Actualiza el total de proyectos.
                    $('#totalProyectos').text(data.length);
                },
                error: function() {
                    // Muestra una alerta si la solicitud falla.
                    alert('Error al cargar los proyectos.');
                }
            });

            /**
             * Carga los usuarios mediante una solicitud AJAX GET y los agrega como opciones en el selector de usuarios.
             * También actualiza el contador de usuarios en el elemento con ID 'totalUsuarios'.
             */
            $.ajax({
                url: "{{ route('api.usuarios') }}", // Ruta de la API para obtener los usuarios.
                method: "GET", // Método HTTP utilizado para la solicitud.
                success: function(data) {

                    // Actualiza el total de usuarios.
                    $('#totalUsuarios').text(data.length);
                },
                error: function() {
                    // Muestra una alerta si la solicitud falla.
                    alert('Error al cargar los usuarios.');
                }
            });

            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('api.tareas') }}", // Ruta de la API para obtener el total de tareas
                    method: "GET", // Método HTTP utilizado para la solicitud
                    success: function(data) {
                        // Actualiza el total de tareas realizadas
                        $('#totalTareas').text(data.length);

                    },
                    error: function() {
                        // Muestra una alerta si la solicitud falla
                        alert('Error al cargar el total de tareas realizadas.');
                    }
                });
            });


        });
    </script>

    </script>
@stop
