<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'solicitudes';

    // Campos que se pueden llenar
protected $fillable = [
    'nombre',
    'email',
    'asunto',
    'descripcion',
    'categoria',
    'subcategoria',
];
}