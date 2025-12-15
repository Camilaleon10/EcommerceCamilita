<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Un usuario tiene un carrito
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // Un usuario tiene muchos pedidos
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}