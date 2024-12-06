<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VerifyPhoneController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * Enviar OTP al número de teléfono del usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendOtp()
    {
        $user = Auth::user();
        if ($user->person) {
            $phoneWithOutPrefix = $user->person->phone;

            $phone = '+52' . $phoneWithOutPrefix;   
        } else {
    return response()->json(['error' => 'Teléfono no encontrado.'], 400);
        }
        $result = $this->twilio->sendOtp($phone);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        return redirect()->back()->whit('success', 'OTP enviado correctamente');
    }

    /**
     * Verificar OTP ingresado por el usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code1' => 'required|digits:1', 
            'code2' => 'required|digits:1',
            'code3' => 'required|digits:1',
            'code4' => 'required|digits:1',
            'code5' => 'required|digits:1',
            'code6' => 'required|digits:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'OTP inválido, asegúrate de que todos los campos estén completos y sean dígitos'], 400);
        }

        $otpCode = implode('', [
            $request->input('code1'),
            $request->input('code2'),
            $request->input('code3'),
            $request->input('code4'),
            $request->input('code5'),
            $request->input('code6'),
        ]);

        $user = Auth::user();
        if ($user->person) {
            $phoneWithOutPrefix = $user->person->phone;

            $phone = '+52' . $phoneWithOutPrefix;         
        }
        else {
            return response()->json(['error' => 'Teléfono no encontrado.'], 400);
        }
        $status = $this->twilio->verifyOtp($phone, $otpCode);

        if (isset($status['error'])) {
            return response()->json(['error' => $status['error']], 500);
        }

        if ($status == 'approved') {
            $id = User::where('id',auth()->user()->getAuthIdentifier())->value('person_id');
            Person::where('id',$id)->update(['phone_verified_at' => Carbon::now()]);
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return response()->json(['error' => 'OTP inválido'], 400);
    }

    public function create()
    {
        return view('pages.sesion.notification.verify_phone');
    }
}
