<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Person;

class RegisterPersonController extends Controller
{
    public function create()
    {
        $admin = auth()->check() && auth()->user()->roles()->where('role_user.rol_id', 1)->exists();
        return view('pages.people.person_register', compact('admin')); 
    }

    public function validateData(Request $request)
    {
        return $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'age' => 'required|integer|min:0|max:120',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateData($request);
        return $this->storeWithUser($request);
    }

    public function storeWithoutUser(Request $request)
    {
        $validated = $this->validateData($request);
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

    public function storeWithUser(Request $request)
    {
        // Guardar datos de persona temporalmente en la sesión
        session()->put('person_data', $request->except('_token'));
        
        // Verificar si los datos de la persona están en la sesión
        $personData = session()->get('person_data');

        if (!$personData) {
            return redirect()->route('register-person.create')->withErrors('Por favor complete sus datos personales.');
        }

        // Redirigir a la ruta para crear un usuario asociado a la persona
        return redirect()->route('registeruser.create');
    }
}
