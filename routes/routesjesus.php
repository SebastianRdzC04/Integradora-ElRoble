<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterPersonController;
use App\Http\Controllers\RegisterPersonAdminController;
use App\Http\Controllers\RegisterUserController;

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    
    Route::get('/registeruser', [RegisterUserController::class, 'create'])->name('registeruser.create');
    Route::post('/registeruser', [RegisterUserController::class, 'store'])->name('registeruser.store');

    Route::get('/personregister', [RegisterPersonController::class, 'create'])->name('registerperson.create');
    Route::post('/personregister', [RegisterPersonController::class, 'store'])->name('registerperson.store');
});

Route::middleware('auth')->group(function(){
    Route::get('/personregisteradmi', [RegisterPersonAdminController::class, 'create'])->name('registerpersonadmin.create');
    Route::post('/personregisteradmin', [RegisterPersonAdminController::class, 'store'])->name('registerpersonadmin.store');
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::get('/prueba', function () {
    return view('welcome');
})->middleware('auth','verified');


