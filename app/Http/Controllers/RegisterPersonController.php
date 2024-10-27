<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterPersonController extends Controller
{
    public function create()
    {
        return view('pages.sesion.person_register'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            'age' => 'required|integer|min:0|max:120',
        ]);

        session()->put('person_data', $request->except('_token'));
        
        $personData = session()->get('person_data');

        if (!$personData) 
        {
            return redirect()->route('register-person.create')->withErrors('Por favor complete sus datos personales.');
        }

        return redirect()->route('registeruser.create');
    }
}
