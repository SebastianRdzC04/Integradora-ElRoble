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
    public function create($phoneoremail)
    {
        return view('pages.sesion.user_register',compact('phoneoremail'));
    }

    public function store(Request $request)
    {
        $validateperson = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
            //'age' => 'required|integer|min:0|max:120',

        ]);
        $validateperson['age'] = 18;

        $validateduser = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            
            //'role_id' => 'required|exists:roles,id', // Validar que el role_id exista en la tabla roles
        ]);


        //Antiguo registro de usuario person_data era del otro formulario que mandaba los datos para insertar al mismo tiempo el usuario
        /*$personData = session()->get('person_data');
    
        if (!$personData) {
            return redirect()->route('registerperson.create')->withErrors('Por favor complete sus datos personales.');
        }
        */
        try {
            DB::transaction(function () use ($validateperson, $validateduser) {
                // Crear registro en la tabla `people`
                $person = Person::create($validateperson);
    
                // Crear usuario vinculado a la persona
                $user = User::create([
                    'person_id' => $person->id,
                    'email' => $validateduser['email'],
                    'password' => Hash::make($validateduser['password']),
                ]);
    
                // Asociar el rol al usuario
                $user->roles()->attach(1);
            });
    
            /*esta parte borraba la sesion de la persona al momento de crearla (inhabilitada)
            session()->forget('person_data');*/
            return redirect()->route('login')->with('success', 'Cuenta creada con éxito, ahora puedes iniciar sesión.');
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al crear el usuario.']);
        }
    }
}    