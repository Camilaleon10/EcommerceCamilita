<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {

            // ID del inventario
            $table->id();

            // Producto relacionado (1 a 1)
            $table->foreignId('product_id')
                  ->constrained('product')
                  ->cascadeOnDelete();

            // Un inventario por producto
            $table->unique('product_id');

            // Cantidad real en almacén
            $table->integer('cantidad')->default(0);

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};