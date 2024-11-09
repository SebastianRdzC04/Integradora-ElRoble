<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

class LoginController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('pages.sesion.login');
    }

    public function verifypassword(Request $request)
    {
        $email = $request->input('phoneoremail');
        return view('pages.sesion.passwordlogin',compact('email'));
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        // Si el correo ya está verificado, redirigir al usuario
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME)
                ->with('success', 'Tu email ya está verificado.');
        }

        // Marcar el correo como verificado
        $request->user()->markEmailAsVerified();

        // Disparar el evento de verificación
        event(new Verified($request->user()));

        // Redirigir al usuario a la página que intentaba visitar
        return redirect()->intended(RouteServiceProvider::HOME)
            ->with('success', 'Tu email ha sido verificado.');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Obtener las credenciales del usuario
        $credentials = $request->only('email', 'password');
    
        // Revisar si la casilla "Recordarme" fue marcada
        $remember = $request->has('remember');
    
        // Autenticar al usuario usando las credenciales y la opción "Recordarme"
        if (Auth::attempt($credentials, $remember)) {
            // Regenerar la sesión para evitar ataques de sesión fija
            $request->session()->regenerate();
    
            // Redireccionar al usuario a la página de destino
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    
        // Si la autenticación falla, redirigir de vuelta con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }
    
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    
}



