@extends('adminlte::page')

<!-- TITULO -->
@section('title', 'Control de proyectos')

<!-- HEADER -->
@section('content_header')
    <h1>Control de Proyectos</h1>

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop

<!-- CSS -->
@section('css')
    <style>
        .fc .fc-toolbar-title {
            font-size: 1rem;
            font-weight: normal;
            padding: 0.25rem;
        }
        footer {
            margin-top: 6rem;
            position: fixed; bottom: 0; 
            left: 0; 
            right: 0;
             z-index: 1030;
        }
        #projects-container{
            background-color: #f8f9fa;
        }

        #botonInforme{
            background-color: #001c56; color: white; width: 50px; height: 50px;
        }

        #botonProyecto{
            background-color: #001c56; color: white; width: 50px; height: 50px;
        }
        #botonEvento{
            display: none;
        }
        #informacionFechaProyecto {
              margin-left: auto;
        }

        .modal-header{
            background-color: #001c56; 
            color: white;
        }
      

    </style>
@stop


<!-- CONTENT -->
@section('content')
 {{-- Mensaje de éxito al crear o actualizar un usuario --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
    });
</script>
@endif

        {{-- Contenido --}}
    <div class="d-flex flex-column flex-lg-row">
        <div class="w-100 w-lg-50 mt-3 p-3 rounded shadow-md border-0 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Listado</h3>
                <div class="btn-group">
                    {{-- Botón para crear proyecto --}}
                    <button type="button" class="btn p-2 m-2 rounded" id="botonProyecto" data-toggle="modal" data-target="#crearProyectoModal"
                        @if (!Auth::user()->is_admin) disabled title="Solo los administradores pueden crear proyectos." @endif>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>

                    {{-- Boton para modal de generar informe --}}
                    <button type="button" class="btn p-2 m-2 rounded" id="botonInforme" data-toggle="modal" data-target="#generarInformeModal">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </button>

                    {{-- Boton para modal de agregar tarea al calendario --}}
                    <button type="button" class="btn p-2 m-2 rounded" id="botonEvento"
                        data-toggle="modal" data-target="#eventModal">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </button>
                </div>
            </div>


            {{-- Contenedor de proyectos --}}
            <div class="mt-3 p-3 rounded shadow-sm" id="projects-container">
                <!-- Insercción de proyectos dinámicamente -->
            </div>
        </div>
            
            {{-- Calendario --}}
            <div id="calendar" class="w-100 w-lg-50 bg-white m-3 p-2 mt-3"></div>
        
    </div>

    <!-- Modal Crear Proyecto -->
    <div class="modal fade" id="crearProyectoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="proyectos/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Proyecto</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check" aria-hidden="true"></i> Crear proyecto
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                    </button>

                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Generar Informe -->
    <div class="modal fade" id="generarInformeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Opciones del informe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="proyectos/pdf" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fechadesde" class="form-label">Fecha Desde</label>
                                <input type="date" name="fechadesde" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fechahasta" class="form-label">Fecha Hasta</label>
                                <input type="date" name="fechahasta" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="proyecto" class="form-label">Proyecto</label>
                            <select name="proyecto" id="proyecto" class="form-control">
                                <option value="">Seleccione un proyecto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="usuario2" class="form-label">Usuario</label>
                            <select name="usuario" id="usuario2" class="form-control">
                                <option value="">Seleccione un usuario</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-file-pdf" aria-hidden="true"></i> Generar informe
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                    </button>

                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Tarea a Calendario -->
    <div class="modal fade" id="eventModal" class="eventModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="creartarea" method="POST">
                        @csrf
                        <div>
                            <div>
                                <label for="fechadesde" class="form-label">Inicio Tarea</label>
                                <input type="datetime-local" name="fechainicio" class="form-control"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="proyecto" class="form-label mt-2">Texto informativo</label>
                            <textarea name="descripcion" class="form-control" style="height: 125px;resize: none;" maxlength="125" required></textarea>

                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label mt-2">Fin tarea</label>
                            <input type="datetime-local" name="fechafin" class="form-control"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">

                        </div>
                        <input type="hidden" id="projectId" name="proyecto_id" class="form-control">
                        <input type="hidden" name="usuario_id" class="form-control" value="{{ Auth::user()->id }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save" aria-hidden="true"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop

<!-- FOOTER -->
@section('footer')
    <footer class="w-100 bg-light text-black pt-3 mt-6 pb-3 border-top text-left">
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



