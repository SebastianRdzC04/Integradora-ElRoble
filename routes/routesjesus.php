<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterPersonController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\EmployeeEventController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\VerifyPhoneController;
use App\Models\InventoryCategory;
use Laravel\Socialite\Facades\Socialite;

//Aqui esta el login de Facebook
Route::get('auth/facebook', [RegisterUserController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('auth/facebook/callback', [RegisterUserController::class, 'handleFacebookCallback'])->name('register.facebook');

//Aqui esta el login de Google
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');



// Html con politicas de uso, privacidad y de servicio publicas :)
Route::view('/policy/privacy', 'pages.policy.privacy-policy');
Route::view('/policy/terms/service', 'pages.policy.terms-of-service');
Route::view('/policy/delete/data', 'pages.policy.deletedata');


//Uso de Ajax con JQuery para el filtrado de datos
Route::get('/filter/select/report', [IncidentController::class,'filterDataIncidentReport'])->name('filterselectedcategories.employee');
Route::post('/create/incident',[IncidentController::class,'store'])->name('incident.store');
Route::post('/validate/incidents/inventory',[IncidentController::class,'saveItems'])->name('saveItems');
Route::get('/categories/index',[IncidentController::class,'getCategories'])->name('getCategories');

//aqui termina el uso de ajax
Route::get('/incident',[IncidentController::class,'create'])->name('incident.create');
Route::get('/event/now', [EmployeeEventController::class, 'showTodayEvent'])->name('event.today');





Route::get('/error',function () {
    return view('general_error');
})->name('error');




//rutas de inicio de sesion y creacion de cuenta

Route::middleware('guest')->group(function()
{
    // Ruta para mostrar el formulario de registro
    Route::get('/register/{phoneoremail}', [RegisterUserController::class, 'create'])->name('registeruser.create');
    
    // Ruta para enviar los datos del formulario de registro
    Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');
    
    Route::get('/sign/in/google', [LoginController::class, 'handleGoogleCallback'])->name('register.google');
    Route::get('/complete/data/google', [LoginController::class, 'createdatacompletegoogle'])->name('datagoogle');
    Route::post('/register/google', [RegisterUserController::class, 'storeUserGoogle'])->name('registergoogle.store');

    Route::get('/new-password',[ForgotPasswordController::class, 'showResetForm'])->name('newpassword');
    //muestra el formulario de ingresar email para restablecer
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    //manda email
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    //
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset')
    ->middleware('signed');

    //este es el que guarda los datos despues de aceptar el email
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

    //este es la ruta del login
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    
    //esta ruta es por si se ingresa un telefono en lugar de un email
    Route::get('/login/{phoneoremail?}', [LoginController::class, 'password'])->middleware('checkemailorphoneregistered')->name('login.password');

    //este guarda el login y lo autentifica
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
    Route::get('/email/verify', [VerifyEmailController::class, 'showVerificationEmailView'])
        ->name('verification.notice');

    // Ruta para salir de la sesion
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

//rutas para el crud de consumables --------------------------------------
Route::get('consumable/create',[ConsumableController::class,'create'])->name('consumables.create');
Route::post('consumable/store',[ConsumableController::class,'store'])->name('consumables.store');


//rutas de restablecimiento de contraseña
Route::group(['middleware' => 'guest'], function () {
});


Route::get('/list/{id?}',[RegisterPersonController::class, 'index'])->name('tablepeople.index');

//el usuario que inicie sesion pero no confirme su email solo podra estar aqui y no podra mandar la cotizacion
Route::get('/notverified', function () {
    return view('welcome');
})->middleware('auth');


/*aqui ya seria cuando el usuario mande la cotizacion 
dentro de aqui  
*/

Route::get('/prueba', function () {
    return view('welcome');
})->middleware('auth','verified');


Route::get('/prueba3',function () { 
    $serials = InventoryCategory::all();
    return view('pages.inventory.inventory_create',compact('serials'));
})->name('inventory');

Route::get('/inventory/consult/number' ,[InventoryController::class,'filterDataCategories'])->name('filtertest');
Route::post('/add/category', [InventoryController::class,'newCategory'])->name('newcategory.store');
Route::post('/add/inventory',[InventoryController::class,'addInventory'])->name('inventoryadd.store');
Route::post('/add/code',[InventoryController::class,'addNewCodeOrUpdate'])->name('codeadd.store');

Route::get('/phone/verify',[VerifyPhoneController::class, 'create'])->name('verifyphone.get');
Route::post('/send-otp', [VerifyPhoneController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [VerifyPhoneController::class, 'verifyOtp'])->name('verify.otp'); 
