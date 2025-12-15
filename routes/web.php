<?php

use Illuminate\Support\Facades\Route;
# enrutacion para abrir laravel en el navegador, para verificar se puede escribir directamente 
#http://127.0.0.1:8000/api/ping  si sale {"ok":true}  todo esta bien
Route::get('/', function () {
    return "Servidor OK. Uda /api/ping, /api/categories, /api/products, etc.";
});
