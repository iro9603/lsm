<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;

use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;

use MercadoPago\MercadoPagoConfig;


use Illuminate\Support\Facades\DB;


class MercadoPagoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('Webhook recibido', ['payload' => $request->all()]);

        if ($request->type === 'payment') {


            $paymentId = $request->data['id'];

            MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));

            $paymentClient = new PaymentClient();

            $payment = $paymentClient->get($paymentId);


            $externalReference = $payment->external_reference ?? '';


            list($email, $dateTime) = explode('|', $externalReference . '|');

            list($date, $time) = explode(' ', $dateTime . " ");


            if ($payment->status === 'approved') {
                \Log::info('Entro al flujo para insertar');
                try {
                    DB::beginTransaction();

                    $time_slot_id = DB::table('time_slots')->where('start_time', $time)->value('id');

                    $user_id = DB::table('users')->where('email', $email)->value('id');

                    $user_name = DB::table('users')->where('id', $user_id)->value('name');

                    $available_slot_id = DB::table('available_slots')->where('time_slot_id', $time_slot_id)->where('date', $date)->where('is_booked', 0)->where('is_blocked', 0)->value('id');


                    if ($available_slot_id !== null) {
                        $booking_id = DB::table('bookings')->insertGetId([
                            'user_id' => $user_id,
                            'available_slot_id' => $available_slot_id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                        if ($booking_id) {
                            $slot = AvailableSlot::find($available_slot_id);
                            $slot->is_booked = true;
                            $slot->is_temporarily_blocked = false;
                            $slot->temporarily_blocked_until = null;
                            $slot->save();


                            $googleObj = new GoogleController();

                            $returnedLinkMeet = $googleObj->createCalendarEvent($user_name, $email, $date, $time);


                            // Actualizar el booking con la liga
                            DB::table('bookings')->where('id', $booking_id)->update([
                                'link' => $returnedLinkMeet,
                                'updated_at' => now(),
                            ]);
                        } else {
                            \Log::info("Error, no se inserto");
                        }
                    } else {
                        \Log::info("Error, slot id no encontrado");
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
