<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /**
     * Muestra el formulario para restablecer la contraseña.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        if (!$request->hasValidSignature()) {
            abort(403); 
        }
    
        if (is_null($token) || is_null($request->email)) {
            return redirect()->route('password.request')->withErrors(['email' => 'Token o email no válidos.']);
        }

        return view('pages.sesion.createnewpassword')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    /**
     * Maneja la solicitud de restablecimiento de contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }
}
