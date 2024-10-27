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
        

        return redirect()->route('registeruser.create');
        /*$person = new Person();
        $person->firstName = $request->input('firstName');
        $person->lastName = $request->input('lastName');
        $person->birthdate = $request->input('birthdate');
        $person->gender = $request->input('gender');
        $person->phone = $request->input('phone');
        $person->age = $request->input('age');
        

        return redirect()->route('login')->with('success', 'Te registraste con exito');
        */
    }
}
