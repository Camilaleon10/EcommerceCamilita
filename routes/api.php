<?php

use Illuminate\Support\Facades\Route;
#importaciones necesarias para un request en postaman 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\InventoryController;

// Test
Route::get('/ping', fn () => response()->json(['ok' => true]));

// CRUD Categorías
Route::apiResource('categorias', CategoriaController::class);

// CRUD Productos
// Solo lectura para productos, el resto es para admin
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
// Carrito (rutas típicas)
Route::get('cart', [CartController::class, 'show']);
Route::post('cart/add', [CartController::class, 'add']);
Route::put('cart/update', [CartController::class, 'updateItem']);
Route::delete('cart/remove/{productId}', [CartController::class, 'remove']);
Route::delete('cart/clear', [CartController::class, 'clear']);

// Pedidos
Route::apiResource('orders', OrderController::class);

// Items del pedido
Route::get('orders/{orderId}/items', [OrderItemController::class, 'index']);
Route::post('orders/{orderId}/items', [OrderItemController::class, 'store']);
Route::get('order-items/{id}', [OrderItemController::class, 'show']);
Route::put('order-items/{id}', [OrderItemController::class, 'update']);
Route::delete('order-items/{id}', [OrderItemController::class, 'destroy']);
// Pagos
Route::post('payments', [PaymentController::class, 'store']);
Route::get('payments/{orderId}', [PaymentController::class, 'show']);

// Inventario
Route::get('inventory/{productId}', [InventoryController::class, 'show']);
Route::put('inventory/{productId}', [InventoryController::class, 'update']);


// Registro de usuarios sirve para crear usuarios desde Postman
Route::post('/users', function (Request $request) {
// Validar los datos recibidos para crear un usuario
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'telefono' => 'nullable|string|max:50',
        'role' => 'nullable|in:admin,cliente',
    ]);
// Crear el usuario en la base de datos
    $user = User::create([
        'nombre' => $data['nombre'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'telefono' => $data['telefono'] ?? null,
        'role' => $data['role'] ?? 'cliente', // si no mandas role, queda cliente
    ]);

    return response()->json($user, 201);
});