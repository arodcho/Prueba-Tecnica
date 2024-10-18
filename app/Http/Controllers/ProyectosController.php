<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use PDF;
use Illuminate\Support\Facades\Auth;

class ProyectosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        $projects = Project::all();

        if (request()->ajax()) {
            return response()->json($projects);
        }

        return view('proyectos');
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
        $proyectos = $this->obtenerProyectosFiltrados($request);

        $desde = $request->input('fechadesde');
        $hasta = $request->input('fechahasta');
        $proyecto = $request->input('proyecto');
        $usuario = $request->input('usuario');

        $pdf = PDF::loadView('informe', compact('proyectos', 'desde', 'hasta', 'proyecto', 'usuario'));

        return $pdf->download('informe-proyectos.pdf');
    }

    public function obtenerProyectosFiltrados(Request $request)
    {
        $projectId = $request->input('proyecto');
        $userId = $request->input('usuario');
        $start = $this->formatDate($request->input('fechadesde'));
        $end = $this->formatDate($request->input('fechahasta'));

        $tasks = Task::query();

        if ($userId) {
            $tasks->where('user_id', $userId);
        }

        if ($projectId) {
            $tasks->where('project_id', $projectId);
        }

        if ($start) {
            $tasks->where('start', '>=', $start);
        }

        if ($end) {
            $tasks->where('end', '<=', $end);
        }

        $tasks = $tasks->get();

        return Project::whereIn('id', $tasks->pluck('project_id'))
            ->with(['tasks' => function ($query) use ($userId, $start, $end) {
                if ($userId) {
                    $query->where('user_id', $userId);
                }

                if ($start) {
                    $query->where('start', '>=', $start);
                }

                if ($end) {
                    $query->where('end', '<=', $end);
                }
            }])->get();
    }

    public function obtenerProyectos()
    {
        $proyectos = Project::all();
        return response()->json($proyectos);
    }

    private function formatDate(?string $date): ?string
    {
        return $date ? date('Y-m-d H:i:s', strtotime($date)) : null;
    }
}
