<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use PDF as Pdf;

class InformeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Obtener los datos necesarios para generar informe pdf  
    public function informePDF(Request $request)
    {
         // dd($request);
        // Obtener los proyectos filtrados
        $proyectos = $this->obtenerProyectosFiltrados($request);

        // Extraer valores del request
        $desde = $request->input('fechadesde');
        $hasta = $request->input('fechahasta');
        $proyectoId = $request->input('proyecto');
        $usuarioId = $request->input('usuario');

        $proyecto = Project::find($proyectoId)->name ?? 'N/A';
        $usuario = User::find($usuarioId)->name ?? 'N/A';

        // Cargar la vista para el PDF con los datos
        $pdf = Pdf::loadView('informe', compact('proyectos', 'desde', 'hasta', 'proyecto', 'usuario'));

        return $pdf->download('informe-proyectos.pdf');
    }

     // Obtener todos proyectos filtrados por el usuario
     public function obtenerProyectosFiltrados(Request $request)
     {
         // dd($request);
         // Obtener los parámetros de la solicitud
         $projectId = $request->input('proyecto');
         $userId = $request->input('usuario');
         $start = $request->input('fechadesde') ? date('Y-m-d H:i:s', strtotime($request->input('fechadesde'))) : null;
         $end = $request->input('fechahasta') ? date('Y-m-d H:i:s', strtotime($request->input('fechahasta'))) : null;
 
         // Obtener las tareas filtrando por los siguientes parámetros
         $tasks = Task::query();
 
         if ($userId) {
             $tasks->where('user_id', $userId);
         }
 
         if ($projectId) {
             $tasks->where('project_id', $projectId);
         }
         if ($start) {
             $tasks->where('start', '>=', "$start");
         }
 
         if ($end) {
             $tasks->where('end', '<=', "$end");
         }
 
         $tasks = $tasks->get();
 
         // Obtener los proyectos con las tareas filtradas
         $proyectos = Project::whereIn('id', $tasks->pluck('project_id'))->with(['tasks' => function ($query) use ($userId, $start, $end) {
             if ($userId) {
                 $query->where('user_id', $userId);
             }
 
             if ($start) {
 
                 $query->where('start', '>=', "$start");
             }
 
             if ($end) {
 
                 $query->where('end', '<=', "$end");
             }
         }])->get();
 
         return $proyectos;
     }
}