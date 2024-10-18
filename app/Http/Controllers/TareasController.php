<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TareasController extends Controller
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

    public function obtenerTareas()
    {
        $tareas = Task::with('project') // Eager loading para obtener el proyecto relacionado
    ->select("id", "task_description", "project_id", "start", "end")
    ->get();

$datos = array();

foreach ($tareas as $t) {
    $datos[] = array(
        "id" => $t["id"],
        "title" => $t->project ? $t->project->name : 'Sin Proyecto', // Obtener el nombre del proyecto
        "start" => $t["start"],
        "end" => $t["end"],
        "description" => $t["task_description"]
    );
}

    return response()->json($datos);
    }

    // Crear una nueva tarea
    public function crearTarea( Request $request )
    {
        $request->validate([
            'descripcion' => 'required',
            'proyecto_id' => 'required',
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'usuario_id' => 'required'
        ]);
        $tarea = new Task();
        $tarea->task_description = $request->descripcion;
        $tarea->project_id = $request->proyecto_id;
        $tarea->start = $request->fechainicio;
        $tarea->end = $request->fechafin;
        $tarea->user_id = $request->usuario_id;
        $tarea->save();

        return redirect()->route('proyectos')->with('success', 'Tarea creada correctamente');
    }


}
