<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiciosAdminController extends Controller
{
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('crearserviciosadmin', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'new_category' => 'nullable|string|required_if:category,Otro',
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'price_estimate' => 'required|numeric|min:0|max:99999.99',
            'quantity' => 'integer|min:0',
            'image' => 'nullable|image|max:1024',
            'quantifiable' => 'boolean',
        ], [
            'category.required' => 'El campo categoría es obligatorio.',
            'new_category.required_if' => 'El campo nueva categoría es obligatorio si seleccionas "Otro".',
            'name.required' => 'El nombre del servicio es obligatorio.',
            'name.max' => 'El nombre del servicio no puede exceder 50 caracteres.',
            'description.required' => 'La descripción del servicio es obligatoria.',
            'description.max' => 'La descripción no puede exceder 255 caracteres.',
            'price_estimate.required' => 'El precio estimado es obligatorio.',
            'price_estimate.numeric' => 'El precio estimado debe ser un número.',
            'price_estimate.min' => 'El precio más bajo es 0, es decir gratuito.',
            'price_estimate.max' => 'El precio no puede exceder 99999.99.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad debe ser al menos 1.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.max' => 'La imagen no puede exceder 1MB.',
            'quantifiable.boolean' => 'El campo cuantificable debe ser verdadero o falso.',
        ]);
    
        if ($validated['category'] === 'Otro' && empty($validated['new_category'])) {
            return back()->withErrors(['new_category' => 'El campo no puede dejarse nulo.'])->withInput();
        }
    
        if ($validated['category'] === 'Otro') {
            $category = ServiceCategory::firstOrCreate(['name' => $validated['new_category']]);
            $categoryId = $category->id;
        } else {
            $category = ServiceCategory::where('name', $validated['category'])->first();
            $categoryId = $category ? $category->id : null;
    
            if (!$categoryId) {
                return back()->withErrors(['category' => 'Categoría no encontrada.'])->withInput();
            }
        }
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
    
        Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'service_category_id' => $categoryId,
            'price' => $validated['price_estimate'],
            'quantity' => $validated['quantity'],
            'image_path' => $imagePath,
            'quantifiable' => $request->has('quantifiable'),
        ]);
    
        return redirect()->route('crearservicios')->with('success', 'El servicio ha sido creado con éxito.');
    }
}
