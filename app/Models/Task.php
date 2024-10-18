<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Definir la tabla asociada si no sigue la convención de nombres
    protected $table = 'tasks';

    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'start',
        'end',
        'task_description',
        'project_id',
    ];

        
    public function project()
    {
        return $this->belongsTo(Project::class); 
    }

    // Relación con el modelo User (Uno a Uno)
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
