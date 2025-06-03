<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    public function handleCardPayment(Request $request, Response $response)
    {

        /* try {

            MercadoPagoConfig::setAccessToken("TEST-5267773176916311-052820-2a18a29cf6f1b642556ce0b0b178b85a-448109497");

            $client = new PaymentClient();
            $request_options = new RequestOptions();
            $request_options->setCustomHeaders([
                "X-Idempotency-Key: " . uniqid("payment_", true)
            ]);

            \Log::info('Datos enviados a MP:', [
                "transaction_amount" => (float) $request->input('transaction_amount'),
                "token" => $request->input('token'),
                "description" => $request->input('description'),
                "installments" => $request->input('installments'),
                "payment_method_id" => $request->input('payment_method_id'),
                "issuer_id" => $request->input('issuer_id'),
                "payer" => [
                    "email" => $request->input('payer.email'),
                    "identification" => [
                        "type" => $request->input('payer.identification.type'),
                        "number" => $request->input('payer.identification.number')
                    ]
                ]
            ]);

            $payment = $client->create([
                "transaction_amount" => (float) $request->input('transaction_amount'),
                "token" => $request->input('token'),
                "description" => $request->input('description'),
                "installments" => $request->input('installments'),
                "payment_method_id" => $request->input('payment_method_id'),
                "issuer_id" => $request->input('issuer_id'),
                "payer" => [
                    "email" => $request->input('payer.email'),
                    "identification" => [
                        "type" => $request->input('payer.identification.type'),
                        "number" => $request->input('payer.identification.number')
                    ]
                ],


            ], $request_options);

            $this->validate_payment_result($payment);
            return response()->json([
                'status' => $payment->status,
                'status_detail' => $payment->status_detail,
                'id' => $payment->id,
                'date_approved' => $payment->date_approved,
                'payment_method_id' => $payment->payment_method_id,
                'payment_type_id' => $payment->payment_type_id
            ], 201);

        } catch (MPApiException $e) {
            \Log::error('MPApiException: ' . $e->getMessage());
            \Log::error('MPApiException details: ' . json_encode($e->getApiResponse()->getContent()));
            return response()->json([
                'error_message' => 'Error en la API de MercadoPago',
                'details' => $e->getApiResponse()->getContent()
            ], 400);
        }
    }

    public function validate_payment_result($payment)
    {
        if ($payment->id === null) {
            $error_message = 'Unknown error cause';

            if ($payment->error !== null) {
                $sdk_error_message = $payment->error->message;
                $error_message = $sdk_error_message !== null ? $sdk_error_message : $error_message;
            }

            throw new Exception($error_message);
        }
    } */
    }
}
