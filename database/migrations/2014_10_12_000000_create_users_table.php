<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Definición de la migración
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear la tabla 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna de tipo ID autoincremental
            $table->string('name'); // Columna para el nombre del usuario
            $table->string('email')->unique(); // Columna para el correo electrónico único
            $table->timestamp('email_verified_at')->nullable(); // Columna para la marca de tiempo de verificación del correo electrónico (puede ser nula)
            $table->string('password'); // Columna para la contraseña del usuario
            $table->boolean('admin')->default(false); // Columna para el rol de administrador (por defecto, no es administrador)
            $table->rememberToken(); // Columna para el token de recuerdo (para "recuerdame" en la autenticación)
            $table->timestamps(); // Columnas de marcas de tiempo para 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla 'users' si existe
        Schema::dropIfExists('users');
    }
};
