<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

          // Crear un usuario administrador predeterminado
          User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => 1,
            'password' => bcrypt('password'), // Encriptar la contraseña
            'remember_token' => null,
        ]);

        // Crear 3 usuarios
        User::factory(3)->create();

        // Crear 3 proyectos
        Project::factory(3)->create();

        // Crear 10 tareas
        Task::factory(10)->create();
    }
}
