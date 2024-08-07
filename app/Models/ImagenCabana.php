<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenCabana extends Model
{
    use HasFactory;

    // Columnas que pueden ser asignadas en masa
    protected $fillable = [
        'id_tipo_cabana',
        'url',
        'nombre_imagen'
    ];

    // Relación de pertenencia a la tabla TipoCabana
    public function tipoCabana(){
        return $this->belongsTo(TipoCabana::class, 'id_tipo_cabana');
    }
}
