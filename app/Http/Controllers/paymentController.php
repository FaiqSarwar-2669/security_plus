<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;
use App\Models\CompanyPayment;
use Illuminate\Support\Facades\Validator;

class paymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $user = auth()->user();
        $validate = Validator::make($request->all(), [
            'stripeToken' => 'required|string',
            'amount' => 'required|integer',
            'id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => $validate->errors()
            ], 403);
        }

        if ($request->input('id') == '2') {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create the payment charge
            try {
                $charge = Charge::create([
                    'amount' => $request->amount * 100,
                    'currency' => 'usd',
                    'source' => $request->stripeToken,
                    'description' => 'Test payment from Laravel app',
                ]);

                $transaction = new CompanyPayment();
                $transaction->user_id = '2';
                $transaction->organization_id = $user->id;
                $transaction->name = $user->bussiness_owner;
                $transaction->price = $request->input('amount');
                $transaction->slip = $charge->receipt_url;
                $transaction->save();

                return response()->json([
                    'status' => 'Payment successful',
                    'charge' => $charge,
                    'image' => $charge->receipt_url
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => 'Payment failed', 'error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['status' => 'Organization does not accept online tracsactions'], 403);
        }
    }
}
