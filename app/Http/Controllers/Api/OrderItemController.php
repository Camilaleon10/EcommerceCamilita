<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Listar items de un pedido
     * GET /api/orders/{orderId}/items
     */
    public function index($orderId)
    {
        // Verificamos que el pedido exista
        $order = Order::findOrFail($orderId);

        // Traemos los items de ese pedido con su producto
        $items = OrderItem::where('order_id', $order->id)
            ->with('product')
            ->get();

        return response()->json($items, 200);
    }

    /**
     * Crear item en un pedido (opcional)
     * POST /api/orders/{orderId}/items
     * Nota: normalmente los items se crean al hacer checkout, no manualmente.
     */
    public function store(Request $request, $orderId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cantidad'   => 'required|integer|min:1',
            'precio'     => 'required|numeric|min:0',
        ]);

        // Aseguramos que el pedido exista
        $order = Order::findOrFail($orderId);

        // Creamos el item
        $item = OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $request->product_id,
            'cantidad'   => $request->cantidad,
            'precio'     => $request->precio,
        ]);

        return response()->json($item, 201);
    }

    /**
     * Ver un item específico
     * GET /api/order-items/{id}
     */
    public function show(string $id)
    {
        $item = OrderItem::with('product')->findOrFail($id);

        return response()->json($item, 200);
    }

    /**
     * Actualizar un item
     * PUT /api/order-items/{id}
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cantidad' => 'sometimes|required|integer|min:1',
            'precio'   => 'sometimes|required|numeric|min:0',
        ]);

        $item = OrderItem::findOrFail($id);

        // Actualizamos solo lo que llegue
        $item->update($request->only(['cantidad', 'precio']));

        return response()->json($item, 200);
    }

    /**
     * Eliminar un item
     * DELETE /api/order-items/{id}
     */
    public function destroy(string $id)
    {
        $item = OrderItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item eliminado'], 200);
    }
}