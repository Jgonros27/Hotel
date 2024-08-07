<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salons', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->string("nombre"); // Columna para el nombre del salón
            $table->text("descripcion"); // Columna para describir el salón
            $table->double("precio_hora")->unsigned(); // Columna para el precio por hora del salón
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salons');
    }
};
