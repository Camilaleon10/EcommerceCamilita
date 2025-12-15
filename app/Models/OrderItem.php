<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'cantidad',
        'precio',
    ];

    // Item pertenece a un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}