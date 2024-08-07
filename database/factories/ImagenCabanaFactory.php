<?php

namespace Database\Factories;

use App\Models\TipoCabana;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImagenCabana>
 */
class ImagenCabanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipoCabanaExistente = TipoCabana::inRandomOrder()->first();

        return [
            "url"=>$this->faker->imageUrl(),
            "id_tipo_cabana"=>$tipoCabanaExistente
        ];
    }
}
