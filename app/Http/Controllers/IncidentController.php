<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Incident;
use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Models\SerialNumberType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncidentController extends Controller
{
    public function create()
    {
        $sn = DB::table('serial_number_types_inventory')
                ->select('id', 'code', 'name', 'category_id')
                ->get();
    
        $categories = DB::table('inventory_categories')
                        ->select('id', 'name')
                        ->get();
    
        return view('pages.people.employee.report_incidents', compact('sn', 'categories'));
    }

    public function store(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Validaciones mínimas en el backend
        $request->validate([
            'title' => 'string|max:100',
            'description' => 'string|max:100',
        ]);

        $validatedData = $request->validate([
            'serial.*' => 'required|string|max:10', // Valida cada elemento del array 'serial[]'
            'detailsy.*' => 'required|string|max:255', // Valida cada elemento del array 'detailsy[]'
            'status.*' => 'required|in:disponible,no disponible', // Valida que sea una de las opciones
        ]);
    
        // Si la validación pasa, puedes procesar los datos
        foreach ($validatedData['serial'] as $index => $serial) {
            $detail = $validatedData['detailsy'][$index];
            $status = $validatedData['status'][$index];
        
        // Obtener el evento de hoy
        $event = Event::whereDate('date', now()->toDateString())->first();
    
        if (!$event) {
            return response()->json(['message' => 'No se encontró ningún evento para la fecha de hoy'], 404);
        }
    
        DB::transaction(function () use ($validatedData,$event,$request) {
            $incident = Incident::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);



            foreach ($validatedData['serial'] as $index => $serial) {
                $detail = $validatedData['detailsy'][$index];
                $status = $validatedData['status'][$index];
    
                // Insertar datos en la base de datos
                Incidencia::create([
                    'serial' => $serial,
                    'description' => $detail,
                    'status' => $status,
                ]);
            }
        });
        


    
        return response()->json(['message' => 'Incidente creado exitosamente'], 201);
    }
    
}
}
