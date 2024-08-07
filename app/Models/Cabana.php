<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabana extends Model
{
    use HasFactory;

    // Columnas que pueden ser asignadas en masa
    protected $fillable = [
        'id_tipo_cabana',
    ];

    // Relación de pertenencia a la tabla TipoCabana
    public function tipoCabana(){
        return $this->belongsTo(TipoCabana::class, 'id_tipo_cabana');
    }

    // Relación de una cabaña con muchas reservas de cabaña
    public function reservaCabanas(){
        return $this->hasMany(ReservaCabana::class);
    }
}
