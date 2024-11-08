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
use Illuminate\Support\Facades\Password;
class ForgotPasswordController extends Auth
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
     * 
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

        $email = $user->email;

        
        DB::table('password_resets')->where('email', $email)->delete();

        // aqui crea el tocken para insertarlo en la bd
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(30),
            ['token' => $token, 'email' => $email]
        );

        Mail::to($email)->send(new ResetPasswordMail($url, $email));

        return back()->with('status', 'Hemos enviado un enlace para restablecer tu contraseña.');
    }

    /**
     * Verifica el token y redirige al usuario a una pantalla predeterminada si es inválido o expirado.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    */

    public function showResetForm(Request $request, $token)
    {
        // Verifica si el token existe y es válido en la base de datos
        $resetEntry = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $token)
            ->first();
    
        if (!$resetEntry) {
            return redirect()->route('error.invalid_token')->withErrors([
                'message' => 'El token es inválido o ha expirado. Por favor, solicita un nuevo enlace.'
            ]);
        }
    
        return view('pages.sesion.createnewpassword', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
    
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );
        
        DB::table('password_resets')->where('email', $request->email)->delete();
        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);

        
    }
    
}
