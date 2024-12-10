<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Consumable;
use App\Models\ConsumableRecord;
use App\Models\Event;
use App\Models\Inventory;
use App\Models\Package;
use App\Models\Place;
use App\Models\Quote;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

// Controladores de AxelV2.0
use App\Http\Controllers\ServiciosAdminController;
use App\Http\Controllers\CotizacionesClientesController;
use App\Http\Controllers\PaquetesAdminController;
use App\Models\ConsumableEvent;
use App\Models\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InicioClientesController;
use App\Models\ConsumableCategory;
use App\Models\ConsumableEventDefault;
use App\Models\User;
use App\Http\Controllers\PaymentController;
use App\Models\ServiceCategory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
// Rutas Web
|--------------------------------------------------------------------------
// Aquí es donde puedes registrar las rutas web para tu aplicación.
// Estas rutas se cargan por el RouteServiceProvider y se les asigna el
| grupo de middleware "web".
*/

Route::view('/','layouts.appprincipal')->name('inicio');

Route::get('inventory/create', function() {
    return view('pages.inventory.inventory_create');
})->name('inventory.create');

Route::get('calendario', function() {
    return view('pages.calendario');
})->name('calendario');

Route::get('dashboard/records', function () {
    $events = Event::orderBy('date', 'asc')->get();
    $consumableRecords = ConsumableRecord::all();
    $inventory = Inventory::select('serial_number_type_id', DB::raw('count(*) as total'))->groupBy('serial_number_type_id')->get();
    return view('pages.dashboard.registro', compact('events', 'consumableRecords', 'inventory'));
})->name('dashboard.records');


// Rutas que seran protegidas con el middleware del administrador


/*
Route::middleware('empleado')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/event/current', function () {
        $event = Event::where('date', Carbon::now()->format('Y-m-d'))->where('status', '!=', 'Finalizado')->first();
        if ($event) {
            session(['event' => $event]);
            return view('pages.dashboard.eventosAdmin', compact('event'));
        }
        return redirect()->route('dashboard');
    })->name('dashboard.event.now');

    Route::get('dashboard/packages', function () {
        $packages = Package::all();
        return view('pages.dashboard.packages', compact('packages'));
    })->name('dashboard.packages');

    Route::get('dashboard/services', function () {
        $services = Service::all();
        return view('pages.dashboard.services', compact('services'));
    })->name('dashboard.services');
    
});
*/


Route::middleware(['auth' ,'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/event/current', function () {
        $event = Event::where('date', Carbon::now()->format('Y-m-d'))->where('status', '!=', 'Finalizado')->first();
        if ($event) {
            session(['event' => $event]);
            $consumables = Consumable::all();
            $consumablesCategories = ConsumableCategory::all();
            return view('pages.dashboard.eventosAdmin', compact('event', 'consumables', 'consumablesCategories'));
        }
        return redirect()->route('dashboard');
    })->name('dashboard.event.now');

    Route::get('dashboard/packages', function () {
    // Obtener la fecha actual con Carbon y establecer la hora al inicio del día
    $currentDate = Carbon::now()->startOfDay();

    // Obtener todos los paquetes y actualizar su estado
    $packages = Package::all();
    foreach ($packages as $package) {
        $startDate = Carbon::parse($package->start_date)->startOfDay();
        $endDate = Carbon::parse($package->end_date)->endOfDay();

        if ($currentDate->between($startDate, $endDate)) {
            $package->is_active = true;
        } else {
            $package->is_active = false;
        }
        $package->save();
    }

    $places = Place::all();
    $services = Service::all();
    return view('pages.dashboard.packages', compact('packages', 'places', 'services'));
})->name('dashboard.packages');

    Route::get('dashboard/services', function () {
        $services = Service::all();
        $serviceCategories = ServiceCategory::all();
        return view('pages.dashboard.services', compact('services', 'serviceCategories'));
    })->name('dashboard.services');
    Route::get('dashboard/inventory', function () {
        $inventory = Inventory::all();
        $consumableRecords = ConsumableRecord::all();
        $inventoryGroup = Inventory::select('serial_number_type_id', DB::raw('count(*) as total'))->groupBy('serial_number_type_id')->get();
        return view('pages.dashboard.inventory', compact('inventory', 'consumableRecords', 'inventoryGroup'));
    })->name('dashboard.inventory');

});

