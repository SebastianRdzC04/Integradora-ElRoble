<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = $request->user();
    
        // Verificar si el usuario ya está verificado
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('info', 'Tu correo ya ha sido verificado.');
        }
    
        // Reenviar el correo de verificación
        $user->sendEmailVerificationNotification();
    
        // Mensaje de éxito
        session()->flash('success', 'Enlace de verificación reenviado.');
        return redirect()->route('verification.notice');
    }
    
    

    /**
     * Mostrar la vista de verificación de correo electrónico.
     */
    public function showVerificationView()
    {
        return view('pages.sesion.notification.verify_email');
    }
}
