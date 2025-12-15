<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Realizar un pago
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metodo' => 'required|string',
            'monto' => 'required|numeric',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Registrar el pago
        $payment = Payment::create([
            'order_id' => $order->id,
            'metodo' => $request->metodo,
            'monto' => $request->monto,
        ]);

        return response()->json($payment, 201);
    }

    // Ver el pago de un pedido
    public function show($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->first();
        return response()->json($payment, 200);
    }
}