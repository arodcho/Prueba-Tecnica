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

    /**
     * Get all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerUsuarios()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    /**
     * Update user role.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRole(Request $request)
    {
        // dd($request);
        $request->validate([
            'user_id' => 'required|integer',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->is_admin = $request->is_admin;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Create a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Delete a user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update user information.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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
