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
                'amount' => $request->amount * 100,
                'currency' => 'mxn',
                'source' => $request->stripeToken,
                'description' => 'Pago de cotización #' . $request->quote_id,
            ]);
    
            $quote = Quote::find($request->quote_id);
    
            if ($request->amount == $quote->estimated_price) {
                $quote->espected_advance = $quote->estimated_price;
            } else {
                $quote->espected_advance = $request->amount;
            }
    
            $quote->status = 'pagada';
            $quote->save();
    
            return redirect()->route('historialclientes')->with('success', 'Pago realizado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('historialclientes')->withErrors(['error' => $e->getMessage()]);
        }
    }
}