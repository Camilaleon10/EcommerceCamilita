<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Crear un pedido desde el carrito
    public function store()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'active')
                    ->firstOrFail();

        $order = Order::create([
            'user_id' => Auth::id(),
            'estado' => 'pendiente',
        ]);

        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'cantidad' => $item->cantidad,
                'precio' => $item->precio,
            ]);
        }

        // Actualizamos el estado del carrito
        $cart->update(['status' => 'converted']);

        return response()->json($order, 201);
    }

    // Ver pedidos del usuario
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return response()->json($orders, 200);
    }

    // Ver detalles de un pedido
    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->with('orderItems.product')->firstOrFail();
        return response()->json($order, 200);
    }
}