<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        // Obtener todas las categorías
        $categories = Category::all();

        return response()->json($categories);
    }

    public function show($id): JsonResponse
    {
        // Obtener una categoría por su ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:6048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);

        $category = new Category();
        $category->name = $request->name;
        $category->image = $imageName;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => [
                'category' => $category,
                'image_url' => asset('images/' . $imageName),
            ]
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,'.$id,
            'image' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:6048',
        ]);

        $category = Category::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);

            if ($category->image) {
                $oldImagePath = public_path('images/' . $category->image);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $category->image = $imageName;
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => [
                'category' => $category,
                'image_url' => $category->image ? asset('images/' . $category->image) : null,
            ]
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            $imagePath = public_path('images/' . $category->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
