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
        // Obtener todos los lugares y servicios para mostrarlos en el formulario
        $places = Place::all();
        $categories = ServiceCategory::with('services')->get();
        
        return view('crearpaquetesadmin', compact('places', 'categories'));
    }
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'max_people' => 'required|integer',
            'price' => 'required|integer',
            'services' => 'nullable|array',
            'services.*.id' => 'exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'services.*.price' => 'required|numeric',
            'services.*.description' => 'nullable|string|max:255',
            'services.*.details_dj' => 'nullable|string',
        ]);

        // Crear el paquete
        $package = Package::create([
            'place_id' => $request->place_id,
            'name' => $request->name,
            'description' => $request->description,
            'max_people' => $request->max_people,
            'price' => $request->price,
        ]);

        // Asociar servicios con el paquete
        if ($request->has('services')) {
            foreach ($request->services as $serviceData) {
                $package->services()->attach($serviceData['id'], [
                    'quantity' => $serviceData['quantity'],
                    'price' => $serviceData['price'],
                    'description' => $serviceData['description'],
                    'details_dj' => $serviceData['details_dj'],
                ]);
            }
        }

        return redirect()->route('paquetes.create')->with('success', 'Paquete creado con éxito.');
    }
}