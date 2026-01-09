<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/solicitud', [SolicitudController::class, 'create'])->name('solicitud.create');

Route::post('/solicitud', [SolicitudController::class, 'store'])->name('solicitud.store');

// Lista de solicitudes para clientes
Route::get('/solicitudes_clientes', [SolicitudController::class, 'indexClientes'])
    ->name('solicitudes_clientes');

// Update de solicitudes
Route::put('/solicitudes/{id}', [SolicitudController::class, 'update'])
    ->name('solicitudes.update');

Route::resource('solicitudes', SolicitudController::class);

Route::post('/solicitudes', [SolicitudController::class, 'store'])
->name('solicitudes.store');

Route::put('/solicitudes/{solicitud}', [SolicitudController::class, 'update'])
->name('solicitudes.update');

Route::delete('/solicitudes/{solicitud}', [SolicitudController::class, 'destroy'])
->name('solicitudes.destroy');

Route::get('/subcategorias/{categoria_id}', function ($categoria_id) {
    return \App\Models\Subcategoria::where('categoria_id', $categoria_id)->get();
});

Route::get('/subcategorias/{categoria_id}', [SolicitudController::class, 'getSubcategorias']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/categorias', function() {
    $categorias = \App\Models\Categoria::with('subcategorias')->get();
    return view('categorias', compact('categorias'));
})->name('categorias.index');

// Ruta para traer subcategorías por AJAX
Route::get('/categorias/{id}/subcategorias', [SolicitudController::class, 'getSubcategorias']);

Route::post('/categorias/crear', [CategoriaController::class, 'store'])->name('categorias.store');
Route::get('/categorias/{id}/subcategorias', [CategoriaController::class, 'getSubcategorias']); // Para cargar dinámicamente

// Endpoints para edición desde la interfaz (detalles, actualizar, eliminar)
Route::get('/categorias/{id}/detalles', [CategoriaController::class, 'edit']);
Route::put('/categorias/{id}/editar', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}/eliminar', [CategoriaController::class, 'destroy']);