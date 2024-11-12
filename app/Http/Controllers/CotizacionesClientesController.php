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
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'package_id' => 'nullable|exists:packages,id',
            'date' => 'required|date|after:today',
            'place_id' => 'required|exists:places,id',
            'status' => 'nullable|string|max:255',
            'estimated_price' => 'nullable|numeric|min:0',
            'espected_advance' => 'nullable|numeric|min:0',
            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:11:00',
                'before_or_equal:03:00',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'type_event' => 'required|string|max:255',
            'otro_tipo_evento' => 'required_if:type_event,Otro|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'guest_count' => 'required|integer|min:1',
        ], [
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
        ]);

        DB::beginTransaction();
        
        try {
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
                'owner_phone' => $request->input('owner_phone')
            ]);

            $services = $request->input('services', []);
            $servicesData = [];

            foreach ($services as $serviceId => $serviceData) {
                $servicesData[$serviceId] = [
                    'quantity' => $serviceData['quantity'],
                    'price' => $serviceData['price'],
                    'description' => $serviceData['description'],
                    'details_dj' => $serviceData['details_dj'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $quote->services()->sync($servicesData);

            DB::commit();

            return redirect()->route('cotizaciones.create')->with('success', 'Cotización y servicios creados exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cotizaciones.create')->with('error', 'Error al crear la cotización: ' . $e->getMessage());
        }
    }
}
