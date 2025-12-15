<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Ver inventario de producto
    public function show($productId)
    {
        $inventory = Inventory::where('product_id', $productId)->firstOrFail();
        return response()->json($inventory, 200);
    }

    // Actualizar inventario
    public function update(Request $request, $productId)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:0',
        ]);

        $inventory = Inventory::where('product_id', $productId)->firstOrFail();
        $inventory->update(['cantidad' => $request->cantidad]);

        return response()->json($inventory, 200);
    }
}