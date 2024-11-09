<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterPersonController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ConsumableController;

Route::get('/error',function () {
    return view('general_error');
})->name('error');


//logica de laravel para verificacion de correos y envio de correos

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Ruta para mostrar el formulario de registro
Route::get('/register/{phoneoremail}', [RegisterUserController::class, 'create'])->name('register');

// Ruta para enviar los datos del formulario de registro
Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');

// Ruta para verificar el email (Laravel ya incluye esta verificación)
Route::get('/email/verify', function () {
    return view('pages.sesion.notification.verify_email'); // Aquí puedes personalizar tu vista
})->middleware('auth')->name('verification.notice');

// Ruta para el enlace de verificación del email
Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
    
// Ruta para reenviar el email de verificación
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Enlace de verificación reenviado.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');






//rutas de inicio de sesion y creacion de cuenta
Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::get('/login/{phoneoremail?}', [LoginController::class, 'verifypassword'])->middleware('checkemailorphoneregistered')->name('login.password');
    Route::post('/login', [LoginController::class, 'store']);
});
Route::middleware('auth')->group(function(){
    
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

/*
    Route::get('/registeruser/{phoneoremail}', [RegisterUserController::class, 'create'])->name('registeruser.create');
    Route::post('/registeruser', [RegisterUserController::class, 'store'])->name('registeruser.store');


    //Route::get('/personregister', [RegisterPersonController::class, 'create'])->name('registerperson.create');
    //Route::post('/personregister', [RegisterPersonController::class, 'store'])->name('registerperson.store');

*/




//rutas de restablecimiento de contraseña
Route::group(['middleware' => 'guest'], function () {
    
    
    
    //muestra el formulario de ingresar email para restablecer
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    //manda email
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    //
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset')
    ->middleware('signed');

    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::get('/list/{id?}',[RegisterPersonController::class, 'index'])->name('tablepeople.index');

//rutas para el crud de consumables ---------------------
Route::get('consumable/create',[ConsumableController::class,'create'])->name('consumables.create');
Route::post('consumable/store',[ConsumableController::class,'store'])->name('consumables.store');


//ruta para la lista de personas ------------------------
Route::get('/list/{id?}',[RegisterPersonController::class, 'index'])->name('tablepeople.index');
Route::get('/list/personupdate/{id}',[RegisterPersonController::class,'edit'])->name('person.createupdate');
Route::patch('/list/personupdate/{id}',[RegisterPersonController::class,'update'])->name('person.update');
Route::delete('/list/persondestroy/{id}',[RegisterPersonController::class,'destroy'])->name('person.destroy');


Route::get('/prueba', function () {
    return view('welcome');
})->middleware('auth','verified');


