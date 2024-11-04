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
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|max:50',
            'description' => 'required|max:60',
            'max_people' => 'required|integer',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'services' => 'array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'required|numeric',
        ]);
    
        $package = new Package();
        $package->place_id = $request->place_id;
        $package->name = $request->name;
        $package->description = $request->description;
        $package->max_people = $request->max_people;
        $package->price = $request->price;
        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->save();
    
        foreach ($request->services as $serviceData) {
            $package->services()->attach($serviceData['id'], [
                'quantity' => $serviceData['quantity'],
                'price' => $serviceData['price'],
                'description' => $serviceData['description'],
                'details' => $serviceData['details']
            ]);
        }
    
        return redirect()->route('paquetes.index')->with('success', 'Paquete creado exitosamente');
    }
    
}
