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
    
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('inicio')->with('info', 'Tu correo ya ha sido verificado.');
        }
    
        $user->sendEmailVerificationNotification();
    
        return redirect()->back()->with('success', 'Enlace de verificación reenviado.');
    }

    public function showVerificationEmailView()
    {
        return view('pages.sesion.notification.verify_email');
    }

    public function showVerificationPhoneView()
    {
        return view('pages.sesion.notification.verify_phone');
    }    

    
}
