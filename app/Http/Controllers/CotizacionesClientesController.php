<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Quote;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Place;
use App\Models\Package;
use Carbon\Carbon;

class CotizacionesClientesController extends Controller
{
    public function create()
    {
        $categories = ServiceCategory::all();
        $places = Place::all();
        $today = Carbon::today();

        // Filtrar los paquetes vigentes
        $packages = Package::with('place', 'services')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        $services = Service::all()->keyBy('id');
        $user = auth()->user(); // Obtener el usuario autenticado

        return view('cotizacionesclientes', [
            'categories' => $categories,
            'places' => $places,
            'packages' => $packages,
            'services' => $services,
            'user' => $user, // Pasar el usuario a la vista
        ]);
    }
    
    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);
    
        if ($request->has('otro_tipo_evento') && !empty($request->input('otro_tipo_evento'))) {
            $request->merge(['type_event' => (string) $request->input('otro_tipo_evento')]);
        } else {
            $request->merge(['type_event' => (string) $request->input('type_event')]);
        }
    
        // Obtener el usuario autenticado
        $user = auth()->user();
        $person = $user->person;
    
        // Validar los datos
        $validated = $request->validate(
            [
                'user_id' => 'nullable|exists:users,id',
                'package_id' => 'nullable|exists:packages,id',
                'date' => 'required|date|after:today|before_or_equal:' . now()->addMonth()->toDateString(),
                'place_id' => 'required|exists:places,id',
                'status' => 'nullable|string|max:255',
                'estimated_price' => 'nullable|numeric|min:0',
                'espected_advance' => 'nullable|numeric|min:0',
                'start_time' => 'required|date_format:Y-m-d H:i',
                'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
                'type_event' => 'required|string|max:50',
                'otro_tipo_evento' => 'nullable|string|max:50',
                'guest_count' => 'required|integer|min:10|max:100',
            ],
            [
                'user_id.exists' => 'El usuario seleccionado no existe.',
                'package_id.exists' => 'El paquete seleccionado no existe.',
                'date.required' => 'El campo fecha es obligatorio.',
                'date.date' => 'La fecha debe tener un formato válido.',
                'date.after' => 'La fecha debe ser posterior al día de hoy.',
                'date.before_or_equal' => 'La fecha no puede ser mayor a un mes a partir de hoy.',
                'place_id.required' => 'El lugar es obligatorio.',
                'place_id.exists' => 'El lugar seleccionado no existe.',
                'status.string' => 'El estado debe ser un texto.',
                'status.max' => 'El estado no puede tener más de 255 caracteres.',
                'estimated_price.numeric' => 'El precio estimado debe ser un número.',
                'estimated_price.min' => 'El precio estimado no puede ser menor a 0.',
                'espected_advance.numeric' => 'El anticipo esperado debe ser un número.',
                'espected_advance.min' => 'El anticipo esperado no puede ser menor a 0.',
                'start_time.required' => 'La hora de inicio es obligatoria.',
                'start_time.date_format' => 'La hora de inicio debe tener el formato: Año-Mes-Día Hora:Minuto.',
                'end_time.required' => 'La hora de finalización es obligatoria.',
                'end_time.date_format' => 'La hora de finalización debe tener el formato: Año-Mes-Día Hora:Minuto.',
                'end_time.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
                'type_event.required' => 'El tipo de evento es obligatorio.',
                'type_event.string' => 'El tipo de evento debe ser un texto.',
                'type_event.max' => 'El tipo de evento no puede tener más de 50 caracteres.',
                'otro_tipo_evento.string' => 'El campo "otro tipo de evento" debe ser un texto.',
                'otro_tipo_evento.max' => 'El campo "otro tipo de evento" no puede tener más de 50 caracteres.',
                'guest_count.required' => 'La cantidad de invitados es obligatoria.',
                'guest_count.integer' => 'La cantidad de invitados debe ser un número entero.',
                'guest_count.min' => 'La cantidad de invitados no puede ser menor a 10.',
                'guest_count.max' => 'La cantidad de invitados no puede ser mayor a 80.',
            ]
        );
    
        $startTime = \Carbon\Carbon::parse($request->input('start_time'));
        $endTime = \Carbon\Carbon::parse($request->input('end_time'));
        $hoursDifference = $startTime->diffInHours($endTime);
    
        if ($hoursDifference < 4) {
            return redirect()->back()->withErrors([
                'end_time' => 'La duración mínima de la cotización debe ser de al menos 4 horas.',
            ])->withInput();
        }
    
        $dateOnly = \Carbon\Carbon::parse($request->input('date'))->toDateString();
        $startTimeDateOnly = $startTime->toDateString();
    
        if ($dateOnly !== $startTimeDateOnly) {
            return redirect()->back()->withErrors([
                'date' => 'El día en la fecha de inicio debe coincidir con el campo de fecha.',
            ])->withInput();
        }
    
        $startLimit = \Carbon\Carbon::parse($dateOnly . ' 12:00:00');
        $endLimit = \Carbon\Carbon::parse($dateOnly . ' 03:00:00')->addDay();
    
        if ($startTime->lt($startLimit)) {
            return redirect()->back()->withErrors([
                'start_time' => 'La hora de inicio no puede ser antes de las 12:00 pm.',
            ])->withInput();
        }
    
        if ($endTime->gt($endLimit)) {
            return redirect()->back()->withErrors([
                'end_time' => 'La hora de finalización no puede ser después de las 03:00 am del día siguiente.',
            ])->withInput();
        }
    
        DB::beginTransaction();
    
        try {
            $quote = Quote::create([
                'user_id' => $request->input('user_id'),
                'package_id' => $request->input('package_id'),
                'date' => $request->input('date'),
                'place_id' => $request->input('place_id'),
                'status' => $request->input('status', 'pendiente cotizacion'),
                'estimated_price' => $request->input('estimated_price', '0'),
                'espected_advance' => $request->input('espected_advance', '0'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'type_event' => $request->input('type_event'),
                'otro_tipo_evento' => $request->input('otro_tipo_evento'),
                'owner_name' => $person->first_name . ' ' . $person->last_name,
                'owner_phone' => $person->phone,
                'guest_count' => $request->input('guest_count'),
            ]);
    
            if (!$request->input('package_id')) {
                $services = $request->input('services', []);
                $servicesData = [];
    
                foreach ($services as $serviceId => $serviceData) {
                    if (isset($serviceData['confirmed']) && filter_var($serviceData['confirmed'], FILTER_VALIDATE_BOOLEAN)) {
                        $quantity = $serviceData['quantity'];
                        if (!empty($quantity) && is_numeric($quantity) && $quantity > 0) {
                            $servicesData[$serviceId] = [
                                'quantity' => $quantity,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
    
                if (!empty($servicesData)) {
                    $quote->services()->sync($servicesData);
                }
            }
    
            DB::commit();
    
            return redirect()->route('cotizaciones.create')->with('success', 'Cotización enviada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['general' => 'Error al crear la cotización. Por favor, revisa los datos e inténtalo de nuevo.'])
                ->withInput();
        }
    }

    public function storeQuote(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);
    
        if ($request->has('other_event_type') && !empty($request->input('other_event_type'))) {
            $request->merge(['type_event' => (string) $request->input('other_event_type')]);
        } else {
            $request->merge(['type_event' => (string) $request->input('type_event')]);
        }
    
        try {
            $place = Place::findOrFail($request->input('place_id'));
            if ($request->input('guest_count') > $place->max_guest) {
                return redirect()
                    ->route('cotizaciones.nueva')
                    ->withErrors([
                        'guest_count' => "El número de invitados excede la capacidad máxima del lugar seleccionado ({$place->max_guest} personas)."
                    ])
                    ->withInput();
            }
    
            // Validaciones
            $validated = $request->validate([
                'date' => 'required|date|after:today',
                'start_time' => 'required|date_format:Y-m-d H:i',
                'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
                'place_id' => 'required|exists:places,id',
                'type_event' => 'required|string|max:50',
                'guest_count' => 'required|integer|min:10|max:80',
                'services' => 'nullable|array',
            ], [
                'date.required' => 'La fecha es obligatoria',
                'date.after' => 'La fecha debe ser posterior a hoy',
                'start_time.required' => 'La hora de inicio es obligatoria',
                'start_time.date_format' => 'Formato de hora inválido',
                'end_time.required' => 'La hora de fin es obligatoria',
                'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio',
                'place_id.required' => 'Debe seleccionar un lugar',
                'place_id.exists' => 'El lugar seleccionado no es válido',
                'type_event.required' => 'El tipo de evento es obligatorio',
                'guest_count.required' => 'El número de invitados es obligatorio',
                'guest_count.min' => 'Mínimo 10 invitados',
                'guest_count.max' => 'Máximo 80 invitados'
            ]);
    
            $date = $request->input('date');
            $existingQuotes = Quote::where('date', $date)
                ->whereIn('status', ['pendiente cotizacion', 'pendiente', 'pagada'])
                ->get();
    
            $hasPaidQuote = $existingQuotes->contains('status', 'pagada');
            $pendingCount = $existingQuotes->whereIn('status', ['pendiente cotizacion', 'pendiente'])->count();
    
            if ($hasPaidQuote || $pendingCount >= 3) {
                return redirect()
                    ->route('cotizaciones.nueva')
                    ->withErrors(['date' => 'Por el momento, no se puede cotizar para esta fecha.'])
                    ->withInput();
            }
    
            $currentDate = Carbon::now();
            $maxDate = $currentDate->copy()->addMonths(2)->endOfMonth();
            if (Carbon::parse($date)->gt($maxDate)) {
                return redirect()
                    ->route('cotizaciones.nueva')
                    ->withErrors(['date' => 'Las cotizaciones solo se pueden hacer para el mes actual y los dos meses siguientes.'])
                    ->withInput();
            }
    
            $user = auth()->user();
            $blockedDates = Quote::where('user_id', $user->id)
                ->whereIn('status', ['pendiente cotizacion', 'pendiente'])
                ->pluck('date')
                ->toArray();
    
            if (in_array($date, $blockedDates)) {
                return redirect()
                    ->route('cotizaciones.nueva')
                    ->withErrors(['date' => 'Ya tienes una cotización pendiente para esta fecha.'])
                    ->withInput();
            }
    
            DB::beginTransaction();
    
            $quote = Quote::create([
                'user_id' => auth()->id(),
                'date' => $validated['date'],
                'place_id' => $validated['place_id'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'type_event' => $validated['type_event'],
                'guest_count' => $validated['guest_count'],
                'status' => 'pendiente cotizacion',
            ]);
    
            $servicesData = [];
            foreach ($request->input('services', []) as $serviceId => $serviceData) {
                if (isset($serviceData['confirmed']) && filter_var($serviceData['confirmed'], FILTER_VALIDATE_BOOLEAN)) {
                    $servicesData[$serviceId] = [
                        'description' => $serviceData['description'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
    
            if (!empty($servicesData)) {
                $quote->services()->sync($servicesData);
            }
    
            DB::commit();
    
            return redirect()
                ->route('historialclientes')
                ->with('success', 'Cotización enviada exitosamente.');
    
        } catch (ValidationException $e) {
            return redirect()
                ->route('cotizaciones.nueva')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('cotizaciones.nueva')
                ->withErrors(['error' => 'Error al crear la cotización: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function storeQuoteAdmin(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);
    
        if ($request->has('other_event_type') && !empty($request->input('other_event_type'))) {
            $request->merge(['type_event' => (string) $request->input('other_event_type')]);
        } else {
            $request->merge(['type_event' => (string) $request->input('type_event')]);
        }
        
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'date' => 'required|date|after:today',
            'place_id' => 'required|exists:places,id',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time' => 'required|date_format:Y-m-d H:i',
            'type_event' => 'required|string|max:50',
            'guest_count' => 'required|integer|min:10|max:80',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'services.*.description' => 'nullable|string|max:255',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.coast' => 'nullable|numeric|min:0',
            'services.*.price' => 'nullable|numeric|min:0',
        ]);
    
        $date = $request->input('date');
        $existingQuotes = Quote::where('date', $date)
            ->whereIn('status', ['pendiente cotizacion', 'pendiente', 'pagada'])
            ->get();
    
        $hasPaidQuote = $existingQuotes->contains('status', 'pagada');
        $pendingCount = $existingQuotes->whereIn('status', ['pendiente cotizacion', 'pendiente'])->count();
    
        if ($hasPaidQuote || $pendingCount >= 3) {
            return redirect()->route('cotizaciones.nuevaAdmin')
                ->withErrors(['date' => 'Por el momento, no se puede cotizar por esta fecha.'])
                ->withInput();
        }
    
        // Validar que la fecha esté dentro del rango permitido
        $currentDate = Carbon::now();
        $maxDate = $currentDate->copy()->addMonths(2)->endOfMonth();
        if (Carbon::parse($date)->gt($maxDate)) {
            return redirect()
                ->route('cotizaciones.nuevaAdmin')
                ->withErrors(['date' => 'Las cotizaciones solo se pueden hacer para el mes actual y los dos meses siguientes.'])
                ->withInput();
        }
    
        DB::beginTransaction();
    
        try {
            $quote = Quote::create([
                'user_id' => $request->input('user_id'),
                'date' => $request->input('date'),
                'place_id' => $request->input('place_id'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'type_event' => $request->input('type_event'),
                'guest_count' => $request->input('guest_count'),
                'status' => 'pendiente',
                'owner_name' => $request->input('owner_name'),
                'owner_phone' => $request->input('owner_phone'),
            ]);
    
            $servicesData = [];
            foreach ($request->input('services', []) as $serviceId => $serviceData) {
                if (isset($serviceData['confirmed']) && filter_var($serviceData['confirmed'], FILTER_VALIDATE_BOOLEAN)) {
                    $servicesData[$serviceId] = [
                        'description' => $serviceData['description'],
                        'quantity' => $serviceData['quantity'] ?? 1,
                        'coast' => $serviceData['coast'] ?? 0,
                        'price' => $serviceData['price'] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
    
            if (!empty($servicesData)) {
                $quote->services()->sync($servicesData);
            }
    
            DB::commit();
    
            return redirect()->route('cotizaciones.nuevaAdmin')->with('success', 'Cotización enviada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cotizaciones.nuevaAdmin')->withErrors(['store_quote_error' => 'Error al crear la cotización: ' . $e->getMessage()])->withInput();
        }
    }

    public function historial()
    {
        $quotes = Quote::with('place')
                       ->where('user_id', auth()->id())
                       ->paginate(10);
    
        return view('historial', ['quotes' => $quotes]);
    }

    public function historialClientes()
    {
        $quotes = Quote::with(['place', 'services.serviceCategory'])
                       ->where('user_id', auth()->id())
                       ->paginate(10);
    
        return view('historialclientes', ['quotes' => $quotes]);
    }

    public function getCotizations(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = \Carbon\Carbon::parse($startDate)->addMonths(2)->endOfMonth()->toDateString();
    
        $cotizations = Quote::select(DB::raw('date, COUNT(*) as count, MAX(status) as status'))
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->get();
    
        return response()->json($cotizations);
    }

    public function nuevaCotizacion()
    {
        $places = Place::all();
        $today = Carbon::today();
        $categories = ServiceCategory::all();
        $services = Service::all();
        $quotes = Quote::whereIn('status', ['pendiente cotizacion', 'pendiente', 'pagada'])->get();
        $user = auth()->user();
    
        $cotizations = Quote::select(DB::raw('date, COUNT(*) as count, MAX(status) as status'))
            ->whereBetween('date', [$today->startOfMonth(), $today->copy()->addMonths(2)->endOfMonth()])
            ->groupBy('date')
            ->get();
    
        $blockedDates = Quote::where('user_id', $user->id)
            ->whereIn('status', ['pendiente cotizacion', 'pendiente'])
            ->pluck('date')
            ->toArray();
    
        return view('cotizacionesnuevasclientes', [
            'places' => $places,
            'cotizations' => $cotizations,
            'categories' => $categories,
            'services' => $services,
            'user' => $user,
            'quotes' => $quotes,
            'blockedDates' => $blockedDates,
        ]);
    }

    public function nuevaCotizacionAdmin()
    {
        $places = Place::all();
        $today = Carbon::today();
        $categories = ServiceCategory::all();
        $services = Service::all();
        $quotes = Quote::whereIn('status', ['pendiente cotizacion', 'pendiente', 'pagada'])->get();
        $user = auth()->user();
    
        $cotizations = Quote::select(DB::raw('date, COUNT(*) as count, MAX(status) as status'))
            ->whereBetween('date', [$today->startOfMonth(), $today->copy()->addMonths(2)->endOfMonth()])
            ->groupBy('date')
            ->get();
    
        return view('cotizacionesadmin', [
            'places' => $places,
            'cotizations' => $cotizations,
            'categories' => $categories,
            'services' => $services,
            'user' => $user,
            'quotes' => $quotes,
        ]);
    }
}
