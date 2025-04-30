<x-app-layout>
    <x-container class="mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-12">
            <div class="order-2 lg:order-1 col-span-1 lg:col-span-3">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-4">
                    <ul class="space-y-4">
                        @forelse (Cart::instance('shopping')->content() as $item)

                            <li class="lg:flex">
                                <figure class="w-full lg:w-40 shrink-0">
                                    <img src="{{ $item->options->image }}"
                                        class="w-full aspect-video  object-cover rounded-lg">
                                </figure>

                                <div class="lg:flex-1 lg:ml-4 overflow-hidden">
                                    <h2 class="font-semibold truncate">
                                        <a href="">{{ $item->name }}</a>
                                    </h2>
                                    <p class="text-gray-500">
                                        Prof: {{ $item->options->teacher }}
                                    </p>
                                    <p class="font-semibold">
                                        {{ number_format($item->price, 2) }} USD
                                    </p>
                                </div>
                            </li>

                        @empty
                            <li>
                                <p class="text-gray-500">No hay productos en el carrito</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="order-1 lg:order-2 col-span-1 lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-semibold">Resumen</h2>
                    <div class="flex justify-between items-center">
                        <p class="text-2xl">Total:</p>
                        <p class="text-lg">{{ number_format(Cart::instance('shopping')->subtotal(), 2) }} USD</p>

                    </div>
                    <div class="mt-4">
                        <div
                            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <h5 class="mb-2 text-2xl  tracking-tight text-gray-900 dark:text-white">
                                    ¿Deseas completar el pago mediante transferencia bancaria o tarjeta?
                                </h5>
                                <p class="mb-2 text-1xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    !Al pagar con tarjeta bancaria se aplicará un cargo adicional para cubrir
                                    costos de procesamiento!
                                </p>
                            </a>


                            <label for="countries"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Método de
                                Pago</label>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="transfer" selected>Transferencia (sin cargo extra)</option>
                                <option value="card">Tarjeta</option>
                            </select>


                            {{-- <div class="flex justify-between gap-2 mt-2">
                                <a href="#"
                                    class="inline-flex items-center border border-indigo-300 px-3 py-1.5 rounded-md text-indigo-500 hover:bg-indigo-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16l-4-4m0 0l4-4m-4 4h18">
                                        </path>
                                    </svg>
                                    <span class="ml-1 font-bold text-lg">Back</span>
                                </a>
                                <a href="#"
                                    class="inline-flex items-center border border-indigo-300 px-3 py-1.5 rounded-md text-indigo-500 hover:bg-indigo-50">
                                    <span class="mr-1 font-bold text-lg">Next</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3">
                                        </path>
                                    </svg>
                                </a>
                            </div> --}}
                            <div id="paypal-button-container"></div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </x-container>

    @push('js')

        <script
            src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
            data-sdk-integration-source="developer-studio"></script>
        <script>
            paypal.Buttons({
                createOrder() {
                    return axios.post("{{ route('checkout.createPaypalOrder') }}").then(res => {
                        return res.data.id;
                    }).catch(err => {
                        console.log(err);

                    }
                    );
                },
                onApprove(data) {
                    return axios.post("{{ route('checkout.capturePaypalOrder') }}", {
                        orderId: data.orderID
                    }).then(function (res) {
                        window.location.href = "{{ route('gracias') }}"
                    }).catch(err => {
                        console.log(err);

                    }
                    );
                },
            }).render('#paypal-button-container')
        </script>


    @endpush

</x-app-layout>