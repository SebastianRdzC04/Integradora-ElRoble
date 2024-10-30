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
        ], [
            'place_id.required' => 'El lugar es obligatorio.',
            'place_id.exists' => 'El lugar seleccionado no es válido.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 50 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede exceder los 255 caracteres.',
            'max_people.required' => 'El número máximo de personas es obligatorio.',
            'max_people.integer' => 'El número máximo de personas debe ser un número entero.',
            'price.required' => 'El precio es obligatorio.',
            'price.integer' => 'El precio debe ser un número entero.',
            'services.array' => 'Los servicios deben ser un arreglo.',
            'services.*.id.exists' => 'El servicio seleccionado no es válido.',
            'services.*.quantity.required' => 'La cantidad es obligatoria.',
            'services.*.quantity.integer' => 'La cantidad debe ser un número entero.',
            'services.*.quantity.min' => 'La cantidad debe ser al menos 1.',
            'services.*.price.required' => 'El precio del servicio es obligatorio.',
            'services.*.price.numeric' => 'El precio del servicio debe ser un número.',
            'services.*.description.max' => 'La descripción del servicio no puede exceder los 255 caracteres.',
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
