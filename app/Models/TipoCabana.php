<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCabana extends Model
{
    use HasFactory;

    // Lista de campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'nombre',
        'precio',
        'capacidad',
        'servicios',
        'precio_media_pension',
        'dias_cancelacion',
        'especificaciones',
    ];

    // Relación uno a muchos con la tabla Cabana
    public function cabanas(){
        return $this->hasMany(Cabana::class);
    }

    // Relación uno a muchos con la tabla ImagenCabana
    public function imagenCabanas(){
        return $this->hasMany(ImagenCabana::class,'id_tipo_cabana');
    }

    // Relación uno a muchos con la tabla Oferta
    public function ofertas(){
        return $this->hasMany(Oferta::class);
    }
}
