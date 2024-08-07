<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resena>
 */
class ResenaFactory extends Factory
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
        

        return [
            "id_usuario"=>$usuarioExistente,
            "puntuacion"=>$this->faker->numberBetween(1,5),
            "comentario"=>$this->faker->sentence(),
        ];
    }
}
