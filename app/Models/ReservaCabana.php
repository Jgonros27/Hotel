<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaCabana extends Model
{
    use HasFactory;

    // Lista de campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'id_usuario',
        'id_cabana',
        'fecha_entrada',
        'fecha_salida',
        'n_huespedes',
        'media_pension',
        'precio_habitacion',
        'precio_final',
        'precio_total',
        'descuento',
        'id_pago'
    ];

    // Relación de pertenencia a la tabla User
    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación de pertenencia a la tabla Cabana
    public function cabana(){
        return $this->belongsTo(Cabana::class, 'id_cabana');
    }
}
