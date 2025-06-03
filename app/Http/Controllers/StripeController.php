<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{

    public function handleTransfer(Request $request)
    {
        $stripeSecretKey = env('STRIPE_SECRET');

        $stripe = new \Stripe\StripeClient($stripeSecretKey);
        $customer = $stripe->customers->create([
            'email' => Auth::user()->email,
        ]);

        $session = $stripe->checkout->sessions->create([
            'customer' => $customer->id,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'mxn',
                        'product_data' => [
                            'name' => 'T-shirt',
                        ],
                        'unit_amount' => 18000, // MX$180.00
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'payment_method_types' => ['customer_balance', 'card'],
            'payment_method_options' => [
                'customer_balance' => [
                    'funding_type' => 'bank_transfer',
                    'bank_transfer' => [
                        'type' => 'mx_bank_transfer',
                    ],
                ],
            ],
            'success_url' => route('gracias'),
            'cancel_url' => route('asesoria'),
        ]);

        return redirect($session->url);
    }
}

