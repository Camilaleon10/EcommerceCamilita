<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    //permite la autenticacion via token
    use  HasApiTokens, Notifiable;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        // se agrega el role para diferenciar admin y cliente
        'role',
    ];
     protected $hidden = [
       'password',
        'remember_token',
    ];


    protected $casts = [
        'password' => 'hashed',
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