Route::middleware(['auth' ,'superadmin'])->group(function () {

    Route::get('dashboard/graphics/profits', function(Request $request){
        $request->validate([
            'year' => 'required|integer|min:2000',
        ]);
        $year = $request->year;
        $ingresosPorMes = array_fill(0, 12, 0);
        Event::where('status', 'Finalizado')
            ->whereYear('date', $year)
            ->get()
            ->each(function($event) use (&$ingresosPorMes) {
                $mes = Carbon::parse($event->date)->format('m');
                $ingresosPorMes[$mes - 1] += $event->total_price;
            });
        return response()->json($ingresosPorMes);
    })->name('dashboard.graphics.profits');

    Route::get('dashboard/graphics', function () {
        $places = Place::all();
        $events = Event::where('status', 'Pendiente')->orWhere('status', 'Finalizado')->get();
        $paquetes = Package::all();
        $ingresosPorMes = array_fill(0, 12, 0);
        Event::where('status', 'Finalizado')
            ->whereYear('date', Carbon::now()->year)
            ->get()
            ->each(function($event) use (&$ingresosPorMes) {
                $mes = Carbon::parse($event->date)->format('m');
                $ingresosPorMes[$mes - 1] += $event->total_price;
            });

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
        $yearActual = Carbon::now()->year;
        $eventsThisYear = Event::whereYear('date', $yearActual)->where('status', '!=', 'Cancelado')->get();
        foreach ($eventsThisYear as $event) {
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
        return view('pages.dashboard.graficos', compact('places', 'events', 'paquetes', 'datos2', 'ingresosPorMes'));
    })->name('dashboard.graphics');


    Route::get('dashboard/quotes', function () {
        $quotes = Quote::all()->sortByDesc('created_at');
        return view('pages.dashboard.quotes', compact('quotes'));
    })->name('dashboard.quotes');


    Route::get('dashboard/quotes/{id}', function ($id) {
        $quote = Quote::find($id);
        if ($quote->status == 'pendiente cotizacion' || $quote->status == 'pendiente') {
            return view('pages.dashboard.cotizacionAdmin', compact('quote'));
        }
        return redirect()->route('dashboard');
    })->name('dashboard.quote');


    Route::post('dashboard/quote/event/{id}', function ($id, Request $request) {
        $quote = QuoteService::find($id);
        $request->validate([
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
        ]);
        if ($quote) {
            $quote->quantity = $request->cantidad;
            $quote->price = $request->precio;
            $quote->coast = $request->costo;
            $quote->save();
        }
        return redirect()->back()->with('success', 'El servicio ha sido actualizado');
    })->name('dashboard.quote.status');


    Route::post('dashboard/quote/payment/{id}', function ($id) {
        $quote = Quote::find($id);
        if ($quote->status == 'pendiente') {
            $quote->status = 'pagada';
            $quote->save();
            $quotesSimi = Quote::where('date', $quote->date)->get();
            foreach ($quotesSimi as $quotee) {
                //aqui ya manda el mail a cada quote user
            }
            return redirect()->back()->with('success', 'La cotización ha sido pagada. Termina de configurar el evento');
        }
        return redirect()->back()->with('error', 'La cotización no puede ser pagada');

    })->name('dashboard.quote.payment');


    Route::post('dashboard/quote/pending/{id}', function ($id) {
        $quote = Quote::find($id);
        if ($quote->status == 'pendiente cotizacion') {
            $quote->status = 'pendiente';
            $quote->save();
            return redirect()->back()->with('success', 'La cotización ha sido marcada como pendiente');
        }
        return redirect()->back()->with('error', 'La cotización no puede ser marcada como pendiente');

    })->name('dashboard.quote.pending');


    Route::post('dashboard/quote/advance/{id}', function ($id, Request $request) {
        $quote = Quote::find($id);
        $request->validate([
            'anticipo' => 'required|numeric|min:0',
        ]);
        if (!$quote) {
        return redirect()->back()->with('error', 'La cotización no se ha encontrado');
        }

        try {
            $quote->espected_advance = $request->anticipo;
            $quote->save();
            return redirect()->back()->with('success', 'El anticipo ha sido registrado');
        } catch (\PDOException $e) {
            if ($e->getCode() == "45000") {
                return redirect()->back()->with('error', 'El anticipo no puede ser mayor al precio estimado come caca');
            }
            return redirect()->back()->with('error', 'Error al registrar el anticipo');
        }

    })->name('dashboard.quote.advance');


    Route::post('dashboard/quote/price/{id}', function ($id, Request $request) {
        $quote = Quote::find($id);
        $request->validate([
            'precio' => 'required|numeric|min:0',
        ]);
        if ($quote) {
            $quote->estimated_price = $request->precio;
            $quote->save();
            return redirect()->back()->with('success', 'El precio ha sido registrado');
        }
        return redirect()->back()->with('error', 'La cotización no se ha encontrado');

    })->name('dashboard.quote.price');

    Route::get('dashboard/events', function () {
        $events = Event::orderBy('date', 'asc')->get();
        return view('pages.dashboard.events', compact('events'));
    })->name('dashboard.events');


    Route::get('dashboard/event/{id}', function ($id) {
        $event = Event::find($id);
        if ($event) {
            session(['event' => $event]);
            $consumables = Consumable::all();
            $consumablesCategories = ConsumableCategory::all();
            return view('pages.dashboard.eventosAdmin', compact('event', 'consumables', 'consumablesCategories'));
        }
        return redirect()->route('dashboard');
    })->name('dashboard.event.view');


    Route::post('dashboard/event/start/{id}', function ($id) {
        $event = Event::find($id);
        $consumables = ConsumableEvent::where('event_id', $event->id)->get();
        if ($event) {
            if ($consumables->contains('ready', false)) {
                return redirect()->back()->with('error', 'No todos los consumibles estan listos');
                
            }
            if ($event->status == 'En espera') {
                $event->status = 'En proceso';
                $event->start_time = Carbon::now()->format('H:i:s');
                $event->save();
                return redirect()->back()->with('success', 'El evento ha sido iniciado');
            }
        }
        return redirect()->back()->with('error', 'El evento no se ha encontrado');

    })->name('dashboard.start.event');


    Route::post('dashboard/event/end/{id}', function ($id) {
        $event = Event::find($id);
        if ($event) {
            if ($event->status == 'En proceso') {
                $event->status = 'Finalizado';
                $event->end_time = Carbon::now()->format('H:i:s');
                $event->save();
                return redirect()->back()->with('success', 'El evento ha sido finalizado');
            }
        }
        return redirect()->back()->with('error', 'El evento no se ha encontrado');

    })->name('dashboard.end.event');

    Route::post('dashboard/event/chair/{id}', function ($id, Request $request) {
        $event = Event::find($id);
        $request->validate([
            'sillas' => 'required|integer|min:0',
        ]);
        if ($event) {
            $event->chair_count = $request->sillas;
            $event->save();
            return redirect()->back()->with('success', 'El numero de sillas ha sido actualizado');
        }
        return redirect()->back()->with('error', 'El evento no se ha encontrado');

    })->name('dashboard.event.chairs');

    Route::post('dashboard/event/table/{id}', function ($id, Request $request) {
        $event = Event::find($id);
        $request->validate([
            'mesas' => 'required|integer|min:0',
        ]);
        if ($event) {
            $event->table_count = $request->mesas;
            $event->save();
            return redirect()->back()->with('success', 'El numero de mesas ha sido actualizado');
        }
        return redirect()->back()->with('error', 'El evento no se ha encontrado');

    })->name('dashboard.event.tables');

    Route::post('dashboard/event/table/cloth/{id}', function ($id, Request $request) {
        $event = Event::find($id);
        $request->validate([
            'manteles' => 'required|integer|min:0',
        ]);
        if ($event) {
            $event->table_cloth_count = $request->manteles;
            $event->save();
            return redirect()->back()->with('success', 'El numero de manteles ha sido actualizado');
        }
        return redirect()->back()->with('error', 'El evento no se ha encontrado');

    })->name('dashboard.event.tablecloths');

    Route::post('dashboard/event/extra/hour/price/{id}', function ($id, Request $request) {
        $event = Event::find($id);
        $request->validate([
            'precio' => 'required|numeric|min:0',
        ]);
        if ($event) {
            $event->extra_hour_price = $request->precio;
            $event->save();
            return redirect()->back()->with('success', 'El precio de la hora extra ha sido actualizado');
        }
        return redirect()->back()->with('error', 'El evento no se ha encontrado');

    })->name('dashboard.event.extra.hour.price');


    Route::post('dashboard/event/consumable/status/{id}', function ($id) {
        $consumableEvent = ConsumableEvent::find($id);
        $consumable = Consumable::find($consumableEvent->consumable_id);
        if ($consumableEvent) {
            if (!$consumableEvent->ready) {
                if ($consumable->stock < $consumableEvent->quantity) {
                    return response()->json([
                        'status' => 'error',
                    ]);
                }
                else {
                    $consumableEvent->ready = !$consumableEvent->ready;
                    $consumableEvent->save();

                }
            }
            else{
                $consumableEvent->ready = !$consumableEvent->ready;
                $consumableEvent->save();

            }
        }
        return response()->json([
            'status' => 'success',
        ]);
        })->name('dashboard.event.consumable');



        
        Route::get('dashboard/consumables', function () {
        $consumables = Consumable::all();
        $consumablesDefault = ConsumableEventDefault::all();
        return view('pages.dashboard.consumables', compact('consumables', 'consumablesDefault'));
    })->name('dashboard.consumables');


    Route::post('dashboard/consumable/category/create', function (Request $request) {
        $request->validate([
            'nombre' => 'required|string',
        ]);
        $consumable = new ConsumableCategory();
        $consumable->name = $request->nombre;
        $consumable->save();
        return redirect()->back()->with('success', 'La categoria ha sido creada correctamente');
    })->name('dashboard.consumable.category.create');


    Route::post('dashboard/consumable/add/default{id}', function ($id, Request $request) {
        $consumable = Consumable::find($id);
        $request->validate([
            'cantidad' => 'required|integer|min:0',
        ]);
        if ($consumable && $consumable->maximum_stock >= $request->cantidad) {
            $consumable->consumableEventDefault()->create([
                'quantity' => $request->cantidad,
            ]);
            return redirect()->back()->with('success', 'El consumible ha sido agregado a los eventos por defecto');
        }
        return redirect()->back()->with('error', 'No puedes sobrepasar el stock maximo come caca');

    })->name('dashboard.add.consumable.default');


    Route::post('dashboard/consumable/delete/default/{id}', function ($id) {
        $consumable = ConsumableEventDefault::find($id);
        if ($consumable) {
            $consumable->delete();
            return redirect()->back()->with('success', 'El consumible ha sido eliminado de los eventos por defecto');
        }
        return redirect()->back()->with('error', 'El consumible no se ha encontrado');

    })->name('dashboard.delete.consumable.default');


    Route::post('dashboard/consumable/add/stock/{id}', function ($id, Request $request) {
        $consumable = Consumable::find($id);
        $request->validate([
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);
        if ($consumable) {
            try {
                $consumableRecord = new ConsumableRecord();
                $consumableRecord->consumable_id = $consumable->id;
                $consumableRecord->quantity = $request->cantidad;
                $consumableRecord->price = $request->precio;
                $consumableRecord->save();
                
                return redirect()->back()->with('success', 'El stock ha sido agregado correctamente');
            } catch (\PDOException $e) {
                // Captura específicamente el error del trigger
                if ($e->getCode() == "45000") {
                    return redirect()->back()->with('error', 'El stock es mas del permitido carnal');
                }
                // Otros errores de base de datos
                return redirect()->back()->with('error', 'Error al actualizar el stock');
            }
        }
        return redirect()->back()->with('error', 'El consumible no se ha encontrado');

    })->name('dashboard.consumable.add.stock');

    Route::post('dashboard/consumable/delete/{id}', function ($id){
        $consumable = Consumable::find($id);
        if ($consumable){
            $consumable->delete();
            return redirect()->back()->with('success', 'si se elimino banda');
        }
        return redirect()->back()->with('error', 'No se encontro banda');
    })->name('dashboard.consumable.delete');

    Route::post('dashboard/consumable/edit/{id}', function ($id, Request $request){
        $consumable = Consumable::find($id);
        $request->validate([
            'nombre_edit' => 'required|string',
            'descripcion_edit' => 'required|string',
            'unidad_edit' => 'required|string',
            'stock_min_edit' => 'required|integer|min:0',
            'stock_max_edit' => 'required|integer|min:0',
        ]);
        if ($consumable){
            try {
                $consumable->name = $request->nombre_edit;
                $consumable->description = $request->descripcion_edit;
                $consumable->unit = $request->unidad_edit;
                $consumable->minimum_stock = $request->stock_min_edit;
                $consumable->maximum_stock = $request->stock_max_edit;
                $consumable->save();
                return redirect()->back()->with('success', 'si se edito banda');
            } catch (\PDOException $e) {
                // Captura específicamente el error del trigger
                if ($e->getCode() == "45000") {
                    return redirect()->back()->with('error', 'El stock minimo no puede ser mayor al stock maximo');
                }
                // Otros errores de base de datos
                return redirect()->back()->with('error', 'Error al actualizar el stock');
            }
        }
    })->name('dashboard.consumable.edit');

    Route::get('dashboard/users', function(){
        $users = User::all();
        return view('pages.dashboard.users', compact('users'));
    })->name('dashboard.users');

    Route::post('dashboard/inventory/edit/{id}', function ($id, Request $request){
        $inventory = Inventory::find($id);
        $request->validate([
            'description' => 'required|string',
            'status' => 'required|string',
        ]);
        if ($inventory){
            $inventory->status = $request->status;
            $inventory->description = $request->description;
            $inventory->save();
            return redirect()->back()->with('success', 'si se edito banda');
        }
        return redirect()->back()->with('error', 'No se encontro banda');
    })->name('dashboard.inventory.edit');

    Route::post('dashboard/inventory/delete/{id}', function ($id){
        $inventory = Inventory::find($id);
        if ($inventory){
            $inventory->delete();
            return redirect()->back()->with('success', 'si se elimino banda');
        }
        return redirect()->back()->with('error', 'No se encontro banda');
    })->name('dashboard.inventory.delete');

    Route::post('dashboard/consumable/event/delete/{id}', function($id){
        $consumableEvent = ConsumableEvent::find($id);
        if ($consumableEvent){
            $consumableEvent->delete();
            return redirect()->back()->with('success', 'si se elimino banda');
        }
        return redirect()->back()->with('error', 'No se encontro banda');
    })->name('dashboard.consumable.event.delete');
});











































Route::get('dashboard/packages/{id}', function ($id) {
    $package = Package::find($id);
    return view('pages.dashboard.packagesedit', compact('package'));
})->name('dashboard.package');


Route::get('dashboard/services/{id}', function ($id) {
    $service = Service::find($id);
    return view('pages.dashboard.servicesedit', compact('service'));
})->name('dashboard.service');


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
Route::get('/inicio', [InicioClientesController::class, 'create'])->name('inicio');
Route::get('/historial', [CotizacionesClientesController::class, 'historial'])->name('historial');
Route::post('/pagar', [PaymentController::class, 'pay'])->name('pagar');
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('create-payment-intent');
Route::post('/confirm-payment', [PaymentController::class, 'confirmPayment'])->name('confirm-payment');
Route::post('/api/cotizations', [CotizacionesClientesController::class, 'getCotizations']);
Route::get('/dashboard/crear/cotizacion', [CotizacionesClientesController::class, 'nuevaCotizacionAdmin'])->name('cotizaciones.nuevaAdmin');
Route::post('/dashboard/cotizando', [CotizacionesClientesController::class, 'storeQuoteAdmin'])->name('cotizaciones.storeQuoteAdmin');

Route::middleware(['auth'])->group(function () {
    Route::get('/cotizaciones/nueva', [CotizacionesClientesController::class, 'nuevaCotizacion'])
        ->name('cotizaciones.nueva')
        ->middleware('check.pending.quotes');
    Route::post('/cotizaciones/storeQuote', [CotizacionesClientesController::class, 'storeQuote'])
        ->name('cotizaciones.storeQuote')
        ->middleware('check.pending.quotes');
    Route::get('/historialclientes', [CotizacionesClientesController::class, 'historialClientes'])
        ->name('historialclientes');
});

// Si necesitas una vista para listar paquetes
Route::get('/paquetes', [PaquetesAdminController::class, 'index'])->name('paquetes.index'); // O lo que desees




Route::get('dashboard/crear/paquetes', function () {
    $places = Place::all();
    $services = Service::all();
    return view('pages.dashboard.crearPaquetes', compact('services', 'places'));
})->name('dashboard.crear.paquetes');

Route::get('dashboard/crear/servicios', function () {
    $serviceCategories = ServiceCategory::all();
    return view('pages.dashboard.crearServicios', compact('serviceCategories'));
})->name('dashboard.crear.servicios');

Route::post('dashboard/crear/categoria/servicios', function (Request $request){
    $request->validate([
        'nombreCategoria' => 'required|string|max:50|unique:service_categories,name',
    ]);
    $serviceCategory = new ServiceCategory();
    $serviceCategory->name = $request->nombreCategoria;
    $serviceCategory->save();
    return redirect()->back()->with('success', 'La categoria ha sido creada correctamente');
})->name('dashboard.crear.categoria.servicios');

Route::post('dashboard/event/consumable/add/{id}', function ($id, Request $request) {
    $event = Event::find($id);
    $request->validate([
        'consumible' => 'required|integer|exists:consumables,id',
    ]);
    $consumable = Consumable::find($request->consumible);

    $request->validate([
        'cantidad' => [
            'required',
            'integer',
            'min:0',
            function ($attribute, $value, $fail) use ($consumable) {
                if ($value > $consumable->maximum_stock) {
                    $fail("La cantidad no puede ser mayor al stock máximo del consumible ({$consumable->maximum_stock})");
                }
            }
        ],
    ]);

    if ($event && $consumable) {
        $consumableEvent = new ConsumableEvent();
        $consumableEvent->event_id = $event->id;
        $consumableEvent->consumable_id = $consumable->id;
        $consumableEvent->quantity = $request->cantidad;
        $consumableEvent->save();
        
        return redirect()->back()->with('success', 'El consumible ha sido agregado al evento');
    }

    return redirect()->back()->with('error', 'El evento o consumible no se ha encontrado');

})->name('dashboard.event.consumable.add');

Route::post('dashboard/service/edit/{id}', function($id, Request $request){
    $request->validate([
        'categoria' => 'required|string|exists:service_categories,name',
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'costo' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', 
        'afore' => 'required|integer|max:100',
    ]);
    $service = Service::find($id);
    $service->service_category_id = ServiceCategory::where('name', $request->categoria)->first()->id;
    $service->name = $request->nombre;
    $service->description = $request->descripcion;
    $service->price = $request->precio;
    $service->coast = $request->costo;
    $service->people_quantity = $request->afore;
    $service->save();
    return redirect()->back()->with('success', 'El servicio ha sido actualizado correctamente');

})->name('dashboard.service.edit');

Route::post('dashboard/create/service', function(Request $request){
    $imagenCortada = $request->input('croppedImage');

    // Validar los datos del formulario
    $request->validate([
        'categoria' => 'required|string|exists:service_categories,name',
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'costo' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', 
        'afore' => 'required|integer|max:100',
        'croppedImage' => 'required|string', // Validar que la imagen recortada esté presente
    ]);

    $imagePath = null;
    if ($imagenCortada) {
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagenCortada));
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload');
        file_put_contents($tempFilePath, $image);

        $uploadedFileUrl = Cloudinary::upload($tempFilePath)->getSecurePath();
        $imagePath = $uploadedFileUrl;
    }

    // Crear el nuevo servicio
    $service = new Service();
    $service->service_category_id = ServiceCategory::where('name', $request->categoria)->first()->id;
    $service->name = $request->nombre;
    $service->description = $request->descripcion;
    $service->price = $request->precio;
    $service->coast = $request->costo;
    $service->people_quantity = $request->afore;
    $service->image_path = $imagePath; // Guardar la URL de la imagen en la base de datos
    $service->save();

    return redirect()->back()->with('success', 'El servicio ha sido creado correctamente');
})->name('dashboard.create.service');

