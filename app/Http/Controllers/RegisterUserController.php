<?php
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
    public function create($phoneoremail)
    {
        return view('pages.sesion.user_register', compact('phoneoremail'));
    }

    public function store(Request $request)
    {
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
            $person = Person::create($validateperson);

            $user = User::create([
                'person_id' => $person->id,
                'email' => $validateduser['email'],
                'password' => Hash::make($validateduser['password']),
            ]);

            $role = Rol::where('name', 'user')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        
            Auth::login($user);

            return redirect()->route('verification.send');
        });
    }

    public function createUserGoogle($user)
    {
        return view('pages.sesion.google.datacomplete', compact('user'));
    }

    public function storeUserGoogle(Request $request, $user)
    {
        $validatedData = $request->validated([
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
        ]);

        $userExist = User::where('external_id', $user->id)
                        ->where('external_auth', 'google')
                        ->first();

        if ($userExist) {
            Auth::login($userExist);
        } else {
            DB::transaction(function () use ($user, $validatedData) {
                $personNew = Person::create([
                    'firstName' => $user->user['given_name'],
                    'lastName' => $user->user['family_name'],
                    'gender' => $validatedData['gender'],
                    'phone' => $validatedData['phone'],
                    'birthdate' => $validatedData['birthdate']
                ]);

                $userNew = User::create([
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'external_id' => $user->id,
                    'external_auth' => 'google',
                    'person_id' => $personNew->id,
                ]);

                        $role = Rol::where('name', 'user')->first();
                    if ($role) {
                        $user->roles()->attach($role->id);
                    }

                Auth::login($userNew);
            });

            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}
