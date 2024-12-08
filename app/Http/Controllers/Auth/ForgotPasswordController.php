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
    
        $resetEntry = DB::table('password_resets')->where('email', $email)->first();
    
        if ($resetEntry && Carbon::parse($resetEntry->created_at)->addMinutes(2) > now()) {
            return back()->withErrors([
                'email' => 'Ya has solicitado un enlace recientemente. Inténtalo de nuevo en unos minutos.',
            ]);
        }
    
        DB::table('password_resets')->where('email', $email)->delete();
    
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
    
        // Enviar el correo electrónico con el enlace
        Mail::to($email)->send(new ResetPasswordMail($url, $email));
    
        return back()->with('status', 'Hemos enviado un enlace para restablecer tu contraseña.');
    }
    
    /**
     * verifica el token y redirige al usuario a una pantalla predeterminada si es inválido o expirado.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    */

        public function showResetForm(Request $request, $token)
{
    $email = $request->email;

    // Verificar si el token es válido
    $resetEntry = DB::table('password_resets')
        ->where('email', $email)
        ->first();

    // Si no existe o el token no coincide, redirigir con un mensaje de error
    if (!$resetEntry || !Hash::check($token, $resetEntry->token)) {
        return redirect()->route('password.request')->withErrors([
            'email' => 'El enlace para restablecer la contraseña es inválido o ha expirado.',
        ]);
    }

    // Mostrar el formulario si el token es válido
    return view('pages.sesion.createnewpassword', [
        'token' => $token,
        'email' => $email,
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
