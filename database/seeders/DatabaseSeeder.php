<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Cabana;
use App\Models\ImagenCabana;
use App\Models\ImagenSalon;
use App\Models\Oferta;
use App\Models\Resena;
use App\Models\ReservaCabana;
use App\Models\ReservaSalon;
use App\Models\Salon;
use App\Models\TipoCabana;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            "password"=>"123456",
            "admin"=>1
        ]);

        User::factory()->create([
            'name' => 'juan',
            'email' => 'juangonzalez@email.com',
            "password"=>"123456",
        ]);

        // User::factory(20)->create();

        // Resena::Factory(40)->create();
        
        // TipoCabana::factory(3)->create();

        // Cabana::factory(30)->create();

        // Oferta::factory(10)->create();

        // Salon::factory(5)->create();
        

    }
}
