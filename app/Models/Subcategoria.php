<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos (opcional si sigue convención)
    protected $table = 'subcategorias';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'nombre',
        'categoria_id'
    ];

    /**
     * Relación: Una subcategoría pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}