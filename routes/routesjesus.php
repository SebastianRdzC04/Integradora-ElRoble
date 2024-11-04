<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterPersonController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'verifyemail'])->name('login');
    Route::get('/login/{phoneoremail?}', [LoginController::class, 'verifypassword'])->middleware('checkemailorphoneregistered')->name('login.password');
    Route::post('/login', [LoginController::class, 'store']);
    
    Route::get('/registeruser/{phoneoremail}', [RegisterUserController::class, 'create'])->name('registeruser.create');
    Route::post('/registeruser', [RegisterUserController::class, 'store'])->name('registeruser.store');


    //Route::get('/personregister', [RegisterPersonController::class, 'create'])->name('registerperson.create');
    //Route::post('/personregister', [RegisterPersonController::class, 'store'])->name('registerperson.store');
});

Route::group(['middleware' => 'guest'], function () {
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    Route::get('/reset-password/{token}', function ($token) {
        return view('pages.sesion.createnewpassword', ['token' => $token]);
    })->name('password.reset')->middleware('signed');    
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::get('/list/{id?}',[RegisterPersonController::class, 'index'])->name('tablepeople.index');
Route::get('/list/personupdate/{id}',[RegisterPersonController::class,'edit'])->name('person.createupdate');
Route::patch('/list/personupdate/{id}',[RegisterPersonController::class,'update'])->name('person.update');
Route::delete('/list/persondestroy/{id}',[RegisterPersonController::class,'destroy'])->name('person.destroy');
Route::middleware('auth')->group(function(){
    
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::get('/prueba', function () {
    return view('welcome');
})->middleware('auth','verified');


