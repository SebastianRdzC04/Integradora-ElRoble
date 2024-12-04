<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

class TwilioService
{
    protected $client;
    protected $serviceSid;

    public function __construct()
    {
        // Obtener las credenciales de Twilio desde el archivo .env
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->serviceSid = env('TWILIO_VERIFY_SERVICE_SID'); // SID del servicio de verificación
        $this->client = new Client($sid, $token);  // Crear el cliente Twilio
    }

    /**
     * Enviar el código OTP al número de teléfono especificado.
     *
     * @param string $phoneNumber
     * @return string|array
     */
    public function sendOtp($phoneNumber)
    {
        try {
            $verification = $this->client->verify->v2->services($this->serviceSid)
                ->verifications
                ->create($phoneNumber, 'sms'); 

            return $verification->sid;
        } catch (TwilioException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Verificar si el OTP ingresado es válido para el número de teléfono.
     *
     * @param string $phoneNumber
     * @param string $otpCode
     * @return string|array
     */
    public function verifyOtp($phoneNumber, $otpCode)
    {
        try {
            $verificationCheck = $this->client->verify->v2->services($this->serviceSid)
                ->verificationChecks
                ->create($otpCode, ['to' => $phoneNumber]); 

            return $verificationCheck->status;
        } catch (TwilioException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
