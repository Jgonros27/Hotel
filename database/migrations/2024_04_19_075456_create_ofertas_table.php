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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId("id_tipo_cabana")->constrained("tipo_cabanas")->cascadeOnDelete(); // Clave foránea que referencia al ID del tipo de cabaña al que se aplica la oferta
            $table->integer("descuento")->unsigned(); // Columna para almacenar el descuento ofrecido
            $table->date("fecha_inicio"); // Columna para almacenar la fecha de inicio de la oferta
            $table->date("fecha_fin"); // Columna para almacenar la fecha de finalización de la oferta
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
