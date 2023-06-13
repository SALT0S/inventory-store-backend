<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $category_id = $request->input('category_id');

        $products = Product::with('category')->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->get();

        return response()->json($products);
    }

    public function show($id): JsonResponse
    {
        // Obtener un producto por su ID con la relación de categoría
        $product = Product::with('category')->where('id', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request): JsonResponse
    {
        // Validar los datos de entrada
        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string|unique:products,name',
            'brand' => 'required',
            'weight' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:6048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->weight = $request->weight;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->image = $imageName;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => [
                'product' => $product,
                'image_url' => asset('images/' . $imageName),
            ]
        ], 201);
    }


    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string|unique:products,name,'.$id,
            'brand' => 'required',
            'weight' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:6048',
        ]);

        // Obtener el producto por su ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $imageName = $product->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);

            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = public_path('images/' . $product->image);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->weight = $request->weight;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->image = $imageName;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => [
                'product' => $product,
                'image_url' => asset('images/' . $imageName),
            ]
        ], 200);
    }


    public function destroy($id): JsonResponse
    {
        $product = Product::find($id);

        if ($product->image) {
            $imagePath = public_path('images/' . $product->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
