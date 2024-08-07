<?php

namespace Database\Factories;

use App\Models\Salon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImagenSalon>
 */
class ImagenSalonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salonExistente = Salon::inRandomOrder()->first();

        return [
            "url"=>$this->faker->imageUrl(),
            "id_salon"=>$salonExistente
        ];
    }
}
