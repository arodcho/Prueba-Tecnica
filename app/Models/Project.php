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
    // Relación con el modelo User (Uno a Uno)
    public function user()
    {
        return $this->hasOne(User::class);
    }
    
    // Relación con el modelo Task (Uno a Muchos)
    public function tasks()
    {
        return $this->hasMany(Task::class); 
    }
}
