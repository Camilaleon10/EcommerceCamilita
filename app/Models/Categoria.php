<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Una categoría tiene muchos productos
    public function products()
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }
}