<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'email',
        'password',
        'is_admin',
    ];

   /**
     * Relación con el modelo Project (Uno a Muchos).
     *
     * Esta relación indica que cada instancia de este modelo puede estar
     * asociada a múltiples proyectos en la base de datos. Por lo tanto, se
     * puede acceder a todos los proyectos relacionados a través de esta
     * relación.
     *
     */
    public function proyectos()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Relación con el modelo Task (Muchos a Muchos).
     *
     * Esta relación indica que cada instancia de este modelo puede estar
     * asociada a múltiples tareas en la base de datos, y que cada tarea
     * puede estar asociada a múltiples instancias de este modelo. Esto permite
     * acceder a todas las tareas relacionadas a través de esta relación.
     *
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
