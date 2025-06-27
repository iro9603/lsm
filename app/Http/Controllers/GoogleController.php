<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_CreateConferenceRequest;
use Illuminate\Http\Request;

use App\Mail\EventoAgendadoMail;
use Illuminate\Support\Facades\Mail;

class GoogleController extends Controller
{
    public function createCalendarEvent($user_name, $email, $date, $time)
    {

        try {

            $client = new Google_Client();
            $client->setAuthConfig(storage_path('app/private/google-oauth/credentials.json'));
            $client->addScope(Google_Service_Calendar::CALENDAR);
            $client->setAccessType('offline');

            // Aquí debes recuperar el token del usuario
            $accessToken = json_decode(file_get_contents(storage_path('app/private/google-oauth/token.json')), true);
            $client->setAccessToken($accessToken);

            if ($client->isAccessTokenExpired()) {
                $refreshToken = $client->getRefreshToken();
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
                $client->setAccessToken($newAccessToken);

                // Guardar el nuevo token
                file_put_contents(
                    storage_path('app/private/google-oauth/token.json'),
                    json_encode($client->getAccessToken())
                );
            }

            $service = new Google_Service_Calendar($client);


            $starttime = Carbon::parse("{$date} {$time}", 'America/Mexico_City');

            // Fin 1 hora después
            $end = (clone $starttime)->addHour();
            $endFormatted = $end->format('c');

            // Convertir al formato ISO 8601 con offset de zona horaria
            $startformatted = $starttime->format('c'); // Equivalente a Y-m-d\TH:i:sP

            $event = new Google_Service_Calendar_Event([
                'summary' => 'Reunión con el usuario',
                'description' => 'Sesión con el usuario vía Google Meet',
                'start' => new Google_Service_Calendar_EventDateTime([
                    'dateTime' => $startformatted, // '2025-06-05T11:00:00-06:00' horario local
                    'timeZone' => 'America/Mexico_City',
                ]),
                'end' => new Google_Service_Calendar_EventDateTime([
                    'dateTime' => $endFormatted,
                    'timeZone' => 'America/Mexico_City',
                ]),
                'conferenceData' => new Google_Service_Calendar_ConferenceData([
                    'createRequest' => new Google_Service_Calendar_CreateConferenceRequest([
                        'requestId' => uniqid(), // puede ser uniqid()
                        'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    ]),
                ]),
                'attendees' => [
                    ['email' => $email],
                    ['email' => "riosirving04@gmail.com"]
                ],
            ]);

            $event = $service->events->insert('primary', $event, [
                'conferenceDataVersion' => 1,
            ]);

            $meetLink = $event->hangoutLink;

            $meetLink = $event->getHangoutLink() ?? 'No se pudo generar el enlace Meet';

            \Log::info("Meet link a enviar por correo: " . $meetLink);

            $correos = [
                ['email' => $email, 'name' => $user_name],
                ['email' => 'riosirving04@gmail.com', 'name' => 'Irving Rios'],

            ];

            foreach ($correos as $destinatario) {
                Mail::to($destinatario['email'])
                    ->send(new EventoAgendadoMail($destinatario['name'], $meetLink));
            }

            /*  Mail::to($email)->send(new EventoAgendadoMail($user_name, $meetLink)); */

            return $meetLink;
        } catch (\Exception $e) {
            \Log::error("Error al crear evento en Google Calendar: " . $e->getMessage());
        }
    }

    public function redirect()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        return redirect()->away($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $code = $request->input('code');

        if (!$code) {
            return response()->json(['error' => 'No authorization code received']);
        }

        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            return response()->json(['error' => $token['error']]);
        }

        \Storage::disk('local')->put('google-oauth/token.json', json_encode($token));


        return '✅ Token guardado correctamente.';
    }
}
