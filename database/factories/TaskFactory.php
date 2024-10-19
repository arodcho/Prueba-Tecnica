<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

     public function definition()
    {
        // Generar una fecha aleatoria dentro de una semana a partir de ahora
        $date = $this->faker->dateTimeBetween('now', '+1 week');
        
        // Mantener la fecha, pero cambiar la hora aleatoriamente
        $startHour = $this->faker->numberBetween(0, 23); // Hora de inicio aleatoria
        $endHour = $this->faker->numberBetween($startHour + 1, 23); // Hora de fin aleatoria después de la hora de inicio

        return [
            'task_description' => $this->faker->sentence(),
            'start' => $this->modificarDateTime($date, $startHour), // Ajustar la hora de inicio
            'end' => $this->modificarDateTime($date, $endHour), // Ajustar la hora de fin
            'project_id' => $this->faker->randomElement(\App\Models\Project::pluck('id')->toArray()),
            'user_id' => $this->faker->randomElement(\App\Models\User::pluck('id')->toArray()),
        ];
    }

    // Función para modificar la hora de un DateTime
    private function modificarDateTime($date, $hour)
    {
        return (clone $date)->setTime($hour, 0); // Cambia los minutos a 0
    }
}
