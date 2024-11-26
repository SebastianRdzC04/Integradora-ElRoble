<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Quote;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Place;
use App\Models\Package;

class CotizacionesClientesController extends Controller
{
    public function create()
    {
        $categories = ServiceCategory::all();
        $places = Place::all();
        $packages = Package::with('place', 'services')->get();
        $services = Service::all()->keyBy('id');
    
        return view('cotizacionesclientes', [
            'categories' => $categories,
            'places' => $places,
            'packages' => $packages,
            'services' => $services,
        ]);
    }
    
    public function store(Request $request)
    {
        // Si se proporciona 'otro_tipo_evento', se usa como 'type_event'
        if ($request->has('otro_tipo_evento') && !empty($request->input('otro_tipo_evento'))) {
            $request->merge(['type_event' => (string) $request->input('otro_tipo_evento')]);
        } else {
            $request->merge(['type_event' => (string) $request->input('type_event')]);
        }
    
        // Validación de los datos del formulario
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
                'owner_name' => 'required|string|max:40',
                'owner_phone' => 'required|string|max:10',
                'guest_count' => 'required|integer|min:10|max:80',
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
                'owner_name.required' => 'El nombre del propietario es obligatorio.',
                'owner_name.string' => 'El nombre del propietario debe ser un texto.',
                'owner_name.max' => 'El nombre del propietario no puede tener más de 40 caracteres.',
                'owner_phone.required' => 'El teléfono del propietario es obligatorio.',
                'owner_phone.string' => 'El teléfono del propietario debe ser un texto.',
                'owner_phone.max' => 'El teléfono del propietario no puede tener más de 10 caracteres.',
                'guest_count.required' => 'La cantidad de invitados es obligatoria.',
                'guest_count.integer' => 'La cantidad de invitados debe ser un número entero.',
                'guest_count.min' => 'La cantidad de invitados no puede ser menor a 10.',
                'guest_count.max' => 'La cantidad de invitados no puede ser mayor a 80.',
            ]
        );
    
        // Validaciones adicionales
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
            // Creación de la cotización
            $quote = Quote::create([
                'user_id' => $request->input('user_id'),
                'package_id' => $request->input('package_id'),
                'date' => $request->input('date'),
                'place_id' => $request->input('place_id'),
                'status' => $request->input('status', 'pendiente'),
                'estimated_price' => $request->input('estimated_price'),
                'espected_advance' => $request->input('espected_advance'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'type_event' => $request->input('type_event'),
                'otro_tipo_evento' => $request->input('otro_tipo_evento', null),
                'owner_name' => $request->input('owner_name'),
                'owner_phone' => $request->input('owner_phone'),
                'guest_count' => $request->input('guest_count'),
            ]);
    
            // Manejo de servicios
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
    
            DB::commit();
    
            return redirect()->route('cotizaciones.create')->with('success', 'Cotización y servicios creados exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['general' => 'Error al crear la cotización. Por favor, revisa los datos e inténtalo de nuevo.'])
                ->withInput();
        }
    }
}
