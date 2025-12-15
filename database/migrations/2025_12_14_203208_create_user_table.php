<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {

            // ID único del usuario
            $table->id();

            // Nombre del usuario
            $table->string('nombre');

            // Email único para login
            $table->string('email')->unique();

            // Contraseña encriptada
            $table->string('password');

            // Teléfono opcional
            $table->string('telefono')->nullable();

            // Token de sesión (Laravel Auth)
            $table->rememberToken();

            // Fechas de creación y actualización
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};