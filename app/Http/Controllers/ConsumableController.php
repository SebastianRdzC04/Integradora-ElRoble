<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\ConsumableCategory;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    public function create()
    {
        $categories = ConsumableCategory::all();

        return view('pages.inventory.consumable_create',compact('categories'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:50',
            'stock' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->maximum_stock) {
                        $fail('El stock inicial no puede ser mayor al stock máximo.');
                    }
                }
            ],
            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->maximum_stock) {
                        $fail('El stock mínimo no puede ser mayor al stock máximo.');
                    }
                }
            ],
            'maximum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:10',
            'category_id' => 'required|exists:consumable_categories,id',
            'description' => 'nullable|string|max:100',
        ]);
    
        $consumable = new Consumable();
        $consumable->name = $request->input('name');
        $consumable->stock = $request->input('stock');
        $consumable->minimum_stock = $request->input('minimum_stock');
        $consumable->maximum_stock = $request->input('maximum_stock');
        $consumable->unit = $request->input('unit');
        $consumable->category_id = $request->input('category_id');
        $consumable->description = $request->input('description');
    
        $consumable->save();
    
        return redirect()->route('consumables.create')->with('success', 'Consumible agregado correctamente.');
    }
    
}
