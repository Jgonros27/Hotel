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
        Schema::create('cabanas', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId("id_tipo_cabana") // Columna de clave foránea
                ->constrained("tipo_cabanas") // Establecer la restricción de clave foránea hacia la tabla 'tipo_cabanas'
                ->cascadeOnDelete(); // Si se elimina un registro en 'tipo_cabanas', se eliminarán automáticamente todos los registros relacionados en 'cabanas'
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabanas');
    }
};
