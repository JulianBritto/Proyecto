<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'categorias';

    // Campos que se pueden asignar de manera masiva (mass assignment)
    protected $fillable = ['nombre'];

    /**
     * Relación: Una categoría tiene muchas subcategorías
     */
    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class, 'categoria_id');
    }
}