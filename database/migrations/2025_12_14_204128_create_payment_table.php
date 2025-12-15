<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {

            // ID del pago
            $table->id();

            // Pedido pagado
            $table->foreignId('order_id')
                  ->constrained('order')
                  ->cascadeOnDelete();

            // Método de pago
            $table->string('metodo');

            // Monto total
            $table->decimal('monto', 10, 2);

            // Un pago por pedido
            $table->unique('order_id');

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};