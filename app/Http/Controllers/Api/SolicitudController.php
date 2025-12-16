<?php

namespace App\Http\Controllers\Api;  // Controlador para gestionar solicitudes

use App\Http\Controllers\Controller; // Controlador base
use App\Models\Order; // Usamos el modelo Order para solicitudes
use Illuminate\Http\Request; // Para manejar solicitudes HTTP

class SolicitudController extends Controller
{
    public function index()
    {
        // Listamos todas las solicitudes
        return response()->json(Order::all());
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'producto_id' => 'required|exists:products,id',
            'cantidad' => 'required|integer',
            'estado' => 'required|string|in:pendiente,aceptada,cancelada',
        ]);

        // Crear solicitud
        $solicitud = Order::create([
            'user_id' => $request->user_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'estado' => $request->estado,
        ]);

        return response()->json($solicitud, 201);
    }

    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'estado' => 'required|string|in:pendiente,aceptada,cancelada',
        ]);

        $solicitud = Order::findOrFail($id);
        $solicitud->update(['estado' => $request->estado]);

        return response()->json($solicitud, 200);
    }
    // Obtener una solicitud específica
    public function show($id)
    {
        $solicitud = Order::findOrFail($id);
        return response()->json($solicitud, 200);
    }
}