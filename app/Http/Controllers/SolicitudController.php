<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Solicitud;
use App\Models\Categoria;
use App\Models\Subcategoria;
use Carbon\Carbon;

class SolicitudController extends Controller
{
    /**
     * Muestra el formulario para crear solicitud
     */
    public function create()
    {
        // Traemos las categorías con sus subcategorías relacionadas
        $categorias = Categoria::with('subcategorias')->get();

        return view('solicitud.create', compact('categorias'));
    }

    /**
     * Guarda una nueva solicitud en la base de datos
     */
    public function store(Request $request)
    {
        // Validación de campos
        $request->validate([
            'nombre'          => 'required|string|max:100',
            'email'           => 'required|email|max:150',
            'asunto'          => 'required|string|max:150',
            'descripcion'     => 'required|string|max:500',
            'categoria_id'    => 'nullable|exists:categorias,id',
            'subcategoria_id' => 'nullable|exists:subcategorias,id',
        ]);

        // Limitar máximo 3 solicitudes al día por correo
        $solicitudesHoy = Solicitud::where('email', $request->email)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($solicitudesHoy >= 3) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Este correo ya ha enviado el máximo de 3 solicitudes hoy.']);
        }

        // 🔹 Buscar el nombre de la categoría y subcategoría según el id recibido
        $categoria = Categoria::find($request->categoria_id);
        $subcategoria = Subcategoria::find($request->subcategoria_id);

        // Guardamos la solicitud en la BD
        Solicitud::create([
            'nombre'       => $request->nombre,
            'email'        => $request->email,
            'asunto'       => $request->asunto,
            'descripcion'  => $request->descripcion,
            'categoria'    => $categoria ? $categoria->nombre : null,
            'subcategoria' => $subcategoria ? $subcategoria->nombre : null,
        ]);

        return redirect()->back()->with('success', 'Solicitud enviada exitosamente.');
    }

    /**
     * Muestra todas las solicitudes en el front (URL: /solicitudes_clientes)
     */
    public function indexClientes()
    {
        // Traer todas las solicitudes
        $solicitudes = Solicitud::orderBy('created_at', 'desc')->get();

        // Traer categorías con subcategorías
        $categorias = Categoria::with('subcategorias')->get();

        // Retornar a la vista
        return view('solicitudes.clientes', compact('solicitudes', 'categorias'));
    }

    /**
     * Actualiza una solicitud (usado en el modal de editar)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'email'        => 'required|email|max:150',
            'asunto'       => 'required|string|max:150',
            'descripcion'  => 'required|string|max:500',
            'categoria'    => 'nullable|string|max:150',
            'subcategoria' => 'nullable|string|max:150',
        ]);

        $solicitud = Solicitud::findOrFail($id);
        $solicitud->update($request->all());

        // Mensaje flash + redirección a la vista clientes
        return redirect()->route('solicitudes_clientes')
                         ->with('success', 'Cambios realizados correctamente');
    }

    /**
     * Elimina una solicitud
     */
    public function destroy($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->delete();

        return redirect()->route('solicitudes_clientes')
                     ->with('deleted', 'Solicitud eliminada correctamente');
    }

    /**
     * Retorna subcategorías de una categoría (AJAX)
     */
    public function getSubcategorias($categoria_id)
    {
        $subcategorias = Subcategoria::where('categoria_id', $categoria_id)->get();
        return response()->json($subcategorias);
    }
}