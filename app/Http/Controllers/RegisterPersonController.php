<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class RegisterPersonController extends Controller
{
    public function create()
    {
        return view('pages.people.person_register');
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
        
        // Guardar datos de persona temporalmente en la sesión
        session()->put('person_data', $request->except('_token'));
        
        // Verificar si los datos de la persona están en la sesión
        $personData = session()->get('person_data');

        if (!$personData) {
            return redirect()->route('registerperson.create')->withErrors('Por favor complete sus datos personales.');
        }

        // Redirigir a la ruta para crear un usuario asociado a la persona
        return redirect()->route('registeruser.create');

        
    }

    public function update($id)
    {
        $person = Person::find($id);
        return view('pages.people.person_edit',compact('person'));
    }
    public function index()
    {
        $people = Person::all();
        return view('pages.people.person_list',compact('people'));
    }
}
