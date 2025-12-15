<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
    ];

    // Producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Producto aparece en muchos items de pedido
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // Producto tiene un inventario
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }
}