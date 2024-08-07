<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    // Columnas que pueden ser asignadas en masa
    protected $fillable = [
        'id_tipo_cabana',
        'descuento',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Relación de pertenencia a la tabla TipoCabana
    public function tipoCabana(){
        return $this->belongsTo(TipoCabana::class, 'id_tipo_cabana');
    }
}
