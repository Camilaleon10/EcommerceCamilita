<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'metodo',
        'monto',
    ];

    // Pago pertenece a un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}