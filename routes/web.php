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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('dashboard/records', function () {
    $events = Event::orderBy('date', 'asc')->get();
    $consumableRecords = ConsumableRecord::all();
    
    $inventory = Inventory::select('serial_number_type_id', DB::raw('count(*) as total'))->groupBy('serial_number_type_id')->get();
    return view('pages.dashboard.registro', compact('events', 'consumableRecords', 'inventory'));
})->name('dashboard.records');

Route::get('dashboard/packages', function () {

    $packages = Package::paginate(10);
    return view('pages.dashboard.packages', compact('packages'));
})->name('dashboard.packages');

Route::get('dashboard/services', function () {
    $services = Service::paginate(10);
    return view('pages.dashboard.services', compact('services'));
})->name('dashboard.services');

Route::get('dashboard/quotes', function () {
    $quotes = Quote::paginate(10);
    return view('pages.dashboard.quotes', compact('quotes'));
})->name('dashboard.quotes');

Route::get('dashboard/graphics', function () {
    $places = Place::all();
    // obtener las cotizaciones por lugar


    return view('pages.dashboard.graficos', compact('places'));
})->name('dashboard.graphics');

Route::get('dashboard/events', function () {
    $events = Event::orderBy('date', 'asc')->get();
    return view('pages.dashboard.events', compact('events'));
})->name('dashboard.events');

Route::get('dashboard/inventory', function () {
    $inventory = Inventory::paginate(50);
    $consumableRecords = ConsumableRecord::all();
    $inventoryGroup = Inventory::select('serial_number_type_id', DB::raw('count(*) as total'))->groupBy('serial_number_type_id')->get();
    return view('pages.dashboard.inventory', compact('inventory', 'consumableRecords', 'inventoryGroup'));
})->name('dashboard.inventory');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
require __DIR__.'/auth.php';

*/
