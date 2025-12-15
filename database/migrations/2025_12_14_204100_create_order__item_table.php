<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item', function (Blueprint $table) {

            // ID del detalle
            $table->id();

            // Pedido al que pertenece
            $table->foreignId('order_id')
                  ->constrained('order')
                  ->cascadeOnDelete();

            // Producto comprado
            $table->foreignId('product_id')
                  ->constrained('product')
                  ->cascadeOnDelete();

            // Cantidad comprada
            $table->integer('cantidad');

            // Precio al momento de la compra
            $table->decimal('precio', 10, 2);

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};