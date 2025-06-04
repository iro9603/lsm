<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;

use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;

use MercadoPago\MercadoPagoConfig;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class MercadoPagoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('Webhook recibido', ['payload' => $request->all()]);

        if ($request->type === 'payment') {
            \Log::info('ID recibido en webhook:', ['payment_id' => $request->data['id']]);

            $paymentId = $request->data['id'];

            MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));

            $paymentClient = new PaymentClient();
            $payment = $paymentClient->get($paymentId);
            $externalReference = $payment->external_reference ?? '';

            list($email, $dateTime) = explode('|', $externalReference . '|');

            list($date, $time) = explode(' ', $dateTime . " ");


            if ($payment->status === 'approved') {

                try {
                    DB::beginTransaction();

                    $time_slot_id = DB::table('time_slots')->where('start_time', $time)->value('id');

                    $user_id = DB::table('users')->where('email', $email)->value('id');

                    $available_slot_id = DB::table('available_slots')->where('time_slot_id', $time_slot_id)->where('date', $date)->where('is_booked', 0)->where('is_blocked', 0)->value('id');

                    $dateApprovedRaw = $payment->date_approved;
                    $carbon = Carbon::parse($dateApprovedRaw)->setTimezone('America/Mexico_City');
                    $formatted = $carbon->format('Y-m-d H:i:s');

                    $resultInsert = DB::table('bookings')->insert([
                        'user_id' => $user_id,
                        'available_slot_id' => $available_slot_id,
                        'created_at' => now()
                    ]);

                    if ($resultInsert) {
                        AvailableSlot::where('id', $available_slot_id)->update([
                            'is_booked' => 1
                        ]);

                        $googleObj = new GoogleController();



                        $googleObj->createCalendarEvent($email, $date, $time);


                    }


                    DB::commit(); // <= Commit the changes
                } catch (\Exception $e) {
                    report($e);

                    DB::rollBack(); // <= Rollback in case of an exception
                }

                // Manejo de google meet para enviar el vinculo de la sesion

            }

        }

        return response()->json(['status' => 'ok'], 200);

    }
}
