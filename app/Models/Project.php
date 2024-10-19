<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',

    ];
    
     /**
     * Relación con el modelo User (Uno a Uno).
     *
     * Esta relación indica que cada instancia de este modelo está asociada
     * a un único usuario en la base de datos. Por lo tanto, se puede acceder
     * a los datos del usuario a través de esta relación.
     *
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relación con el modelo Task (Uno a Muchos).
     *
     * Esta relación indica que cada instancia de este modelo puede estar
     * asociada a múltiples tareas en la base de datos. Se puede acceder a
     * todas las tareas relacionadas a través de esta relación.
     *
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
