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

    // Actualizar categoría y sus subcategorías (crear/editar/eliminar según payload)
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'subcategorias' => 'nullable|array',
            'subcategorias.*.id' => 'nullable|integer|exists:subcategorias,id',
            'subcategorias.*.nombre' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $categoria = Categoria::with('subcategorias')->findOrFail($id);
            $categoria->nombre = $data['nombre'];
            $categoria->save();

            $existingIds = $categoria->subcategorias->pluck('id')->toArray();
            $sentIds = [];

            if (!empty($data['subcategorias'])) {
                foreach ($data['subcategorias'] as $sub) {
                    $subNombre = isset($sub['nombre']) ? trim($sub['nombre']) : null;
                    if (!empty($sub['id'])) {
                        // actualizar o eliminar si nombre vacío
                        $s = Subcategoria::find($sub['id']);
                        if ($s) {
                            if (empty($subNombre)) {
                                $s->delete();
                            } else {
                                $s->nombre = $subNombre;
                                $s->save();
                                $sentIds[] = $s->id;
                            }
                        }
                    } else {
                        // crear nueva subcategoría si tiene nombre
                        if (!empty($subNombre)) {
                            $new = Subcategoria::create([
                                'nombre' => $subNombre,
                                'categoria_id' => $categoria->id,
                            ]);
                            $sentIds[] = $new->id;
                        }
                    }
                }
            }

            // eliminar subcategorías que no fueron enviadas
            $toDelete = array_diff($existingIds, $sentIds);
            if (!empty($toDelete)) {
                Subcategoria::whereIn('id', $toDelete)->delete();
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al actualizar', 'error' => $e->getMessage()], 500);
        }
    }

    // Eliminar categoría (y subcategorías por cascade)
    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            return response()->json(['success' => true, 'message' => 'Categoría eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar', 'error' => $e->getMessage()], 500);
        }
    }
}