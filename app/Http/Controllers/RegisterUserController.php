<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    //
    public function create($phoneoremail)
    {
        return view('pages.sesion.user_register',compact('phoneoremail'));
    }

    public function store(Request $request)
    {
        // Validar datos
        $validateperson = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
        ]);
        $validateperson['age'] = 18;
    
        $validateduser = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        DB::transaction(function () use ($validateperson, $validateduser) {
            // Crear registro en la tabla `people`
            $person = Person::create($validateperson);
    
            // Crear usuario vinculado a la persona
            $user = User::create([
                'person_id' => $person->id,
                'email' => $validateduser['email'],
                'password' => Hash::make($validateduser['password']),
            ]);
    
            // Asignar el rol de 'user' por defecto al usuario
            $role = Rol::where('name', 'user')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        
            Auth::login($user);

            // Enviar correo de verificación
            return redirect()->route('verification.send');
    
        });
    
    }
    
    
    
}    