Route::post('dashboard/create/package', function(Request $request){
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'fechaInicio' => 'required|date|after_or_equal:today',
        'fechaFin' => 'required|date|after_or_equal:fechaInicio',
        'lugar' => 'required|string|exists:places,id',
        'afore' => 'required|integer|max:100',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $package = new Package();
    $package->name = $request->nombre;
    $package->description = $request->descripcion;
    $package->price = $request->precio;
    $package->start_date = $request->fechaInicio;
    $package->end_date = $request->fechaFin;
    $package->place_id = Place::find($request->lugar)->id;
    $package->max_people = $request->afore;

    // Determinar si el paquete está activo
    $currentDate = now()->toDateString();
    $package->is_active = ($request->fechaInicio <= $currentDate && $request->fechaFin >= $currentDate);

    $package->save();

    return redirect()->back()->with('success', 'El paquete ha sido creado correctamente');
})->name('dashboard.create.package');

Route::post('dashboard/package/edit/{id}', function($id, Request $request) {
    $request->validate([
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'fechaInicio' => 'required|date',
        'fechaFin' => 'required|date',
        'lugar' => 'required|string|exists:places,id',
        'afore' => 'required|integer|max:100',
    ]);
    $package = Package::find($id);
    $package->name = $request->nombre;
    $package->description = $request->descripcion;
    $package->price = $request->precio;
    $package->start_date = $request->fechaInicio;
    $package->end_date = $request->fechaFin;
    $package->place_id = Place::find($request->lugar)->id;
    $package->max_people = $request->afore;
    $package->save();
    return redirect()->back()->with('success', 'El paquete ha sido actualizado correctamente');
})->name('dashboard.edit.package');


