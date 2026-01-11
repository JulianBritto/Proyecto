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

// Auth routes (no requieren autenticación)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {

    // Solicitudes - accesible para rol 2
    Route::middleware(['role:2'])->group(function () {
        Route::get('/solicitud', [SolicitudController::class, 'create'])->name('solicitud.create');
        Route::post('/solicitud', [SolicitudController::class, 'store'])->name('solicitud.store');
    });

    // Admin dashboard - solo rol 1
    Route::middleware(['role:1'])->group(function () {
        Route::get('/admin', function () {
            return view('admin');
        })->name('admin.index');
    });

    // Lista de solicitudes para clientes - rol 1
    Route::middleware(['role:1'])->group(function () {
        Route::get('/solicitudes_clientes', [SolicitudController::class, 'indexClientes'])
            ->name('solicitudes_clientes');
    });

    // Gestión de solicitudes - rol 1
    Route::middleware(['role:1'])->group(function () {
        Route::resource('solicitudes', SolicitudController::class);
        Route::put('/solicitudes/{solicitud}', [SolicitudController::class, 'update'])
            ->name('solicitudes.update');
        Route::delete('/solicitudes/{solicitud}', [SolicitudController::class, 'destroy'])
            ->name('solicitudes.destroy');
    });

    // Categorías - rol 1
    Route::middleware(['role:1'])->group(function () {
        Route::get('/categorias', function() {
            $categorias = \App\Models\Categoria::with('subcategorias')->get();
            return view('categorias', compact('categorias'));
        })->name('categorias.index');

        Route::get('/categoriasysubcategorias', [\App\Http\Controllers\CategoriaController::class, 'indexWithSubcategorias'])
            ->name('categoriasysubcategorias.index');

        Route::post('/categorias/crear', [CategoriaController::class, 'store'])->name('categorias.store');
    });

    // AJAX routes - rol 1
    Route::middleware(['role:1'])->group(function () {
        Route::get('/subcategorias/{categoria_id}', [SolicitudController::class, 'getSubcategorias']);
        Route::get('/categorias/{id}/subcategorias', [SolicitudController::class, 'getSubcategorias']);
        Route::get('/categorias/{id}/subcategorias', [CategoriaController::class, 'getSubcategorias']);
    });

});
