<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Obtener todas las categorías
        $categories = Category::all();

        return response()->json($categories);
    }

    public function show($id)
    {
        // Obtener una categoría por su ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required',
        ]);

        // Crear una nueva categoría
        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        // Obtener la categoría por su ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Validar los datos de entrada
        $request->validate([
            'name' => 'required',
        ]);

        // Actualizar la categoría
        $category->update($request->all());

        return response()->json($category);
    }

    public function destroy($id)
    {
        // Obtener la categoría por su ID
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Eliminar la categoría
        $category->delete();

        return response()->json(['message' => 'Categoría eliminada']);
    }
}
