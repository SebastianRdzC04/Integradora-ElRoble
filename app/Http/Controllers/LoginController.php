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
        
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}



