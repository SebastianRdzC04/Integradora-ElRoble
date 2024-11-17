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
        try {
            $request->merge(['type_event' => (string) $request->input('type_event')]);
    
            // Validación de los campos obligatorios
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
                'guest_count' => 'required|integer|min:10',
            ]);
    
            // Validación personalizada para asegurar que la fecha coincida con el día de `start_time`
            $dateOnly = \Carbon\Carbon::parse($request->input('date'))->toDateString();
            $startTime = \Carbon\Carbon::parse($request->input('start_time'));
            $startTimeDateOnly = $startTime->toDateString();
    
            if ($dateOnly !== $startTimeDateOnly) {
                return redirect()->back()->withErrors([
                    'date' => 'El día en la fecha de inicio debe coincidir con el campo de fecha.',
                ])->withInput();
            }
    
            // Validación de horarios
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
    
            // Procesar los servicios confirmados
            $services = $request->input('services', []);
    
            // Solo incluir los servicios que están confirmados y tienen descripción
            $servicesData = [];
    
            foreach ($services as $serviceId => $serviceData) {
                if (isset($serviceData['confirmed']) && filter_var($serviceData['confirmed'], FILTER_VALIDATE_BOOLEAN)) {
                    // Asegurarse de que la descripción no sea null o vacía
                    $description = $serviceData['description'];
                    if (!empty($description)) {
                        $servicesData[$serviceId] = [
                            'description' => $description,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
    
            // Sincronizar solo los servicios con descripción no vacía
            if (!empty($servicesData)) {
                // Sincronizar los servicios con la cotización
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
