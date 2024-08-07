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
        Schema::create('resenas', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId('id_usuario')->constrained("users")->cascadeOnDelete(); // Clave foránea que referencia al ID del usuario que escribió la reseña
            $table->string("comentario"); // Columna para almacenar el comentario o reseña
            $table->integer("puntuacion")->unsigned(); // Columna para almacenar la puntuación de la reseña
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