Route::post('dashboard/package/{id}/add/service', function($id, Request $request) {
    $package = Package::find($id);
    
    $request->validate([
        'servicio' => 'required|integer|exists:services,id',
    ]);

    $service = Service::find($request->servicio);

    $request->validate([
        'cantidad' => [
            'required',
            'integer',
            'min:0',
            'max:150', // Validar que la cantidad sea como máximo 150
        ],
        'precio' => [
            'required',
            'numeric',
            'min:0',
        ],
        'costo' => [
            'required',
            'numeric',
            function ($attribute, $value, $fail) use ($service) {
                if ($value > $service->price) {
                    $fail("El costo no puede ser mayor al precio del servicio ({$service->price})");
                }
            }
        ],
        'descripcion' => 'required|string',
    ]);

    if ($package && $service) {
        $package->services()->attach($service->id, ['quantity' => $request->cantidad, 'coast' => $request->costo, 'description' => $request->descripcion, 'price' => $request->precio]);
        return redirect()->back()->with('success', 'El servicio ha sido agregado al paquete');
    }

    return redirect()->back()->with('error', 'El paquete o servicio no se ha encontrado');
})->name('dashboard.package.add.service');

Route::post('dashboard/package/delete/{id}', function ($id){
    $package = Package::find($id);
    if ($package){
        $package->delete();
        return redirect()->back()->with('success', 'si se elimino banda');
    }
    return redirect()->back()->with('error', 'No se encontro banda');
})->name('dashboard.package.delete');

