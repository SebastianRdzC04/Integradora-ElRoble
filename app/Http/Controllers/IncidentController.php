<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Incident;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncidentController extends Controller
{
    public function create()
    {
        $inventory = Inventory::all();
        
        return view('pages.people.employee.report_incidents',compact('inventory'));
    }

    public function store(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Validaciones mínimas en el backend
        $validatedata=$request->validate([
            'title' => 'string|max:100',
            'description' => 'string|max:100',
            'serial' => 'string|max:10',
        ]);
        
        // Obtener el evento de hoy
        $event = Event::whereDate('date', now()->toDateString())->first();
    
        if (!$event) {
            return response()->json(['message' => 'No se encontró ningún evento para la fecha de hoy'], 404);
        }
    

        //DB::transaction($validatedata)
        


            Incident::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
        
        // Crear el incidente
        


    
        return response()->json(['message' => 'Incidente creado exitosamente'], 201);
    }
    
    
}
