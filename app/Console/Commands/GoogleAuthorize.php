<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google_Client;

class GoogleAuthorize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:authorize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene el token OAuth2 de Google y lo guarda localmente';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-oauth/credentials.json'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $redirectUri = 'https://localhost:443/oauth2callback';
        $client->setRedirectUri($redirectUri);

        $authUrl = $client->createAuthUrl();
        $this->info("Abre esta URL en tu navegador:\n$authUrl");

        $this->info("Después de permitir el acceso, copia el parámetro `code=` de la URL de redirección y pégalo aquí.");
        $authCode = $this->ask('Código de autorización (code)');

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        if (isset($accessToken['error'])) {
            $this->error("Error al obtener token: " . $accessToken['error_description']);
            return 1;
        }

        file_put_contents(storage_path('app/google-oauth/token.json'), json_encode($accessToken));
        $this->info("✅ Token guardado en `storage/app/google-oauth/token.json`");
        return 0;
    }
}
