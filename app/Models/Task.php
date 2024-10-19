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

    /**
     * Relación con el modelo Project (Uno a Muchos).
     *
     * Esta relación indica que cada instancia de este modelo pertenece a un
     * único proyecto en la base de datos. Esto significa que se puede acceder
     * a los datos del proyecto asociado a través de esta relación.
     *
     */
    public function project()
    {
        return $this->belongsTo(Project::class); 
    }

    /**
     * Relación con el modelo User (Uno a Uno).
     *
     * Esta relación indica que cada instancia de este modelo pertenece a un
     * único usuario en la base de datos. Se puede acceder a los datos del
     * usuario asociado a través de esta relación.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
