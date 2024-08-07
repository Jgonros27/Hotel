<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoCabana>
 */
class TipoCabanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre"=>$this->faker->word(),
            "precio"=>$this->faker->randomFloat(2, 50, 500),
            "capacidad"=>$this->faker->numberBetween(1,7),
            "servicios"=>$this->faker->text(),
            "precio_media_pension"=>$this->faker->randomFloat(2, 50, 100),
            "dias_cancelacion"=>$this->faker->numberBetween(5,30),
            "especificaciones"=>$this->faker->text(),
        ];
    }
}
