<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Consumable;
use App\Models\ConsumableRecord;
use App\Models\Date;
use App\Models\Event;
use App\Models\Inventory;
use App\Models\Package;
use App\Models\Place;
use App\Models\Quote;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

// Controladores de AxelV2.0
use App\Http\Controllers\ServiciosAdminController;
use App\Http\Controllers\CotizacionesClientesController;
use App\Http\Controllers\PaquetesAdminController;

/*
|--------------------------------------------------------------------------
// Rutas Web
|--------------------------------------------------------------------------
// Aquí es donde puedes registrar las rutas web para tu aplicación.
// Estas rutas se cargan por el RouteServiceProvider y se les asigna el
| grupo de middleware "web".
*/

Route::get('/', function () {
    return view('pages.inicio');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('dashboard/records', function () {
    $events = Event::orderBy('date', 'asc')->get();
    $consumableRecords = ConsumableRecord::all();
    
    $inventory = Inventory::select('serial_number_type_id', DB::raw('count(*) as total'))->groupBy('serial_number_type_id')->get();
    return view('pages.dashboard.registro', compact('events', 'consumableRecords', 'inventory'));
})->name('dashboard.records');

Route::get('dashboard/packages', function () {

    $packages = Package::all();
    return view('pages.dashboard.packages', compact('packages'));
})->name('dashboard.packages');

Route::get('dashboard/services', function () {
    $services = Service::all();
    return view('pages.dashboard.services', compact('services'));
})->name('dashboard.services');

Route::get('dashboard/quotes', function () {
    $quotes = Quote::all();
    return view('pages.dashboard.quotes', compact('quotes'));
})->name('dashboard.quotes');

Route::get('dashboard/graphics', function () {
    $places = Place::all();
    // obtener las cotizaciones por lugar
    $events = Event::where('status', 'Pendiente')->orWhere('status', 'Finalizado')->get();

    $paquetes = Package::all();

    //Datos grafica 2
    $eventos_sinPaquete = 0;
    $eventos_conPaquete = 0;
    $datos2 = [
        [
            'data' => [0,0,0,0,0,0,0,0,0,0,0,0],
            'type' => 'bar',
            'stack' => 'a',
            'name' => 'Sin paquete',
        ],
        
    ];

    foreach ($paquetes as $paquete) {
        $datos2[] = [
            'data' => [0,0,0,0,0,0,0,0,0,0,0,0],
            'type' => 'bar',
            'stack' => 'b',
            'name' => $paquete->name,
        ];
    }


    foreach ($events as $event) {
        if ($event->quote->package_id == null) {
            $eventos_sinPaquete++;
            //hacer un match por mes 
            $mes = Carbon::parse($event->date)->format('m');
            $datos2[0]['data'][$mes - 1] += 1;
        } else {
            $eventos_conPaquete++;
            $mes2 = Carbon::parse($event->date)->format('m');
            $datos2[$event->quote->package_id]['data'][$mes2 - 1] += 1;
        }
    }
    

    return view('pages.dashboard.graficos', compact('places', 'events', 'paquetes', 'datos2'));
})->name('dashboard.graphics');

Route::get('dashboard/events', function () {
    $events = Event::orderBy('date', 'asc')->get();
    return view('pages.dashboard.events', compact('events'));
})->name('dashboard.events');

Route::get('dashboard/inventory', function () {
    $inventory = Inventory::all();
    $consumableRecords = ConsumableRecord::all();
    $inventoryGroup = Inventory::select('serial_number_type_id', DB::raw('count(*) as total'))->groupBy('serial_number_type_id')->get();
    return view('pages.dashboard.inventory', compact('inventory', 'consumableRecords', 'inventoryGroup'));
})->name('dashboard.inventory');

Route::get('dashboard/consumables', function () {
    $consumables = Consumable::all();
    return view('pages.dashboard.consumables', compact('consumables'));
})->name('dashboard.consumables');

Route::get('dashboard/packages/{id}', function ($id) {
    $package = Package::find($id);
    return view('pages.dashboard.packagesedit', compact('package'));
})->name('dashboard.package');






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Axelv2.0
Route::get('/crearpaquetes', [PaquetesAdminController::class, 'create'])->name('crearpaquetes');
Route::post('/paquetes', [PaquetesAdminController::class, 'store'])->name('paquetes.store'); // Agregar esta ruta
Route::get('/crearservicios', [ServiciosAdminController::class, 'create'])->name('crearservicios');
Route::post('/servicios', [ServiciosAdminController::class, 'store'])->name('servicios.store');
Route::get('/cotizaciones', [CotizacionesClientesController::class, 'create'])->name('cotizaciones.create');
Route::post('cotizacionesclientes', [CotizacionesClientesController::class, 'store'])->name('cotizacionesclientes.store');
Route::get('/inicio', [ServiciosAdminController::class, 'provisional'])->name('inicio');

// Si necesitas una vista para listar paquetes
Route::get('/paquetes', [PaquetesAdminController::class, 'index'])->name('paquetes.index'); // O lo que desees
/*
require __DIR__.'/auth.php';
*/
