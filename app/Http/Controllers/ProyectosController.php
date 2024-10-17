<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
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
 
     public function informePDF()
     {
         $proyectos = Project::all();
         $pdf = Pdf::loadView('informe', compact('proyectos'));
         return $pdf->download('informe-proyectos.pdf');
     }
}