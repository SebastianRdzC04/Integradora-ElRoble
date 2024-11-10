<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Place;
use App\Models\ServiceCategory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Validación de los datos del paquete
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|max:50',
            'description' => 'required|max:255',
            'max_people' => 'required|integer',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'services' => 'array',
            'services.*.id' => 'nullable|exists:services,id',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'nullable|numeric',
            'services.*.description' => 'nullable|string|max:255',
        ]);
    
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
    
        $confirmedServices = collect($request->input('services', []))->filter(function($service) {
            return isset($service['id']) && isset($service['quantity']) && isset($service['price']) && isset($service['description']);
        });
    
        foreach ($confirmedServices as $serviceData) {
            $package->services()->attach($serviceData['id'], [
                'quantity' => $serviceData['quantity'] ?? 1,
                'price' => $serviceData['price'],
                'description' => $serviceData['description'] ?? '',
            ]);
        }
    
        return redirect()->route('crearpaquetes')->with('success', 'Paquete creado exitosamente');
    }    
}