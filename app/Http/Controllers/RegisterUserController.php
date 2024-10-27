<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    //
    public function create()
    {
        return view('pages.sesion.user_register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'userName' => 'required|string|max:50|unique:users,userName',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $personData = session()->get('person_data');

        if (!$personData) {
            return redirect()->route('register-person.create')->withErrors('Por favor complete sus datos personales.');
        }

        DB::transaction(function () use ($personData, $request) {
            // Crear registro en la tabla `people`
            $person = Person::create($personData);
    
            // Crear usuario vinculado a la persona
            User::create([
                'userName' => $request->userName,
                'person_id' => $person->id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        });

        session()->forget('person_data');

    return redirect()->route('login')->with('success', 'Cuenta creada con éxito, ahora puedes iniciar sesión.');
    }
}
