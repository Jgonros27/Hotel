<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenSalon extends Model
{
    use HasFactory;

    // Columnas que pueden ser asignadas en masa
    protected $fillable = [
        'id_salon',
        'url',
        'nombre_imagen'
    ];

    // Relación de pertenencia a la tabla Salon
    public function salon(){
        return $this->belongsTo(Salon::class, 'id_salon');
    }
}
