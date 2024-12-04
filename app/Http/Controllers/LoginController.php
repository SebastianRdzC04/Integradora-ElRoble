<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('pages.sesion.login');
    }
    

    public function password(Request $request)
    {
        $input = $request->input('phoneoremail');

        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $isEmail = true;
        } else {
            $isEmail = false;

            $isPhone = preg_match('/^[0-9]{10}$/', $input); 

            if (!$isPhone) {
                return redirect()->back()->with('error', 'Por favor ingrese un correo electrónico o un número de teléfono válido.');
            }
        }

        if ($isEmail) {
            $userIsLoginWithPassword = User::where('email', $input)
                                           ->whereNull('password')
                                           ->first();
        } else {
            $userIsLoginWithPassword = User::where('phone', $input)
                                           ->whereNull('password')
                                           ->first();
        }

        if ($userIsLoginWithPassword) {
            $authProvider = $userIsLoginWithPassword->external_auth ?? 'Desconocido'; 

            return redirect()->back()->with('error', "Este correo o teléfono solo está disponible para iniciar sesión con $authProvider.");
        }

        return view('pages.sesion.passwordlogin', compact('input'));
    }


    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
    
        $remember = $request->has('remember');
    
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
    
            return redirect()->intended(RouteServiceProvider::HOME);
            
        }
    
        throw ValidationException::withMessages([
            'password' => 'La contraseña es incorrecta.',
        ]);
    }
    
    
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('logout', 'Sesion Cerrada.');
    }

    public function handleGoogleCallback()
    {
            $user = Socialite::driver('google')->user();

        session(['user' => $user]);
        $userExist = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

        if ($userExist) {
            Auth::login($userExist);
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        $userIsLogin = User::where('email', $user->email)->first();

        if($userIsLogin)
        {
            User::where('id', $userIsLogin->id)->update([
                'avatar' => $user->avatar,
                'external_id' => $user->id,
                'external_auth' => 'google',
                'email_verified_at' => now(),
            ]);

            Auth::login($userIsLogin);
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        return redirect()->route('datagoogle');
    }

    public function createdatacompletegoogle()
    {
        $user = session('user');
        return view('pages.sesion.google.datacomplete', compact('user'));
    }
    
}



