<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'product_id',
        'cantidad',
    ];

    // Inventario pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}