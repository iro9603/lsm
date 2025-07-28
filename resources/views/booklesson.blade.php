<x-app-layout>

    <x-container>
        <!-- Hidden input to store your integration public key -->
        <input type="hidden" id="mercado-pago-public-key" value="APP_USR-4c8a433b-f8fb-4e80-a192-0fcf80c456f7">

        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-7 mt-4">

            <!-- Resumen de la compra -->
            <div class="col-span-full md:col-span-4">
                <div class="max-w-3xl mx-auto p-6 bg-white shadow-xl rounded-2xl">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Resumen de tu compra</h2>

                    <ul class="divide-y divide-gray-200">
                        <li class="py-4 flex items-center justify-between">
                            <div>
                                <p class="text-lg font-medium text-gray-900">Desglose</p>
                                <p class="text-sm text-gray-600">
                                    Clase:
                                    {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d \d\e F \d\e Y') }}
                                    a las {{ \Carbon\Carbon::parse($selectedTime)->format('H:i') }}
                                </p>
                                <p class="text-sm text-gray-600">Cargos por servicio</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-800">${{ number_format($precio_base, 2) }}</p>
                                <p class="text-lg font-semibold text-gray-800">${{ number_format($comision, 2) }}</p>
                            </div>
                        </li>
                    </ul>

                    <div class="border-t pt-4 mt-4 flex justify-between items-center">
                        <span class="text-xl font-semibold text-gray-800">Total:</span>
                        <span class="text-xl font-bold text-indigo-600">
                            ${{ number_format($total_con_comision, 2) }}
                        </span>
                    </div>

                    <div class="mt-6 text-right">
                        <div id="walletBrick_container"></div>
                    </div>
                </div>
            </div>

            <!-- Bloque de tiempo restante -->
            <div
                class="col-span-full md:col-span-2 mx-auto w-full max-w-sm bg-white shadow-xl rounded-2xl p-6 flex flex-col items-center text-center space-y-4">

                <!-- Icono de advertencia -->
                <div class="bg-red-100 text-red-600 rounded-full p-3">
                    <img src="{{ asset('storage/icons/reloj.svg') }}" alt="Reloj" class="w-10 h-10">
                </div>

                <!-- Mensaje principal -->
                <p class="text-gray-700 text-base">
                    El horario fue bloqueado temporalmente.
                </p>

                <!-- Reloj visual con tiempo restante -->
                <p id="countdown" class="text-2xl font-bold text-red-600">15:00</p>

                <!-- Mensaje adicional -->
                <p class="text-sm text-gray-600">
                    Tienes <span class="font-semibold text-red-500">15 minutos</span> para completar el pago. El horario
                    será liberado si no se completa la transacción.
                </p>

                <!-- Botón de cancelar -->
                <form action="{{ route('cancelar.reserva') }}" method="POST">
                    @csrf
                    <input type="hidden" name="date" value="{{ $selectedDate }}">
                    <input type="hidden" name="time" value="{{ $selectedTime }}">

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        Cancelar y volver
                    </button>
                </form>
            </div>

        </div>




    </x-container>

    @push('js')

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const expirationTime = new Date("{{ $blocked_until }}").getTime();
        function updateCountdown() {
            const now = new Date().getTime();
            const timeRemaining = expirationTime - now;
            if (timeRemaining <= 0) {
                document.getElementById('countdown').innerText = '00:00';
                window.location.href = "{{ route('asesoria') }}";
            } else {
                const minutes = String(Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                const seconds = String(Math.floor((timeRemaining % (1000 * 60)) / 1000)).padStart(2, '0');
                document.getElementById('countdown').innerText = `${minutes}:${seconds}`;
                setTimeout(updateCountdown, 1000);
            }
        }

        updateCountdown();

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
    @endpush


</x-app-layout>