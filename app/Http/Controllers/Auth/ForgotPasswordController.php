<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Auth
{
    /**
     * Muestra el formulario para solicitar un enlace de restablecimiento de contraseña.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('pages.sesion.forgotpassword'); // Vista donde el usuario ingresa su email
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
            return back()->withErrors(['email' => 'No encontramos un usuario con ese correo.']);
        }
        $email= $user->email;
        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(30), 
            ['token' => $token, 'email' => $user->email]
        );


        Mail::to(['email' => $email])->send(new ResetPasswordMail($url,$email));
        return back()->with('status', 'Hemos enviado un enlace para restablecer tu contraseña.');
        
    }   
}