Route::get('dashboard/places', function () {
    $places = Place::all();
    return view('pages.dashboard.places', compact('places'));
})->name('dashboard.places');

Route::post('dashboard/place/edit/{id}', function ($id, Request $request) {
    $place = Place::find($id);
    $request->validate([
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'afore' => 'required|integer|min:0',
    ]);
    $place->name = $request->nombre;
    $place->description = $request->descripcion;
    $place->max_guest = $request->afore;
    $place->save();
    return redirect()->back()->with('success', 'El lugar ha sido actualizado correctamente');
})->name('dashboard.place.edit');

Route::post('dashboard/place/edit/image/{id}', function ($id, Request $request) {
    $place = Place::findOrFail($id);
    
    $request->validate([
        'croppedImage' => [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                if (!preg_match('/^data:image\/[a-zA-Z]+;base64,/', $value)) {
                    $fail('El formato de la imagen no es válido.');
                }
            },
        ]
    ]);

    try {
        $imagenCortada = $request->input('croppedImage');
        
        // Decodificar y limpiar la imagen base64
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagenCortada));
        
        if ($image === false) {
            return redirect()->back()->with('error', 'Error al procesar la imagen');
        }

        // Crear archivo temporal
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload');
        if (file_put_contents($tempFilePath, $image) === false) {
            return redirect()->back()->with('error', 'Error al guardar la imagen temporalmente');
        }

        // Subir a Cloudinary
        $uploadedFile = Cloudinary::upload($tempFilePath, [
            'folder' => 'places',
            'quality' => 'auto',
            'fetch_format' => 'auto',
        ]);

        // Actualizar la URL en la base de datos
        $place->image_path = $uploadedFile->getSecurePath();
        $place->save();

        // Eliminar archivo temporal
        unlink($tempFilePath);

        return redirect()->back()->with('success', 'La imagen ha sido actualizada correctamente');

    } catch (\Exception $e) {
        // Si existe el archivo temporal, eliminarlo
        if (isset($tempFilePath) && file_exists($tempFilePath)) {
            unlink($tempFilePath);
        }
        
        return redirect()->back()->with('error', 'Error al procesar la imagen: ' . $e->getMessage());
    }
})->name('dashboard.place.edit.image');

