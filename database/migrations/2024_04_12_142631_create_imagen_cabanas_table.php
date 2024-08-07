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
        Schema::create('imagen_cabanas', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId("id_tipo_cabana") // Columna de clave foránea hacia la tabla 'tipo_cabanas'
                ->constrained("tipo_cabanas") // Establecer la restricción de clave foránea hacia la tabla 'tipo_cabanas'
                ->cascadeOnDelete(); // Si se elimina un registro en 'tipo_cabanas', se eliminarán automáticamente todos los registros relacionados en 'imagen_cabanas'
            $table->text("url"); // Columna para la URL de la imagen
            $table->text("nombre_imagen"); // Columna para el nombre de la imagen
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen_cabanas');
    }
};
