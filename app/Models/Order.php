<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'estado',
    ];

    // Pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pedido tiene muchos items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Pedido tiene un pago
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}