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
        Schema::create('reserva_cabanas', function (Blueprint $table) {
            $table->id(); // Columna de clave primaria autoincremental
            $table->foreignId('id_usuario') // Columna de clave foránea hacia la tabla 'users'
                ->constrained("users") // Establecer la restricción de clave foránea hacia la tabla 'users'
                ->cascadeOnDelete(); // Si se elimina un registro en 'users', se eliminarán automáticamente todos los registros relacionados en 'reserva_cabanas'
            $table->foreignId('id_cabana') // Columna de clave foránea hacia la tabla 'cabanas'
                ->constrained("cabanas") // Establecer la restricción de clave foránea hacia la tabla 'cabanas'
                ->cascadeOnDelete(); // Si se elimina un registro en 'cabanas', se eliminarán automáticamente todos los registros relacionados en 'reserva_cabanas'
            $table->date("fecha_entrada"); // Columna para la fecha de entrada
            $table->date("fecha_salida"); // Columna para la fecha de salida
            $table->integer("n_huespedes")->default(1)->unsigned(); // Columna para el número de huéspedes, valor predeterminado de 1
            $table->double('precio_habitacion'); // Columna para el precio de la habitación
            $table->double('precio_total'); // Columna para el precio total sin descuento
            $table->double('descuento'); // Columna para el descuento
            $table->double("media_pension"); // Columna para el costo de la media pensión
            $table->double('precio_final'); // Columna para el precio final de la reserva
            $table->string('id_pago'); // Columna para el id del pago
            $table->timestamps(); // Columnas para marcas de tiempo de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_cabanas');
    }
};
