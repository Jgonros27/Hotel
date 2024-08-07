<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    // Lista de campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_hora',
    ];

    // Relación uno a muchos con la tabla ReservaSalon
    public function reservaSalons(){
        return $this->hasMany(ReservaSalon::class);
    }

    // Relación uno a muchos con la tabla ImagenSalon
    public function imagenSalons(){
        return $this->hasMany(ImagenSalon::class,'id_salon');
    }
}
