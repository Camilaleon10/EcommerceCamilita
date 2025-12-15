<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {

            // ID del pedido
            $table->id();

            // Usuario que hizo el pedido
            $table->foreignId('user_id')
                  ->constrained('user')
                  ->cascadeOnDelete();

            // Estado del pedido
            $table->enum('estado', ['pendiente', 'pagado', 'enviado'])
                  ->default('pendiente');

            // Fechas (created_at = fecha del pedido)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};