<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Place;
use App\Models\ServiceCategory;
use App\Models\Service;
use Illuminate\Http\Request;

class PaquetesAdminController extends Controller
{
    public function create()
    {
        $places = Place::all();
        $categories = ServiceCategory::with('services')->get();

        return view('crearpaquetesadmin', compact('places', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|max:50',
            'description' => 'required|max:255',
            'max_people' => 'required|integer',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'services' => 'array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'required|numeric',
            'services.*.description' => 'nullable|string|max:255',
            'services.*.details' => 'nullable|string|max:255',
        ]);
        
        // Crear el paquete
        $package = new Package();
        $package->place_id = $request->place_id;
        $package->name = $request->name;
        $package->description = $request->description;
        $package->max_people = $request->max_people;
        $package->price = $request->price;
        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->status = 'active';
        $package->save();
    
        // Relacionar los servicios con el paquete
        if ($request->has('services')) {
            foreach ($request->services as $serviceData) {
                // Verificar que los datos del servicio sean correctos
                if (isset($serviceData['id'], $serviceData['price'])) {
                    // Agregar los servicios al paquete
                    $package->services()->attach($serviceData['id'], [
                        'quantity' => $serviceData['quantity'] ?? 1, // Si no se pasa cantidad, usar 1 como valor por defecto
                        'price' => $serviceData['price'],
                        'description' => $serviceData['description'] ?? '',
                        'details_dj' => $serviceData['details'] ?? '',
                    ]);
                } else {
                    // Si algún dato está mal, podemos lanzar una excepción o mostrar un mensaje
                    return back()->withErrors('Faltan datos de servicios');
                }
            }
        }
        
        return redirect()->route('paquetes.index')->with('success', 'Paquete creado exitosamente');
    }
    
}
