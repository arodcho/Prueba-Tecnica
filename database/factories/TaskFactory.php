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
        return [
            'start' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'task_description' => $this->faker->sentence(5),
            'project_id' => Project::factory(),
            'user_id' => User::factory(), // Asociar la tarea a un proyecto
        ];
    }
}
