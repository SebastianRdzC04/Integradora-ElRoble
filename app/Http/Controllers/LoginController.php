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
        // Obtiene el valor ingresado por el usuario
        $input = $request->input('phoneoremail');

        // Verifica si es un correo electrónico
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $isEmail = true;
        } else {
            // Verifica si es un número de teléfono
            $isEmail = false;

            // Validación para un número de teléfono con 10 dígitos
            $isPhone = preg_match('/^[0-9]{10}$/', $input); // Ajusta la longitud según sea necesario

            if (!$isPhone) {
                // Si no es un número de teléfono ni un correo, puedes retornar un error con Toastr
                return redirect()->back()->with('error', 'Por favor ingrese un correo electrónico o un número de teléfono válido.');
            }
        }

        // Si es un correo electrónico, verifica si está registrado
        if ($isEmail) {
            $userIsLoginWithPassword = User::where('email', $input)
                                           ->whereNull('password')
                                           ->first();
        } else {
            // Si es un teléfono, verifica si está registrado
            $userIsLoginWithPassword = User::where('phone', $input)
                                           ->whereNull('password')
                                           ->first();
        }

        // Si el usuario tiene una contraseña nula, redirige con un mensaje
        if ($userIsLoginWithPassword) {
            $authProvider = $userIsLoginWithPassword->external_auth ?? 'Desconocido'; // Si no tiene 'external_auth', devuelve 'Desconocido'

            // Redirige con mensaje de error usando Toastr
            return redirect()->back()->with('error', "Este correo o teléfono solo está disponible para iniciar sesión con $authProvider.");
        }

        // Si el usuario tiene contraseña, puede continuar con el inicio de sesión
        return view('pages.sesion.passwordlogin', compact('input'));
    }


    public function store(LoginRequest $request): RedirectResponse
    {
        // Obtener las credenciales directamente del request
        $credentials = $request->only('email', 'password');
    
        // Revisar si la casilla "Recordarme" fue marcada
        $remember = $request->has('remember');
    
        // Autenticar al usuario usando las credenciales y la opción "Recordarme"
        if (Auth::attempt($credentials, $remember)) {
            // Regenerar la sesión para evitar ataques de sesión fija
            $request->session()->regenerate();
    
            return redirect()->intended(RouteServiceProvider::HOME);
            
        }
    
        // Si la autenticación falla, redirigir de vuelta con un mensaje de error
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
            // Intenta obtener el usuario de Google
            $user = Socialite::driver('google')->user();

        session(['user' => $user]);
        // si existe con google solo lo logueo
        $userExist = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

        if ($userExist) {
            Auth::login($userExist);
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        // si el usuario se registro manual y luego intento inciar sesion con google
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
        // si no existe entonces requiero mas datos
        return redirect()->route('datagoogle');
    }

    public function createdatacompletegoogle()
    {
        $user = session('user');
        return view('pages.sesion.google.datacomplete', compact('user'));
    }
    
}



