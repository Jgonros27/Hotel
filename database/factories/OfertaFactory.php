<?php

namespace Database\Factories;

use App\Models\TipoCabana;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Oferta>
 */
class OfertaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $tipoCabanaExistente = TipoCabana::inRandomOrder()->first();

        $fechaInicio = $this->faker->dateTimeBetween('now', '+30 days');
        $fechaFin = $this->faker->dateTimeBetween($fechaInicio, '+30 days')->format('Y-m-d');

        return [
            "id_tipo_cabana"=>$tipoCabanaExistente,
            "descuento"=>$this->faker->numberBetween(10,80),
            "fecha_inicio"=>$fechaInicio,
            "fecha_fin"=>$fechaFin,
        ];
    }
}
