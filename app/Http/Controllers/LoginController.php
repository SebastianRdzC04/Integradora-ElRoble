<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;

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
        $email = $request->input('phoneoremail');
        return view('pages.sesion.passwordlogin',compact('email'));
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
    
}



