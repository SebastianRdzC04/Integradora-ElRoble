<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Quote;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100, // El monto en centavos
                'currency' => 'mxn',
                'source' => $request->stripeToken,
                'description' => 'Pago de cotización #' . $request->quote_id,
            ]);

            // Actualizar el estado de la cotización en la base de datos
            $quote = Quote::find($request->quote_id);
            $quote->status = 'pagada';
            $quote->save();

            return redirect()->route('historialclientes')->with('success', 'Pago realizado con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}