<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\SerialNumberType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function filterDataCategories(Request $request)
{
    $categories = explode(",", $request->query('categories'));


    $seriales = SerialNumberType::whereIn('category_id', function ($query) use ($categories) {
        $query->select('id')->from('inventory_categories')->whereIn('name', $categories);
    })->get(['id', 'code', 'name']); 


    $numberMax = Inventory::select('serial_number_type_id')
        ->selectRaw('MAX(number) + 1 as next_number')
        ->whereIn('serial_number_type_id', $seriales->pluck('id')) 
        ->groupBy('serial_number_type_id')
        ->get()
        ->pluck('next_number', 'serial_number_type_id'); 

    $seriales = $seriales->map(function ($serial) use ($numberMax) {
        return [
            'id' => $serial->id,
            'code' => $serial->code,
            'name' => $serial->name,
            'next_number' => $numberMax[$serial->id] ?? 1,
        ];
    });

    return response()->json($seriales);
    }

    public function addInventory(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|string|exists:serial_number_types_inventory,id', 
            'items.*.number' => 'required|integer|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.price' => 'required|integer',
        ]);
        
        foreach ($validated['items'] as $item) {
            $existingInventory = Inventory::where('number', $item['number'])->where('serial_number_type_id', $item['id'])->exists();
            $code = SerialNumberType::where('id', $item['id'])->value('name');
            if ($existingInventory) {
                return back()->with('error', 'Ese Numero ya esta registrado para ese codigo '.$code.'-'. $item['number']);
            }
        }

        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $item) {

                Inventory::create([
                    'serial_number_type_id' => $item['id'],
                    'number' => $item['number'],
                    'description' => $item['description'],
                    'price' =>  $item['price'],
                ]);
            }
        });

        return;
    }

    public function newCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|min:3|max:255|unique:inventory_categories,name',
            'codes' => 'required|array',
            'codes.*.code' => 'required|string|min:2|max:10|unique:serial_number_types_inventory,code',
            'codes.*.namecode' => 'required|string|min:3|max:255',
        ],[
            'category.unique' => 'La categoría escrita ya esta registrada.',
            'codes.*.code.unique' => 'El codigo que se ingreso ya se registro anteriormente'
        ]);


        DB::transaction(function () use ($validated) {
            $categoria = InventoryCategory::create([
                'name' => ucfirst($validated['category']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        
            foreach ($validated['codes'] as $code) {
                SerialNumberType::create([
                    'category_id' => $categoria->id, 
                    'code' => strtoupper($code['code']),
                    'name' => ucfirst($code['namecode']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        });

        return;
    }
    public function addNewCodeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|integer|exists:inventory_categories,id',
            'codeinf' => 'required|array',
            'codeinf.*.code' => 'required|string|min:2|max:10|unique:serial_number_types_inventory,code',
            'codeinf.*.namecode' => 'required|string|min:3|max:255',
        ],[
            'codeinf.*.code.unique' => 'El codigo que se ingreso ya se registro anteriormente',
            'category.exists' => 'La categoría seleccionada no esta registrada.',
        ]);


        DB::transaction(function () use ($validated) {
        
            foreach ($validated['codeinf'] as $code) {
                SerialNumberType::create([
                    'category_id' => $validated['category'], 
                    'code' => $code['code'],
                    'name' => $code['namecode'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        });

        return;
    }

}
