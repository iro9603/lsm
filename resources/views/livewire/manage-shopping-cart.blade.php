<div>
    <h1 class="text-xl font-semibold mb-2 text-gray-200">
        Carrito de compras
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 m-32">
        <div class="col-span-1 lg:col-span-3">
            <div class="bg-gray-100 rounded-lg shadow-lg p-6 mb-4">
                <ul class="space-y-4">
                    @forelse (Cart::instance('shopping')->content() as $item)
                    <li class="flex">
                        <figure class="w-full lg:w-40 shrink-0">
                            <img src="{{ $item->options->image }}" class="w-full aspect-video  object-cover rounded-lg">
                        </figure>

                        <div class="flex-1 ml-4 overflow-hidden">
                            <h2 class="font-semibold truncate">
                                <a href="">{{ $item->name }}</a>
                            </h2>
                            <p class="text-gray-500">
                                Prof: {{ $item->options->teacher }}
                            </p>
                            <p class="font-semibold">
                                {{ number_format($item->price, 2) }} USD ({{ number_format($item->price_mxn) }})
                            </p>
                        </div>

                        <div class="ml-6">
                            <button wire:click="remove('{{ $item->rowId }}')" class="text-sm text-red-600 font-bold">
                                Eliminar
                            </button>
                        </div>
                    </li>

                    @empty
                    <li>
                        <p class="text-gray-500">No hay productos en el carrito. <a href="{{ route('courses.index') }}"
                                class="text-blue-500 hover:text-blue-600">Ver todos los cursos</a></p>
                    </li>
                    @endforelse
                </ul>
            </div>

            @if (Cart::instance('shopping')->count())
            <button wire:click="destroy" class="font-semibold text-red-500 text-sm"><i
                    class="fas fa-trash-alt mr-2"></i>
                Vaciar el carrito de compras</button>
            @endif


        </div>
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold">Resumen</h2>
                <div class="flex justify-between items-center">
                    <p class="text-2xl">Total:</p>
                    <p class="text-lg">{{ number_format(Cart::instance('shopping')->subtotal(), 2) }} USD</p>

                </div>
                <div class="mt-4">

                    @if (Cart::instance('shopping')->count() > 0)

                    <a href="{{ route('checkout.index') }}" class="btn btn-red block w-full text-center">
                        Proceder con el pago
                    </a>

                    @else
                    <button disabled class="btn btn-red block w-full text-center disabled:opacity-50">
                        Proceder con el pago
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>