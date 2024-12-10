<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Quote;
use App\Mail\QuotePaymentNotification;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'mxn',
                'source' => $request->stripeToken,
                'description' => 'Pago de cotización #' . $request->quote_id,
            ]);

            $quote = Quote::find($request->quote_id);
            $quote->status = 'pagada';
            $quote->save();

            // Determinar si es pago de anticipo
            $isAdvancePayment = $request->amount == $quote->espected_advance;
            
            // Cargar relaciones necesarias para el email
            $quote->load(['user.person', 'place']);

            // Enviar notificación por email
            try {
                Mail::to('villarrealperezjesusalberto@gmail.com')
                    ->send(new QuotePaymentNotification(
                        $quote, 
                        $request->amount, 
                        $isAdvancePayment
                    ));
            } catch (\Exception $e) {
                \Log::error('Error enviando email de pago: ' . $e->getMessage());
            }

            return redirect()->route('historialclientes')
                ->with('success', 'Pago realizado con éxito.');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}