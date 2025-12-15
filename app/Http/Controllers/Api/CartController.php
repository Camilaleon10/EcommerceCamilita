<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Ver carrito de compras del usuario
    public function show()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'active')
                    ->with('cartItems.product')
                    ->first();

        return response()->json($cart, 200);
    }

    // Agregar un producto al carrito
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id(), 'status' => 'active']);

        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id],
            ['cantidad' => $request->cantidad, 'precio' => $product->precio]
        );

        return response()->json($cartItem, 200);
    }

    // Eliminar producto del carrito
    public function removeItem($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $item->delete();
        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }

    // Vaciar el carrito
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->first();
        $cart->cartItems()->delete();
        return response()->json(['message' => 'Carrito vacío'], 200);
    }
}