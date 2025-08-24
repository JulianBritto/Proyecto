<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;

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

Route::get('/', function () {
    return view('welcome');
});
