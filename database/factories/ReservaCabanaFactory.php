<?php

namespace Database\Factories;

use App\Models\Cabana;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservaCabana>
 */
class ReservaCabanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuarioExistente = User::where('admin', false)->inRandomOrder()->first();

        while (!$usuarioExistente) {
            $usuarioExistente = User::where('admin', false)->inRandomOrder()->first();
        }
        
        $cabanaExistente = Cabana::inRandomOrder()->first();

        $fechaEntrada = $this->faker->dateTimeBetween('now', '+30 days');
        $fechaSalida = $this->faker->dateTimeBetween($fechaEntrada, '+30 days')->format('Y-m-d');

        return [
            "id_cabana"=>$cabanaExistente,
            "id_usuario"=>$usuarioExistente,
            "fecha_entrada"=>$fechaEntrada,
            "fecha_salida"=>$fechaSalida,
            "n_huespedes"=>$this->faker->numberBetween(1,7),
            "media_pension"=>$this->faker->boolean(),
        ];
    }
}
