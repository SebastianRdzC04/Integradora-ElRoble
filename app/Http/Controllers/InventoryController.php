<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\SerialNumberType;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    //
    public function filterDataCategories(Request $request)
{
    $categories = explode(",", $request->query('categories'));

    // Obtiene los seriales con sus códigos y nombres
    $seriales = SerialNumberType::whereIn('category_id', function ($query) use ($categories) {
        $query->select('id')->from('inventory_categories')->whereIn('name', $categories);
    })->get(['id', 'code', 'name']); // Incluye 'id' para hacer la relación con inventory

    // Obtiene el número máximo + 1 por cada serial_number_type_id
    $numberMax = Inventory::select('serial_number_type_id')
        ->selectRaw('MAX(number) + 1 as next_number')
        ->whereIn('serial_number_type_id', $seriales->pluck('id')) // Relaciona con los seriales filtrados
        ->groupBy('serial_number_type_id')
        ->get()
        ->pluck('next_number', 'serial_number_type_id'); // Convierte a un arreglo asociativo

    // Asocia los números calculados con los seriales
    $seriales = $seriales->map(function ($serial) use ($numberMax) {
        return [
            'id' => $serial->id,
            'code' => $serial->code,
            'name' => $serial->name,
            'next_number' => $numberMax[$serial->id] ?? 1, // Si no hay registros en inventory, comienza en 1
        ];
    });

    return response()->json($seriales);
}

public function addInventory(Request $request)
{
    // Validar los datos de la solicitud
    $validated = $request->validate([
        'items' => 'required|array',
        'items.*.id' => 'required|string|exists:serial_number_types_inventory,id', // Cambiar 'serial' a 'code'
        'items.*.number' => 'required|integer|min:1',
        'items.*.description' => 'required|string|max:255',
        'items.*.price' => 'required|integer',
    ]);
    

    // Si la validación pasa, puedes procesar los datos.
    // Por ejemplo, puedes agregar estos datos a la base de datos.

    // Recorrer los ítems validados y hacer lo que sea necesario
    DB::transaction(function () use ($validated) {
        foreach ($validated['items'] as $item) {
            // Aquí procesas cada ítem (puedes almacenarlos en la base de datos, por ejemplo)
            // Por ejemplo, agregar un nuevo inventario:
            Inventory::create([
                'serial_number_type_id' => $item['id'],
                'number' => $item['number'],
                'description' => $item['description'],
                'price' =>  $item['price'],
            ]);
        }
    });

    // Responder con éxito
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
        'category.unique' => 'La categoría seleccionada ya esta registrada.',
        'codes.*.code.unique' => 'El codigo que se ingreso ya se registro anteriormente'
    ]);


    DB::transaction(function () use ($validated) {
        // Crear la categoría principal
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
