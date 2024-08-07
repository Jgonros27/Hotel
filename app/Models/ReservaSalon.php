<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaSalon extends Model
{
    use HasFactory;

    // Lista de campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'id_usuario',
        'id_salon',
        'fecha_evento',
        'hora_inicio',
        'hora_fin',
        'tipo_evento',
        'mensaje',
        'precio_final'
    ];

    // Relación de pertenencia a la tabla User
    public function usuario(){
        return $this->belongsTo(User::class,"id_usuario");
    }

    // Relación de pertenencia a la tabla Salon
    public function salon(){
        return $this->belongsTo(Salon::class,"id_salon");
    }

    // Función estática para calcular la diferencia de horas entre dos horas dadas
    static function calcularHorasEntreDosHoras($horaInicio, $horaFin) {
        // Convertir las horas a formato de 24 horas
        $horaInicio24 = date("H:i", strtotime($horaInicio));
        $horaFin24 = date("H:i", strtotime($horaFin));
    
        // Calcular los minutos desde la medianoche para cada hora
        $minutosInicio = $horaInicio24 ? (int)substr($horaInicio24, 0, 2) * 60 + (int)substr($horaInicio24, 3, 2) : 0;
        $minutosFin = $horaFin24 ? (int)substr($horaFin24, 0, 2) * 60 + (int)substr($horaFin24, 3, 2) : 0;
    
        // Calcular la diferencia en minutos entre las dos horas
        $diferenciaMinutos = $minutosFin - $minutosInicio;
    
        // Convertir la diferencia a horas
        $horas = $diferenciaMinutos / 60;
    
        // Devolver el resultado con 1 decimal
        return number_format($horas, 1);
    }
}
