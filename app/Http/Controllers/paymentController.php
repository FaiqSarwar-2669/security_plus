<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required|string',
            'amount' => 'required|integer'
        ]);
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create the payment charge
        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test payment from Laravel app',
            ]);

            return response()->json(['status' => 'Payment successful', 'charge' => $charge]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Payment failed', 'error' => $e->getMessage()], 500);
        }
    }
}
