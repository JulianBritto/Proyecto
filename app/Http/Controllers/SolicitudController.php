<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'categoria'       => 'nullable|string|max:150',
            'subcategoria'    => 'nullable|string|max:150',
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

        // Guardamos la solicitud en la BD
        Solicitud::create([
            'nombre'          => $request->nombre,
            'email'           => $request->email,
            'asunto'          => $request->asunto,
            'descripcion'     => $request->descripcion,
            'categoria'    => $request->categoria,
            'subcategoria' => $request->subcategoria,
        ]);

        return redirect()->back()->with('success', 'Solicitud enviada exitosamente.');
    }
}