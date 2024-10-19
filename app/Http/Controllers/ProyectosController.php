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
        // Obtener todos los proyectos
        $projects = Project::all();

        if (request()->ajax()) {
            return response()->json($projects); // Devolver los usuarios en formato JSON para solicitudes AJAX
        }

        return view('proyectos'); // Devolver la vista si no es una solicitud AJAX
    }

    // Crear un nuevo proyecto
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        Project::create([
            'name' => $request['nombre'],
            'description' => '',
            'user_id' => Auth::user()->id,


        ]);
        return redirect()->back()->with('success', 'Proyecto creado correctamente.');
    }



    // Obtener todos los proyectos
    public function obtenerProyectos()
    {
        $proyectos = Project::all();
        return response()->json($proyectos);
    }
}
