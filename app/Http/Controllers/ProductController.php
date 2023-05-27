<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->input('category_id');

        // Obtener todos los productos con la relación de categoría filtrados por category_id si se proporciona
        $products = Product::with('category')->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->get();

        return response()->json($products);
    }

    public function show($id)
    {
        // Obtener un producto por su ID con la relación de categoría
        $product = Product::with('category')->where('id', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'weight' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Crear un nuevo producto
        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        // Obtener el producto por su ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Validar los datos de entrada
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'weight' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Actualizar el producto
        $product->update($request->all());

        return response()->json($product);
    }

    public function destroy($id)
    {
        // Obtener el producto por su ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        // Eliminar el producto
        $product->delete();

        return response()->json(['message' => 'Producto eliminado']);
    }
}
