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
            return response()->json($users);
        }

        return view('usuarios');
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    //Actualizar rol del usuario 
    public function actualizarRol(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::find($request->user_id);

        // Verificar si el usuario autenticado está intentando cambiar su propio rol
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No puedes cambiar tu propio rol.'], 403);
        }

        if ($user) {
            $user->is_admin = $request->is_admin; // Actualizar el rol
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    // Crear un nuevo usuario 
    public function crearUsuario(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_admin = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }

    
     // Eliminar un usuario mediante id.
   
    public function eliminarUsuario($id)
    {
        // dd($request);
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    // Actualizar un usuario mediante id.
    public function actualizarUsuario(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
