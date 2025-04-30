<?php

namespace App\Http\Controllers;

use App\Models\Course;
use CodersFree\Shoppingcart\Facades\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use PaypalServerSdkLib\PaypalServerSdkClientBuilder;
use PaypalServerSdkLib\Authentication\ClientCredentialsAuthCredentialsBuilder;
use PaypalServerSdkLib\Logging\LoggingConfigurationBuilder;
use PaypalServerSdkLib\Logging\RequestLoggingConfigurationBuilder;
use PaypalServerSdkLib\Logging\ResponseLoggingConfigurationBuilder;
use Psr\Log\LogLevel;
use PaypalServerSdkLib\Models\Builders\OrderRequestBuilder;
use PaypalServerSdkLib\Models\CheckoutPaymentIntent;
use PaypalServerSdkLib\Models\Builders\PurchaseUnitRequestBuilder;
use PaypalServerSdkLib\Models\Builders\AmountWithBreakdownBuilder;
use PaypalServerSdkLib\Models\Builders\AmountBreakdownBuilder;
use PaypalServerSdkLib\Models\Builders\MoneyBuilder;
use PaypalServerSdkLib\Models\Builders\ItemBuilder;
use PaypalServerSdkLib\Models\ItemCategory;
use PaypalServerSdkLib\Models\Builders\ShippingDetailsBuilder;
use PaypalServerSdkLib\Models\Builders\ShippingNameBuilder;
use PaypalServerSdkLib\Models\Builders\ShippingOptionBuilder;
use PaypalServerSdkLib\Models\ShippingType;
use PaypalServerSdkLib\Environment;
use PaypalServerSdkLib\Models\Builders\PaypalWalletBuilder;
use PaypalServerSdkLib\Models\Builders\PaypalWalletExperienceContextBuilder;
use PaypalServerSdkLib\Models\ShippingPreference;
use PaypalServerSdkLib\Models\PaypalExperienceLandingPage;
use PaypalServerSdkLib\Models\PaypalExperienceUserAction;
use PaypalServerSdkLib\Models\Builders\CallbackConfigurationBuilder;
use PaypalServerSdkLib\Models\Builders\PhoneNumberWithCountryCodeBuilder;
use PaypalServerSdkLib\Models\Builders\PaymentSourceBuilder;
use PaypalServerSdkLib\Models\CallbackEvents;

class CheckOutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function createPaypalOrder()
    {
        $access_token = $this->generateAccessToken();

        $url_order = config('services.paypal.url') . "/v2/checkout/orders";

        Cart::instance('shopping');



        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $access_token,

        ])->post($url_order, [

                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => Cart::subtotal(),
                                'breakdown' => [
                                    'item_total' => [
                                        'currency_code' => 'USD',
                                        'value' => Cart::subtotal(),
                                    ],
                                    /* 'discount' => [
                                        'currency_code' => 'USD',
                                        'value' => Cart::discount(),
                                    ] */
                                ],

                            ],
                            'items' => Cart::content()->map(function ($item) {
                                return [
                                    'name' => $item->name,
                                    'unit_amount' => [
                                        'currency_code' => 'USD',
                                        'value' => $item->price,
                                    ],
                                    'quantity' => $item->qty,
                                    'sku' => $item->id
                                ];
                            })->values()->toArray(),
                        ]
                    ],
                ])->json();
        return $response;
    }


    public function capturePaypalOrder(Request $request)
    {
        $access_token = $this->generateAccessToken();
        $orderId = $request->orderId;
        $url = config('services.paypal.url') . "/v2/checkout/orders/{$orderId}/capture";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $access_token,

        ])->post($url, [

                    'intent' => 'CAPTURE',



                ])->json();

        if (!isset($response['status']) || $response['status'] !== 'COMPLETED') {
            throw new Exception('Error al capturar la orden');
        }

        // Inscribir al alumno
        Cart::instance('shopping');

        foreach (Cart::content() as $item) {
            $course = Course::find($item->id);
            $course->students()->attach(Auth::id());
        }

        Cart::destroy();
        Cart::store(Auth::id());


    }

    public function generateAccessToken()
    {
        $client_id = config('services.paypal.client_id');

        $secret = config('services.paypal.secret');

        $url_token = config('services.paypal.token_url');


        $auth = base64_encode($client_id . ':' . $secret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $auth,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->asForm()->post($url_token, [
                    'grant_type' => 'client_credentials'
                ])->json();

        return $response['access_token'];
    }
}
