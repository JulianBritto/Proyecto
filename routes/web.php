<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;

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

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin dashboard
Route::get('/admin', function () {
    return view('admin');
})->name('admin.index');

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

// Vista tabla categorías y subcategorías
Route::get('/categoriasysubcategorias', [\App\Http\Controllers\CategoriaController::class, 'indexWithSubcategorias'])
    ->name('categoriasysubcategorias.index');

// Ruta para traer subcategorías por AJAX
Route::get('/categorias/{id}/subcategorias', [SolicitudController::class, 'getSubcategorias']);

Route::post('/categorias/crear', [CategoriaController::class, 'store'])->name('categorias.store');
Route::get('/categorias/{id}/subcategorias', [CategoriaController::class, 'getSubcategorias']); // Para cargar dinámicamente