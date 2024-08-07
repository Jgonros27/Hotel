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
        // Crear la tabla 'tipo_cabanas'
        Schema::create('tipo_cabanas', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->string("nombre"); // Nombre del tipo de cabaña
            $table->double("precio")->unsigned(); // Precio del tipo de cabaña (número positivo)
            $table->integer("capacidad")->unsigned(); // Capacidad del tipo de cabaña (número positivo)
            $table->text("servicios"); // Descripción de los servicios ofrecidos
            $table->double("precio_media_pension")->unsigned(); // Precio de la media pensión (número positivo)
            $table->integer("dias_cancelacion")->default(14); // Número de días de cancelación (por defecto: 14 días)
            $table->text("especificaciones"); // Otras especificaciones del tipo de cabaña
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_cabanas');
    }
};