<!-- JS -->
@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>

    <script>
        $(document).ready(function() {
            // Cargar proyectos
            $.ajax({
                url: "{{ route('proyectos') }}",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    let container = $('#projects-container');
                    container.empty();

                    if (data.length === 0) {
                        container.append(`<p class="text-center">No hay proyectos creados.</p>`);
                    } else {
                        // Ordenar por fecha de creación
                        data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                        // Recorrer los proyectos y crear las tarjetas
                        data.forEach(function(project) {
                            let card = `
                        <div class="card project-card fc-event" data-id="${project.id}" 
                             data-event='{ "title": "${project.name}", "id": "${project.id}" }'>
                            <div class="card-body p-3 rounded d-flex justify-content-between bg-yellow">
                                <div>
                                    <h5 class="card-title font-bold mb-2">${project.name}</h5>
                                    <p class="card-text text-muted">Creado por usuario ID: ${project.user_id}</p>
                                </div>
                                <div class="d-flex align-items-end" id="informacionfechaCreacion">
                                    <small class="text-muted">${new Date(project.created_at).toLocaleDateString()}</small>
                                </div>
                            </div>
                        </div>`;
                            container.append(card); // Agregar la tarjeta al contenedor
                        });

                        // Hacer las tarjetas arrastrables
                        $('.project-card').draggable({
                            zIndex: 999,
                            revert: 'invalid', // Vuelve a su lugar si no se suelta en el calendario
                            stop: function(event, ui) {
                                // Mostrar modal para agregar evento
                                const projectData = JSON.parse($(this).attr('data-event'));
                                $('#eventTitle').val(projectData
                                    .title); // Pre-llenar el título del evento
                                $('#projectId').val(projectData
                                    .id); // Guardar el ID del proyecto
                                // $('#eventModal').modal('show'); // Mostrar el modal
                                $('#botonEvento').click();
                            }
                        });
                    }
                }, error: function() { // Manejo de errores
                    alert('Hubo un error al recuperar los datos.');
                }
            });

// ----------------------------------------------------------------------------------------------------------------------------------------

            // Inicializar el calendario
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: { // Header del calendario
                    left: 'prev,dayGridMonth,next,today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                buttonText: { // Texto de los botones
                    today: "Hoy",
                    timeGridWeek: "Semana",
                    timeGridDay: "Día",
                    dayGridMonth: " "
                },
                slotLabelFormat: { // Formato de la hora
                    hour: 'numeric',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: 'short'
                },
                slotLabelInterval: { // Intervalo de la hora
                    minutes: 30
                },
                customButtons: { // Selector de usuario
                    userSelect: {
                        text: ' ', // No necesita texto
                        click: function() {} // No necesita acción
                    }
                },
                initialView: 'timeGridDay', // Vista inicial
                locale: 'es',  // Idioma
                scrollTime: '08:00:00', // Hora de inicio
                allDaySlot: false, // No mostrar eventos de todo el día
                editable: true, // Permitir editar eventos
                selectable: true, // Permitir seleccionar eventos
                droppable: true, // Permitir soltar eventos en el calendario
                nowIndicator: true, // Indicador de hora actual
                now: new Date(), // Hora y fecha actuales
                events: function(fetchInfo, successCallback, failureCallback) {
                    let userId = $('#usuario').val();
                    let url = userId ? '/tareas/' + userId :
                        '/tareas'; // Ruta para cargar eventos con o sin ID del proyecto
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(data) {
                            successCallback(data);
                        },
                        error: function() {
                            failureCallback();
                        }
                    });
                },
                // Evento al soltar un proyecto (Error con el constructor Draggable, no permite utilizar evento)
                // drop: function(info) {
                //     console.log('Dropeado');
                // }
            });

            calendar.render();

            // Crear el selector de usuario
            const userSelect = document.createElement('select');
            userSelect.id = 'usuario';
            userSelect.classList.add('form-control', 'mb-3'); // Añadir clase para espaciado
            userSelect.style.width = '200px'; // Ajustar el ancho del select
            userSelect.innerHTML = `
        <option value="">Seleccione un usuario</option>
    `;
            // Evento para recargar tareas al cambiar de usuario
            userSelect.addEventListener('change', function() {
                calendar.refetchEvents(); // Recargar eventos según el usuario seleccionado
            });

            // Agregar el selector de usuario al calendario
            const toolbarLeft = document.querySelector('.fc-toolbar-chunk:first-child');
            toolbarLeft.prepend(userSelect);

            // Añadir ícono de calendario al botón del mes
            const monthButton = document.querySelector('.fc-dayGridMonth-button');
            if (monthButton) {
                monthButton.innerHTML = '<i class="fas fa-calendar"></i>';
            }

// ----------------------------------------------------------------------------------------------------------------------------------------

            // AJAX para cargar los eventos

            // Cargar proyectos en el modal de informe
            $.ajax({
                url: "{{ route('api.proyectos') }}", // Consultar api de proyectos
                method: "GET",
                success: function(data) {
                    let proyectoSelect = $('#proyecto');
                    data.forEach(function(proyecto) {
                        proyectoSelect.append(
                            `<option value="${proyecto.id}">${proyecto.name}</option>`);
                    });
                },
                error: function() {
                    alert('Error al cargar los proyectos.');
                }
            });

            // Cargar usuarios en el selector de usuarios del calendario
            $.ajax({
                url: "{{ route('api.usuarios') }}", // Consultar api de usuarios
                method: "GET",
                success: function(data) {
                    let usuarioSelect = $('#usuario');
                    data.forEach(function(usuario) {
                        usuarioSelect.append(
                            `<option value="${usuario.id}">${usuario.name}</option>`);
                    });
                },
                error: function() {
                    alert('Error al cargar los usuarios.');
                }
            });
        });

        // Cargar usuarios en el modal de informe
        $.ajax({
            url: "{{ route('api.usuarios') }}", // Consultar api de usuarios
            method: "GET",
            success: function(data) {
                let usuarioSelect = $('#usuario2');
                data.forEach(function(usuario) {
                    usuarioSelect.append(
                        `<option value="${usuario.id}">${usuario.name}</option>`);
                });
            },
            error: function() { // Manejo de errores
                alert('Error al cargar los usuarios.');
            }
        });
    </script>
@stop
