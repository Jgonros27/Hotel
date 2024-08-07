<?php

namespace Database\Factories;

use App\Models\Salon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservaSalon>
 */
class ReservaSalonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuarioExistente = User::inRandomOrder()->first();

        $salonExistente = Salon::inRandomOrder()->first();

        $horaInicio = $this->faker->time;

        $horaInicioObj = new \DateTime($horaInicio);
        $horaFinObj = clone $horaInicioObj;
        $horaFinObj->modify('+8 hours');
        $horaFin = $horaFinObj->format('H:i:s');

        return [
            "id_usuario"=>$usuarioExistente,
            "id_salon"=>$salonExistente,
            "fecha_evento"=>$this->faker->date,
            "hora_inicio"=>$horaInicio,
            "hora_fin"=>$horaFin,
            "tipo_evento"=>$this->faker->randomElement(['cumpleaños','boda',"bautizo","comunion","evento_empresarial","otros"]),
            "mensaje"=>$this->faker->text(),
        ];
    }
}
