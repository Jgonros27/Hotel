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
        Schema::create('imagen_salons', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId("id_salon")->constrained("salons")->cascadeOnDelete(); // Clave foránea que referencia al ID del salón
            $table->text("url"); // Columna para almacenar la URL de la imagen del salón
            $table->text("nombre_imagen"); // Columna para almacenar el nombre de la imagen del salón
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagen_salons');
    }
};
