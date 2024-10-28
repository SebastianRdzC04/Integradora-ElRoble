<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterUserController extends Controller
{
    //
    public function create()
    {
        return view('pages.users.user_register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'userName' => 'required|string|max:50|unique:users,userName',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            //'role_id' => 'required|exists:roles,id', // Validar que el role_id exista en la tabla roles
        ]);
        
        $personData = session()->get('person_data');
    
        if (!$personData) {
            return redirect()->route('registerperson.create')->withErrors('Por favor complete sus datos personales.');
        }
    
        try {
            DB::transaction(function () use ($personData, $validated) {
                // Crear registro en la tabla `people`
                $person = Person::create($personData);
    
                // Crear usuario vinculado a la persona
                $user = User::create([
                    'userName' => $validated['userName'],
                    'person_id' => $person->id,
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);
    
                // Asociar el rol al usuario
                $user->roles()->attach(1);
            });
    
            session()->forget('person_data');
    
            return redirect()->route('login')->with('success', 'Cuenta creada con éxito, ahora puedes iniciar sesión.');
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al crear el usuario.']);
        }
    }
}    