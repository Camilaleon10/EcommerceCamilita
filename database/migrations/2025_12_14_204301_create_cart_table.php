<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {

            // ID del carrito
            $table->id();

            // Usuario dueño del carrito
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('user')
                  ->cascadeOnDelete();

            // Estado del carrito
            $table->enum('status', ['active', 'converted', 'abandoned'])
                  ->default('active');

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};