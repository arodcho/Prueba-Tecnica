<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #fff;
        }
        .header img {
            max-width: 150px;
        }

        h2 {

            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;

            font-size: 0.75rem;
        }

        th {
            background-color: #f2f2f2;
        }

        .content {
            flex: 1;
            padding: 20px;
        }
        
    </style>
</head>

<body>
    <!-- ENCABEZADO DEL INFORME -->
    <div class="header row" style="border: 3px solid #ddd; padding: 10px; margin: 20px; display: flex;">

        <!-- LOGO DE LA EMPRESA -->
        <div class="logo col-md-6">
            <img src="{{ public_path('img/AdminLTELogo.png') }}" alt="Logo" style="max-width: 100%; height: auto;">
        </div>

        <!-- INFORMACIÓN DE LA EMPRESA Y FILTROS -->
        <div class="company-info col-md-6">

            <!-- Título del Informe -->
            <h1 style="text-align: left; margin-bottom: 15px; color: #001c56;">Prueba Técnica</h1>

            <!-- Tabla de Parámetros (fechas, proyecto y usuario) -->
            <div style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td
                            style="width: 25%; padding: 8px; background-color: #001c56; color: white; font-weight: bold;">
                            Desde
                        </td>
                        <td style="width: 25%; padding: 8px; border: 1px solid #ddd;">{{ $desde ?? '-' }}</td>
                        <td
                            style="width: 25%; padding: 8px; background-color: #001c56; color: white; font-weight: bold;">
                            Hasta
                        </td>
                        <td style="width: 25%; padding: 8px; border: 1px solid #ddd;">{{ $hasta ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td
                            style="width: 25%; padding: 8px; background-color: #001c56; color: white; font-weight: bold;">
                            Proyecto
                        </td>
                        <td style="width: 25%; padding: 8px; border: 1px solid #ddd;">{{ $proyecto ?? '-' }}</td>
                        <td
                            style="width: 25%; padding: 8px; background-color: #001c56; color: white; font-weight: bold;">
                            Usuario
                        </td>
                        <td style="width: 25%; padding: 8px; border: 1px solid #ddd;">{{ $usuario ?? '-' }}</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>


    <!-- CONTENIDO DEL INFORME -->
    <div class="content">
        <!-- Título de la sección de tareas -->
        <div
            style="border: 2px solid #000; padding: 5px; text-align: center; font-weight: bold; color: #001c56; font-size: 15px;">
            <h3>INFORME DE TAREAS REALIZADAS</h3>
        </div>

        <!-- Recorrido de proyectos y sus tareas -->
        @forelse ($proyectos as $proyecto)
            <div class="project">
                <table style="width: 100%; margin-bottom: 20px;">
                    <thead>
                        <tr>
                            <!-- Nombre del Proyecto -->
                            <th colspan="6"
                                style="text-align: center; background-color: #d3d3d3; font-weight: bold; text-transform: uppercase;">
                                {{ $proyecto->name }}
                            </th>
                        </tr>
                        <tr>
                            <th style="background-color: #001c56; color: white;">ID</th>
                            <th style="background-color: #001c56; color: white;">Inicio</th>
                            <th style="background-color: #001c56; color: white;">Fin</th>
                            <th style="background-color: #001c56; color: white;">Min</th>
                            <th style="background-color: #001c56; color: white;">Usuario</th>
                            <th style="background-color: #001c56; color: white;">Tarea realizada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Inicialización del contador de minutos -->
                        @php $totalMinutos = 0; @endphp

                        <!-- Iteración de las tareas del proyecto -->
                        @forelse ($proyecto->tasks as $tarea)
                            @php
                                // Cálculo de la duración de la tarea en minutos
                                $duracion = round(
                                    \Carbon\Carbon::parse($tarea->start)->diffInMinutes(
                                        \Carbon\Carbon::parse($tarea->end),
                                    ),
                                );
                                // Acumulación del total de minutos
                                $totalMinutos += $duracion;
                            @endphp

                            <tr>
                                <!-- Información de la tarea -->
                                <td>{{ $tarea->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($tarea->start)->format('d/m/Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tarea->end)->format('d/m/Y H:i') }}</td>
                                <td>{{ $duracion }}</td>
                                <td>{{ $tarea->user->name ?? 'Sin usuario' }}</td>
                                <td>{{ $tarea->task_description }}</td>
                            </tr>
                        @empty
                            <!-- Mensaje si no hay tareas en el proyecto -->
                            <tr>
                                <td colspan="6" style="text-align: center;">No hay tareas para este proyecto.</td>
                            </tr>
                        @endforelse

                        <!-- Total de minutos del proyecto -->
                        @if ($totalMinutos > 0)
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;">Total minutos:</td>
                                <td style="font-weight: bold;">{{ $totalMinutos }}</td>
                                <td colspan="2"></td> <!-- Celdas vacías para mantener la estructura -->
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @empty
            <!-- Mensaje si no hay proyectos disponibles -->
            <p>No hay proyectos disponibles.</p>
        @endforelse
    </div>

</body>

</html>
