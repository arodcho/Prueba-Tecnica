<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use PDF;

use Illuminate\Support\Facades\Auth;

class ProyectosController extends Controller

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Project::all();

        if (request()->ajax()) {
            return response()->json($projects); // Devolver los usuarios en formato JSON para solicitudes AJAX
        }

        return view('proyectos'); // Devolver la vista si no es una solicitud AJAX
    }

    public function store(Request $request)
    {

        Project::create([
            'name' => $request['nombre'],
            'description' => '',
            'user_id' => Auth::user()->id,


        ]);
        return redirect()->back()->with('success', 'Proyecto creado correctamente.');
    }

    public function informePDF(Request $request)
    {
        // Obtener los proyectos filtrados
        $proyectos = $this->obtenerProyectosFiltrados($request);

        // Extraer valores del request
        $desde = $request->input('fechadesde');
        $hasta = $request->input('fechahasta');
        $proyecto = $request->input('proyecto');
        $usuario = $request->input('usuario');

        // Cargar la vista para el PDF con los datos
        $pdf = Pdf::loadView('informe', compact('proyectos', 'desde', 'hasta', 'proyecto', 'usuario'));

        return $pdf->download('informe-proyectos.pdf');
    }


    public function obtenerProyectosFiltrados(Request $request)
    {
        // Obtener los parámetros de la solicitud
        $projectId = $request->input('proyecto');
        $userId = $request->input('usuario');
        $start = $request->input('fechadesde') ? date('Y-m-d H:i:s', strtotime($request->input('fechadesde'))) : null;
        $end = $request->input('fechahasta') ? date('Y-m-d H:i:s', strtotime($request->input('fechahasta'))) : null;

        // Obtener las tareas basadas en user_id y project_id
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


    public function obtenerProyectos()
    {
        $proyectos = Project::all();
        return response()->json($proyectos);
    }
}
