<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Log;

class RegisterPersonAdminController extends Controller
{
    //
    public function create()
    {
        return view('pages.people.person_register_admin'); 
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'age' => 'required|integer|min:0|max:120',
        ]);
        
        try {
            // Crear la persona en la base de datos
            Person::create($validated);

            // Redirigir o retornar un mensaje de éxito
            return redirect()->route('registerpersonadmin.create')->with('success', 'Persona agregada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            Log::error($e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al agregar la persona.']);
        }
    }
}
