<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createSPEIPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Example amount: 100 MXN = 10000 centavos
        $amount = 100 * 100; // Stripe uses *centavos* for MXN

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'mxn',
            'payment_method_types' => ['spei'], // <-- Important
            'description' => 'Payment via SPEI',
            'metadata' => [
                'order_id' => uniqid(),
            ],
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
            'payment_intent_id' => $paymentIntent->id,
        ]);
    }
}
