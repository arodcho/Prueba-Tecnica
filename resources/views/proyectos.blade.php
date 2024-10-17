@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')




    <div class="d-flex">


        <table class="table bg-white w-50 mt-3 p-3 rounded shadow-md ">
            <thead>
                <tr>
                    <th class="text-start align-middle">
                        <h4 class="mb-0">Control de Proyectos</h4>
                    </th>
                    <th class="text-end">
                        <!-- Botones de Crear Proyecto y Generar PDF -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary p-2 m-2 rounded" data-toggle="modal"
                                data-target="#crearProyectoModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </button>

                            <a href="{{ route('proyectos.pdf') }}" class="btn btn-info p-2 m-2 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-file-description">
                                    <path stroke="none" d="M0 0h24V0H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    <path d="M9 17h6" />
                                    <path d="M9 13h6" />
                                </svg>
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="mt-3" id="projects-container">
                            <!-- Aquí se insertarán los proyectos dinámicamente -->
                        </div>

                    </td>



                </tr>
            </tbody>
        </table>
        <div id="calendar" class="w-50 bg-white m-3 p-2 mt-3"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="crearProyectoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="proyectos/store" method="POST">
                        @csrf

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Proyecto</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear proyecto</button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Detalles de la Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="taskDescription"></p>
                    <p>Inicio: <span id="taskStart"></span></p>
                    <p>Fin: <span id="taskEnd"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveTask">Guardar Tarea</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')


    <script>
        // Al cargar el DOM
        $(document).ready(function() {
            // Hacer la petición AJAX al cargar la página
            $.ajax({
                url: "{{ route('proyectos') }}", // Ruta al controlador
                method: "GET",
                dataType: "json",
                success: function(data) {
                    let container = $('#projects-container');
                    container.empty(); // Limpiar contenido anterior

                    if (data.length === 0) {
                        container.append(`<p class="text-center">No hay proyectos creados.</p>`);
                    } else {
                        data.forEach(function(project) {
                            let card = `
                        <div class="card project-card" data-id="${project.id}" draggable="true">
                            <div class="card-body p-3 rounded d-flex justify-content-between bg-yellow">
                                <div>
                                    <h5 class="card-title font-bold mb-2">${project.name}</h5>
                                    <p class="card-text text-muted">Creado por usuario ID: ${project.user_id}</p>
                                </div>
                                <div class="d-flex align-items-end">
                                    <small class="text-muted">${new Date(project.created_at).toLocaleDateString()}</small>
                                </div>
                            </div>
                        </div>
                    `;
                            container.append(card); // Agregar tarjeta al contenedor
                        });

                        // Habilitar el arrastre
                        $('.project-card').draggable({
                            revert: "invalid", // Si no se suelta en un lugar válido, vuelve a su lugar original
                            helper: "clone" // Clona la tarjeta mientras se arrastra
                        });
                    }
                },
                error: function() {
                    alert('Hubo un error al recuperar los datos.');
                }
            });



            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridDay', // Cambiar a timeGridDay
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay' // Cambiar formato de vista
            
                },
                locale: 'es', // Configura el idioma
                slotDuration: '00:30:00', // Intervalo de 30 minutos
                slotLabelInterval: {
                    minutes: 30
                }, // Etiquetas de 30 minutos
                slotLabelFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: 'short'
                },
                scrollTime: '08:00:00', // Hora de inicio de la vista
                allDaySlot: false, // Deshabilitar la ranura de todo el día
                editable: true //


            });

            calendar.render();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>

@stop
