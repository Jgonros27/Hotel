<?php

namespace Database\Factories;

use App\Models\TipoCabana;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabana>
 */
class CabanaFactory extends Factory
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
            "id_tipo_cabana"=>$tipoCabanaExistente
        ];
    }
}