Route::post('dashboard/event/edit/date/{id}', function ($id, Request $request) {
    $event = Event::find($id);
    
    // Validación básica
    $request->validate([
        'fecha' => 'required|date',
    ]);

    try {
        $existingEvent = Event::where('date', $request->fecha)
            ->where('id', '!=', $id)
            ->where('status', '!=', 'Cancelado')
            ->first();

        if ($existingEvent) {
            return redirect()->back()->with('error', 'Ya existe un evento programado para esta fecha');
        }

        $pendingQuotes = Quote::where('date', $request->fecha)
            ->whereIn('status', ['pendiente'])
            ->count();

        if ($pendingQuotes > 0) {
            return redirect()->back()->with('error', 
                'No se puede cambiar la fecha porque hay cotizaciones pendientes para ese día');
        }

        $event->date = $request->fecha;
        $event->save();

        return redirect()->back()->with('success', 
            'La fecha del evento ha sido actualizada correctamente');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 
            'Error al actualizar la fecha del evento: ' . $e->getMessage());
    }
})->name('dashboard.event.edit.date');

Route::post('dashboard/event/{id}/edit/time', function ($id, Request $request) {
    $event = Event::find($id);
    
    // Validación básica
    $request->validate([
        'horaInicio' => 'required|date_format:h:i A',
        'duracion' => 'required|integer|min:1',
    ]);

    try {
        $startTime = Carbon::createFromFormat('h:i A', $request->horaInicio);
        $endTime = $startTime->copy()->addHours($request->duracion);

        $event->estimated_start_time = $startTime->format('H:i');
        $event->estimated_end_time = $endTime->format('H:i');
        $event->save();

        return redirect()->back()->with('success', 
            'El horario del evento ha sido actualizado correctamente');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 
            'Error al actualizar el horario del evento: ' . $e->getMessage());
    }
})->name('dashboard.event.edit.time');

require __DIR__.'/routesjesus.php';

