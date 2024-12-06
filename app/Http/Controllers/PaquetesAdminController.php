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
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|max:50',
            'description' => 'required|max:255',
            'max_people' => 'required|integer|min:30',
            'price' => 'required|numeric|min:1000|max:99999.99',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'services' => 'array',
            'services.*.id' => 'nullable|exists:services,id',
            'services.*.quantity' => 'nullable|integer|min:1',
            'services.*.price' => 'nullable|numeric',
            'services.*.description' => 'nullable|string|max:70',
            'image' => 'nullable|image|max:2048', // Validación de imagen
        ], [
            'place_id.required' => 'El lugar es obligatorio.',
            'place_id.exists' => 'El lugar seleccionado no es válido.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 50 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'description.max' => 'La descripción no puede tener más de 255 caracteres.',
            'max_people.required' => 'El número máximo de personas es obligatorio.',
            'max_people.integer' => 'El número máximo de personas debe ser un número entero.',
            'max_people.min' => 'El número máximo de personas debe ser al menos 30.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser al menos 1000.',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio no tiene un formato válido.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.date' => 'La fecha de finalización no tiene un formato válido.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
            'services.array' => 'El campo de servicios debe ser un arreglo.',
            'services.*.id.exists' => 'El servicio seleccionado no es válido.',
            'services.*.quantity.integer' => 'La cantidad debe ser un número entero.',
            'services.*.quantity.min' => 'La cantidad debe ser al menos 1.',
            'services.*.price.numeric' => 'El precio del servicio debe ser un número.',
            'services.*.description.string' => 'La descripción del servicio debe ser una cadena de texto.',
            'services.*.description.max' => 'La descripción del servicio no puede tener más de 70 caracteres.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.max' => 'La imagen no puede exceder 2MB.',
        ]);
    
        $package = new Package();
        $package->place_id = $request->place_id;
        $package->name = $request->name;
        $package->description = $request->description;
        $package->max_people = $request->max_people;
        $package->price = $request->price;
        $package->start_date = $request->start_date;
        $package->end_date = $request->end_date;
        $package->status = 'activo';
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $package->image_path = $imagePath;
        }
    
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