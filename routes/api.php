<?php

use Illuminate\Support\Facades\Route;
#importaciones necesarias para un request en postaman 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\Api\CategoriaController; // CRUD Categorías
use App\Http\Controllers\Api\ProductController; // CRUD Productos
use App\Http\Controllers\Api\CartController; // Carrito de compras
use App\Http\Controllers\Api\OrderController; // CRUD Pedidos
use App\Http\Controllers\Api\OrderItemController; // Items del pedido
use App\Http\Controllers\Api\PaymentController;  // Pagos
use App\Http\Controllers\Api\InventoryController; // Inventario
use App\Http\Controllers\Api\AuthController; // Autenticación
use App\Http\Controllers\Api\ServiceController; // CRUD Servicios
use App\Http\Controllers\Api\SolicitudController; // CRUD Solicitudes


// Test
Route::get('/ping', fn () => response()->json(['ok' => true]));

// CRUD Categorías
Route::apiResource('categorias', CategoriaController::class);

// CRUD Productos
// Solo lectura para productos, el resto es para admin
Route::middleware('auth:sanctum', 'isAdmin')->post('products', [ProductController::class, 'store']);
// Ruta para actualizar producto (PUT)
Route::middleware('auth:sanctum', 'isAdmin')->put('products/{id}', [ProductController::class, 'update']);
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
Route::get('/products', [ProductController::class, 'index']); // Verifica que esté usando GET y el método index

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

// Rutas de autenticación
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('auth/logout', [AuthController::class, 'logout']);
// Obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('auth/me', function (Request $request) {
    return response()->json($request->user());
});

// Rutas protegidas para admin (servicios)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('servicios', ServiceController::class); // CRUD para servicios
});

// Rutas protegidas para solicitudes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('solicitudes', SolicitudController::class); // CRUD para solicitudes
});

// Actualizar estado de solicitud
Route::middleware('auth:sanctum')->patch('solicitudes/{id}/estado', 
 [SolicitudController::class, 'update']);