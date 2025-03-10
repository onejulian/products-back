<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Obtener todos los productos con paginación.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $products = Product::paginate(10);
        return response()->json($products, 200);
    }

    /**
     * Crear un nuevo producto.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Obtener un producto por ID.
     */
    public function show($id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0'
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        if ($request->has('name')) {
            $product->name = $request->input('name');
        }
        if ($request->has('price')) {
            $product->price = $request->input('price');
        }

        $product->save();

        return response()->json($product, 200);
    }

    /**
     * Eliminar un producto.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}
