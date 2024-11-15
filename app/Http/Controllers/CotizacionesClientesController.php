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
        $packages = Package::all();
    
        return view('cotizacionesclientes', [
            'categories' => $categories,
            'places' => $places,
            'packages' => $packages
        ]);
    }
    
    public function store(Request $request)
    {

        try{
            $request->merge(['type_event' => (string) $request->input('type_event')]);
        // Validación de los campos obligatorios (sin incluir los servicios)
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'package_id' => 'nullable|exists:packages,id',
            'date' => 'required|date|after:today',
            'place_id' => 'required|exists:places,id',
            'status' => 'nullable|string|max:255',
            'estimated_price' => 'nullable|numeric|min:0',
            'espected_advance' => 'nullable|numeric|min:0',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
            'type_event' => 'required|string|max:255',
            'otro_tipo_evento' => 'nullable|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'guest_count' => 'required|integer|min:1',
        ], [
            // Mensajes de error personalizados
            'place_id.required' => 'El campo de lugar es obligatorio.',
            'place_id.exists' => 'El lugar seleccionado no es válido.',
            'status.string' => 'El estado debe ser una cadena de texto.',
            'status.max' => 'El estado no puede exceder los 255 caracteres.',
            'estimated_price.numeric' => 'El precio estimado debe ser un número.',
            'estimated_price.min' => 'El precio estimado no puede ser menor a 0.',
            'espected_advance.numeric' => 'El adelanto esperado debe ser un número.',
            'espected_advance.min' => 'El adelanto esperado no puede ser menor a 0.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'start_time.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'start_time.after_or_equal' => 'La hora de inicio debe ser a partir de las 11:00.',
            'start_time.before_or_equal' => 'La hora de inicio debe ser antes de las 03:00.',
            'end_time.required' => 'La hora de finalización es obligatoria.',
            'end_time.date_format' => 'La hora de finalización debe tener el formato HH:MM.',
            'end_time.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'type_event.required' => 'El tipo de evento es obligatorio.',
            'type_event.string' => 'El tipo de evento debe ser una cadena de texto.',
            'type_event.max' => 'El tipo de evento no puede exceder los 255 caracteres.',
            'otro_tipo_evento.required_if' => 'Debe especificar el tipo de evento si selecciona "Otro".',
            'otro_tipo_evento.string' => 'El tipo de evento debe ser una cadena de texto.',
            'otro_tipo_evento.max' => 'El tipo de evento no puede exceder los 255 caracteres.',
            'owner_name.required' => 'El nombre del propietario es obligatorio.',
            'owner_name.string' => 'El nombre del propietario debe ser una cadena de texto.',
            'owner_name.max' => 'El nombre del propietario no puede exceder los 255 caracteres.',
            'owner_phone.required' => 'El teléfono del propietario es obligatorio.',
            'owner_phone.string' => 'El teléfono del propietario debe ser una cadena de texto.',
            'owner_phone.max' => 'El teléfono del propietario no puede exceder los 20 caracteres.',
            'guest_count.required' => 'La cantidad de invitados es obligatoria.',
            'guest_count.integer' => 'La cantidad de invitados debe ser un número entero.',
            'guest_count.min' => 'La cantidad de invitados debe ser al menos 1.',
            'date.required' => 'El campo de fecha es obligatorio.',
            'date.date' => 'El campo de fecha debe ser una fecha válida.',
            'date.after' => 'La fecha debe ser posterior a hoy.',
        ]);

        
    } catch (\Exception $e) {
        dd("Error en la validación: " . $e->getMessage());
    }

        // Validación personalizada para asegurar que el día de `date` coincida con el día de `start_time`
        $dateOnly = \Carbon\Carbon::parse($request->input('date'))->toDateString();
        $startTime = \Carbon\Carbon::parse($request->input('start_time'));
        $startTimeDateOnly = $startTime->toDateString();
        
        if ($dateOnly !== $startTimeDateOnly) {
            return redirect()->back()->withErrors([
                'date' => 'El día en la fecha de inicio debe coincidir con el campo de fecha.',
            ])->withInput();
        }
    
        // Validación de que `start_time` no sea antes de las 12:00 pm y `end_time` no sea después de las 03:00 am del día siguiente
        $startLimit = \Carbon\Carbon::parse($dateOnly . ' 12:00:00');
        $endLimit = \Carbon\Carbon::parse($dateOnly . ' 03:00:00')->addDay();
    
        $endTime = \Carbon\Carbon::parse($request->input('end_time'));
    
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

        // Comienza la transacción
        DB::beginTransaction();
    
        try {
            // Crear la cotización
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
    
            // Obtener los servicios seleccionados (si existen)
            $services = $request->input('services', []);
    
            // Solo procesar los servicios si hay alguno seleccionado
            if (!empty($services)) {
                $servicesData = [];
    
                foreach ($services as $serviceId => $serviceData) {
                    $servicesData[$serviceId] = [
                        'quantity' => $serviceData['quantity'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
    
                // Sincronizar los servicios seleccionados con la cotización
                $quote->services()->sync($servicesData);
            }
    
            // Confirmar transacción
            DB::commit();
    
            return redirect()->route('cotizaciones.create')->with('success', 'Cotización y servicios creados exitosamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();
            return redirect()->route('cotizaciones.create')->with('error', 'Error al crear la cotización: ' . $e->getMessage());
        }
    }    
    
}
