<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria', function (Blueprint $table) {

            // ID único de la categoría
            $table->id();

            // Nombre de la categoría (no repetido)
            $table->string('nombre')->unique();

            // Descripción opcional
            $table->text('descripcion')->nullable();

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria');
    }
};