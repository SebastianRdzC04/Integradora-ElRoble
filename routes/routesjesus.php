<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterPersonController;
use App\Http\Controllers\RegisterPersonAdminController;
use App\Http\Controllers\RegisterUserController;

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'verifyemail'])->name('login');
    Route::get('/login/{phoneoremail?}', [LoginController::class, 'verifypassword'])->middleware('checkemailorphoneregistered')->name('login.password');
    Route::post('/login', [LoginController::class, 'store']);
    
    Route::get('/registeruser/{phoneoremail}', [RegisterUserController::class, 'create'])->name('registeruser.create');
    Route::post('/registeruser', [RegisterUserController::class, 'store'])->name('registeruser.store');

    Route::get('/personregister', [RegisterPersonController::class, 'create'])->name('registerperson.create');
    Route::post('/personregister', [RegisterPersonController::class, 'store'])->name('registerperson.store');
});

Route::get('lista',[RegisterPersonController::class, 'index'])->name('tablepeople');
Route::middleware('auth')->group(function(){
    
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::get('/prueba', function () {
    return view('welcome');
})->middleware('auth','verified');


