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
        Schema::create('reserva_salons', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId('id_usuario')->constrained("users")->cascadeOnDelete(); // Clave foránea que referencia al ID del usuario que realiza la reserva
            $table->foreignId('id_salon')->constrained("salons")->cascadeOnDelete(); // Clave foránea que referencia al ID del salón reservado
            $table->date("fecha_evento"); // Columna para almacenar la fecha del evento reservado
            $table->time("hora_inicio"); // Columna para almacenar la hora de inicio del evento
            $table->time("hora_fin"); // Columna para almacenar la hora de finalización del evento
            $table->enum('tipo_evento',['cumpleaños','boda',"bautizo","comunion","evento_empresarial","otros"]); // Columna para almacenar el tipo de evento reservado
            $table->text("mensaje"); // Columna para almacenar un mensaje adicional asociado a la reserva
            $table->double('precio_final'); // Columna para almacenar el precio final de la reserva
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_salons');
    }
};
