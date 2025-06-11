<x-app-layout>
    <x-container class="mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-12">
            <div class="order-2 lg:order-1 col-span-1 lg:col-span-3">
                <div class="bg-gray-100 rounded-lg shadow-lg p-6 mb-4">
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
                <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-semibold">Resumen</h2>
                    <div class="flex justify-between items-center">
                        <p class="text-2xl">Total:</p>
                        <p class="text-lg">{{ number_format(Cart::instance('shopping')->subtotal(), 2) }} USD</p>

                    </div>
                    <div class="mt-4">
                        <div id="paypal-button-container"></div>
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
                        window.location.href = "{{ route('success') }}"
                    }).catch(err => {
                        console.log(err);

                    }
                    );
                },
            }).render('#paypal-button-container')
        </script>


    @endpush

</x-app-layout>