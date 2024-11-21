<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;

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
            
            
            $user->sendEmailVerificationNotification();
            
        });
        

        return redirect()->route('verification.notice');
    }

    public function storeUserGoogle(Request $request)
    {
        $user = session('user');
        $validatedData = $request->validate([
            'birthdate' => 'required|date',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'phone' => 'required|string|size:10|regex:/^[0-9]+$/',
        ]);
        $validatedData['age'] = 18;
        
        dd($user);
        $userExist = User::where('external_id', $user->id)
                        ->where('external_auth', 'google')
                        ->first();

        
        dd($userExist);

        if ($userExist) {
            Auth::login($userExist);
        } else {

            if
            (
                
            )
            DB::transaction(function () use ($user, $validatedData) {

                $personNew = Person::create([
                    'firstName' => $user->user['given_name'],
                    'lastName' => $user->user['family_name'],
                    'gender' => $validatedData['gender'],
                    'phone' => $validatedData['phone'],
                    'birthdate' => $validatedData['birthdate'],
                    'age' => $validatedData['age'],
                ]);

                $userNew = User::create([
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'external_id' => $user->id,
                    'external_auth' => 'google',
                    'person_id' => $personNew->id,
                    'email_verified_at' => now(),
                ]);

                        $role = Rol::where('name', 'user')->first();

                    if ($role) {
                        $userNew->roles()->attach($role->id);
                    }

                Auth::login($userNew);
            });

            return redirect()->intended(RouteServiceProvider::HOME);
        }
        
    }
    public function handleGoogleCallback()
    {
        // Obtén los datos del usuario desde Google
        $user = Socialite::driver('google')->user();

        session()->flash('user', $user);
        // Verifica si el usuario ya existe en tu base de datos
        $userExist = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

        if ($userExist) {
            // Si el usuario existe, lo logueas y rediriges al home
            Auth::login($userExist);
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Si el usuario no existe, redirige a la vista para completar datos
        return view('pages.sesion.google.datacomplete', compact('user'));
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        dd($user);
        // Aquí puedes buscar al usuario en tu base de datos o crear uno nuevo
        $existingUser = User::where('facebook_id', $user->getId())->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'facebook_id' => $user->getId(),
                'avatar' => $user->getAvatar(),
            ]);
            Auth::login($newUser, true);
        }

        return redirect()->route('home');  // Redirige a la página principal o donde desees
    }

    //Aqui esta X o Twitter como lo llamen ---------------------------------------------


    public function handleXCallback()
    {
        
            $user = Socialite::driver('x')->user();
            dd($user);
            // Buscar o crear el usuario en la base de datos
            $existingUser = User::where('x_id', $user->getId())->first();

            if ($existingUser) {
                // Si el usuario ya existe, iniciar sesión
                Auth::login($existingUser, true);
            } else {
                // Si el usuario no existe, crear uno nuevo
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'x_id' => $user->getId(),
                    'avatar' => $user->getAvatar(),
                ]);

                Auth::login($newUser, true);
            }

            return redirect()->route('home'); // Redirigir al usuario después de iniciar sesión
        
    }
}
