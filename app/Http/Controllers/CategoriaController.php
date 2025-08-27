<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    // Guardar nueva categoría y sus subcategorías
    public function store(Request $request)
    {
        $request->validate([
            'categoria' => 'required|string|max:255',
            'subcategorias' => 'nullable|array', // Solo una regla para arrays
            'subcategorias.*' => 'nullable|string|max:255', // Valida cada subcategoría dentro del array
        ]);

        try {
            DB::beginTransaction();

            // Crear la categoría
            $categoria = Categoria::create([
                'nombre' => $request->categoria,
            ]);

            // Crear subcategorías asociadas
            if ($request->has('subcategorias') && is_array($request->subcategorias)) {
                foreach ($request->subcategorias as $sub) {
                    if (!empty($sub)) {
                        Subcategoria::create([
                            'nombre' => $sub,
                            'categoria_id' => $categoria->id, // Se asigna el ID autoincremental de la categoría
                        ]);
                    }
                }
            }

            DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Categoría y subcategorías creadas correctamente',
                        'categoria' => $categoria->nombre
                    ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar',
                'error' => $e->getMessage() // 👈 te muestra el error real
            ], 500);
        }
    }

    // Retornar subcategorías dinámicamente según la categoría seleccionada
    public function getSubcategorias($id)
    {
        $subcategorias = Subcategoria::where('categoria_id', $id)->get();
        return response()->json($subcategorias);
    }

    // Obtener categoría con sus subcategorías
public function edit($id)
{
    $categoria = Categoria::with('subcategorias')->findOrFail($id);

    return response()->json($categoria);
}
}