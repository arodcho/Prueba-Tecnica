<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TareasController;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

// Home routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Proyectos routes
Route::get('/proyectos', [App\Http\Controllers\ProyectosController::class, 'index'])->name('proyectos');
Route::post('proyectos/pdf', [App\Http\Controllers\ProyectosController::class, 'informePDF'])->name('pdf');
Route::post('proyectos/store', [App\Http\Controllers\ProyectosController::class, 'store'])->name('store');
Route::get('/informe/download', [App\Http\Controllers\ProyectosController::class, 'descargarInforme'])->name('informe.descargar');
Route::get('/api/proyectos', [App\Http\Controllers\ProyectosController::class, 'obtenerProyectos'])->name('api.proyectos');

// Usuarios routes
Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios');
Route::get('/api/usuarios', [App\Http\Controllers\UsuariosController::class, 'obtenerUsuarios'])->name('api.usuarios');
Route::post('/update-user-role', [App\Http\Controllers\UsuariosController::class, 'updateRole'])->name('updateUserRole');
Route::post('usuarios/crear', [App\Http\Controllers\UsuariosController::class, 'crearUsuario'])->name('crearUsuario');
Route::delete('usuarios/{id}/eliminar', [App\Http\Controllers\UsuariosController::class, 'eliminarUsuario'])->name('eliminarUsuario');
Route::post('usuarios/{id}/actualizar', [App\Http\Controllers\UsuariosController::class, 'actualizarUsuario'])->name('actualizarUsuario');

// Ruta para cargar tareas 
Route::get('/tareas', [App\Http\Controllers\TareasController::class, 'obtenerTareas'])->name('obtenerTareas');
Route::post('creartarea', [App\Http\Controllers\TareasController::class, 'crearTarea'])->name('crearTarea');
Route::get('/api/tareas', [App\Http\Controllers\TareasController::class, 'getTotalTareasRealizadas'])->name('api.tareas');

