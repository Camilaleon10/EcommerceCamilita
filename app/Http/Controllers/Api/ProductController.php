<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Mostrar todos los productos
    public function index()
    {
        $products = Product::with('categoria')->get();
        return response()->json($products, 200);
    }

    // Mostrar un producto específico
    public function show($id)
    {
        $product = Product::with('categoria')->findOrFail($id);
        return response()->json($product, 200);
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // Actualizar un producto
    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'sometimes|required|string|max:255',
        'precio' => 'sometimes|required|numeric',
        'stock' => 'sometimes|required|integer',
        'categoria_id' => 'sometimes|required|exists:categorias,id',
    ]);

    $product = Product::findOrFail($id);
    $product->update($request->all());
    return response()->json($product, 200);
}

    // Eliminar un producto
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}