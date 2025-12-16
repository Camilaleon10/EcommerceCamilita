<?php

namespace App\Http\Controllers\Api;// Controlador para gestionar servicios

use App\Http\Controllers\Controller;// Controlador base
use App\Models\Product; // Usamos el modelo Product para servicios
use Illuminate\Http\Request;// Para manejar solicitudes HTTP

class ServiceController extends Controller
{
    public function index()
    {
        // Listamos todos los servicios
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Crear servicio
        $service = Product::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
        ]);

        return response()->json($service, 201);
    }

    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $service = Product::findOrFail($id);
        $service->update($request->all());

        return response()->json($service, 200);
    }

    public function destroy($id)
    {
        $service = Product::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Servicio eliminado'], 200);
    }

    public function show($id)
    {
        $service = Product::findOrFail($id);
        return response()->json($service, 200);
    }
}