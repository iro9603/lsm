<x-app-layout>

    @php
        \MercadoPago\MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
        $client = new \MercadoPago\Client\Preference\PreferenceClient();
        // Calcular el total
        $tarifa_porcentual = 0.0349;  // 3.49%
        $tarifa_fija = 4.00;          // $4.00 fijos

        $precio_base = 200;  // el precio real de tu producto/servicio

        $comision = ($precio_base * $tarifa_porcentual) + $tarifa_fija;
        $total_con_comision = $precio_base + $comision;

        $externalReference = $email . '|' . $selectedDate . ' ' . $selectedTime;
        $preference = $client->create([
            "items" => array(
                array(
                    "title" => "",
                    "quantity" => 1,
                    "unit_price" => 2000 /* $total_con_comision */
                )
            ),
            "external_reference" => $externalReference,

            'metadata' => [
                "email" => $email,
                "date" => $selectedDate,
                "time" => $selectedTime
            ],
            "back_urls" => [
                "success" => route('success'),
                "failure" => route('asesoria'),
                "pending" => "https://www.tu-sitio/pending"
            ],
            "notification_url" => "https://9204-189-136-27-196.ngrok-free.app/api/mercadopago/webhook",
            "auto_return" => "approved"
        ]);

    @endphp
    <x-container>
        <!-- Hidden input to store your integration public key -->
        <input type="hidden" id="mercado-pago-public-key" value="APP_USR-4c8a433b-f8fb-4e80-a192-0fcf80c456f7">

        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-4 mt-4">
            <div class="col-span-4 ">
                <div class="max-w-3xl mx-auto p-6 bg-white shadow-xl rounded-2xl">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Resumen de tu compra</h2>

                    <ul class="divide-y divide-gray-200">

                        <li class="py-4 flex items-center justify-between">
                            <div>
                                <p class="text-lg font-medium text-gray-900">Desglose</p>
                                <p class="text-sm text-gray-600">
                                    Clase:
                                    {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d \d\e F \d\e Y') }}
                                    a las {{ \Carbon\Carbon::parse($selectedTime)->format('H:i') }}
                                </p>
                                <p class="text-sm text-gray-600">Comisión</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-800">${{ number_format($precio_base, 2) }}</p>
                                <p class="text-lg font-semibold text-gray-800">${{ number_format($comision, 2) }}</p>
                            </div>
                        </li>


                    </ul>

                    <div class="border-t pt-4 mt-4 flex justify-between items-center">
                        <span class="text-xl font-semibold text-gray-800">Total:</span>
                        <span
                            class="text-xl font-bold text-indigo-600">${{ number_format($total_con_comision, 2) }}</span>
                    </div>

                    <div class="mt-6 text-right">
                        <div id="walletBrick_container"></div>
                    </div>
                </div>
            </div>
            <div class="col-span-3 bg-white shadow-xl  rounded-2xl p-4">

                <div class="flex flex-col justify-center items-center">

                </div>

            </div>
        </div>




        {{-- <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-4 mt-4">
            <div class="col-span-4 card">

            </div>
            <div class="col-span-3  card p-4">

                <div class="flex flex-col justify-center items-center">
                    <label for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccione método de
                        pago</label>
                </div>

                <div>
                    <div id="walletBrick_container"></div>
                </div>
            </div>
        </div> --}}


    </x-container>

    {{--
    <script src="https://js.stripe.com/v3/"></script> --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        // Configure sua chave pública do Mercado Pago
        const publicKey = document.getElementById('mercado-pago-public-key').value;
        // Configure o ID de preferência que você deve receber do seu backend
        const preferenceId = "{{ $preference->id }}";

        // Inicializa o SDK do Mercado Pago
        const mp = new MercadoPago(publicKey, {
            locale: 'es-MX'
        });

        // Cria o botão de pagamento
        const bricksBuilder = mp.bricks();
        const renderWalletBrick = async (bricksBuilder) => {
            await bricksBuilder.create("wallet", "walletBrick_container", {
                initialization: {
                    preferenceId: preferenceId,
                    /* redirectMode: "blank" */
                },
                customization: {
                    theme: 'dark',
                    texts: {

                        action: 'buy',
                        valueProp: 'security_details'
                    }
                }
            });
        };

        renderWalletBrick(bricksBuilder);

    </script>
</x-app-layout>