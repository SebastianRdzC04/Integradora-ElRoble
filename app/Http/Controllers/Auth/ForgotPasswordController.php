<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use App\Mail\ResetPasswordMail; // Asegúrate de tener este mail configurado

class ForgotPasswordController extends Controller
{
    /**
     * Muestra el formulario para solicitar un enlace de restablecimiento de contraseña.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('pages.sesion.forgotpassword'); 
    }

    /**
     * Envía el enlace de restablecimiento de contraseña al correo solicitado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No encontramos a un usuario con ese correo.']);
        }

        $email = $user->getEmailForPasswordReset();
$token = 'abc123xyz'; 

$url = URL::temporarySignedRoute(
    'password.reset', 
    now()->addMinutes(30), 
    ['token' => $token, 'email' => $email] 
);

Mail::to($user->email)->send(new ResetPasswordMail($url));

        return back()->with('status', 'Hemos enviado un enlace para restablecer tu contraseña.');
    }
}
