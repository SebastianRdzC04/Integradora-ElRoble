<?php

use App\Http\Controllers\CotizacionesClientesController;
use App\Http\Controllers\PaquetesAdminController;
use App\Http\Controllers\ServiciosAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.inicio');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cotizaciones', [CotizacionesClientesController::class, 'create'])->name('cotizaciones');
Route::get('/crearpaquetes', [PaquetesAdminController::class, 'create'])->name('crearpaquetes');
Route::get('/crearservicios', [ServiciosAdminController::class, 'create'])->name('crearservicios');
require __DIR__.'/auth.php';
