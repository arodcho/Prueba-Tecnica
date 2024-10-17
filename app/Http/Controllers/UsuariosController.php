<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UsuariosController extends Controller
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
         $users = User::all();
     
         if (request()->ajax()) {
             return response()->json($users); // Devolver los usuarios en formato JSON para solicitudes AJAX
         }
     
         return view('usuarios'); // Devolver la vista si no es una solicitud AJAX
     }
     

}