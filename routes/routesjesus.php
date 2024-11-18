<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterPersonController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\IncidentController;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
 
//Aqui esta el login de X
Route::get('auth/redirect/x', [RegisterUserController::class, 'redirectToX'])->name('login.x');
Route::get('auth/callback/x', [RegisterUserController::class, 'handleXCallback'])->name('register.x');

//Aqui esta el login de Facebook
Route::get('auth/facebook', [RegisterUserController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('auth/facebook/callback', [RegisterUserController::class, 'handleFacebookCallback'])->name('register.facebook');

//Aqui esta el login de Google
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');



// Html con politicas de uso, privacidad y de servicio
Route::view('/policy/privacy', 'pages.policy.privacy-policy');
Route::view('/policy/terms/service', 'pages.policy.terms-of-service');
Route::view('/policy/delete/data', 'pages.policy.deletedata');


//Uso de Ajax con JQuery para el filtrado de datos
Route::get('/filter/select/report', [IncidentController::class,'filterDataIncidentReport'])->name('filterselectedcategories.employee');
Route::post('/create/incident',[IncidentController::class,'store'])->name('incident.store');
Route::post('/validate/incidents/inventory',[IncidentController::class,'saveItems'])->name('saveItems');
//aqui termina el uso de ajax

Route::get('/incident',[IncidentController::class,'create'])->name('incident.create');






Route::get('/error',function () {
    return view('general_error');
})->name('error');



// Ruta para mostrar el formulario de registro
Route::get('/register/{phoneoremail}', [RegisterUserController::class, 'create'])->name('registeruser.create');
Route::get('/register/google', [RegisterUserController::class, 'handleGoogleCallback'])->name('register.google');

// Ruta para enviar los datos del formulario de registro
Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');
Route::post('/register/google', [RegisterUserController::class, 'storeUserGoogle'])->name('registergoogle.store');




Route::get('/sign/in/google', [RegisterUserController::class, 'handleGoogleCallback'])->name('register.google');
//rutas de inicio de sesion y creacion de cuenta

Route::middleware('guest')->group(function()
{
    // Ruta para mostrar el formulario de registro
Route::get('/register/{phoneoremail}', [RegisterUserController::class, 'create'])->name('registeruser.create');

// Ruta para enviar los datos del formulario de registro
Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');
Route::post('/register/google', [RegisterUserController::class, 'storeUserGoogle'])->name('registergoogle.store');


    //muestra el formulario de ingresar email para restablecer
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    //manda email
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    //
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset')
    ->middleware('signed');

    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

    Route::get('/login', [LoginController::class, 'create'])->name('login');

    Route::get('/login/{phoneoremail?}', [LoginController::class, 'password'])->middleware('checkemailorphoneregistered')->name('login.password');

    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});




Route::middleware('auth')->group(function(){
    // Ruta para el enlace de verificación del email
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class,'verifyEmail'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');     

    // Ruta para reenviar el enlace de verificación con control de tiempo
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendVerificationEmail'])
    ->middleware('custom.throttle:1,2,verification.notice')->name('verification.send');

    // Ruta para mostrar la vista de verificación de correo
    Route::get('/email/verify', [VerifyEmailController::class, 'showVerificationView'])
        ->name('verification.notice');

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

/*aqui ya seria cuando el usuario mande la cotizacion 
dentro de aqui  
*/
Route::get('/notverified', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/prueba', function () {
    return view('welcome');
})->middleware('auth','verified');


