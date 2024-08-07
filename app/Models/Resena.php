<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    // Columnas que pueden ser asignadas en masa
    protected $fillable = [
        'id_usuario',
        'puntuacion',
        'comentario'
    ];

    // Relación de pertenencia a la tabla User
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
