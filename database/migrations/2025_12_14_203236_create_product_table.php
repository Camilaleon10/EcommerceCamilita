<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {

            // ID del producto
            $table->id();

            // Nombre del producto
            $table->string('nombre');

            // Descripción opcional
            $table->text('descripcion')->nullable();

            // Precio
            $table->decimal('precio', 10, 2);

            // Stock básico
            $table->integer('stock')->default(0);

            // Relación con categorias
            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categoria')
                  ->nullOnDelete();

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};