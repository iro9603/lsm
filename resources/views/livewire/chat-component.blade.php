<div
    class="bg-gray-50 w-full h-[100vh] md:max-w-7xl md:h-[600px] rounded-lg mx-auto mt-0 md:mt-8 shadow border border-gray-200 overflow-hidden ">
    <div class="grid grid-cols-1 md:grid-cols-3 divide-x divide-gray-200 h-full">

        <!-- Columna izquierda -->
        <div class=" col-span-1 flex flex-col h-full md:block {{ $chat || $contactChat ? 'hidden' : 'block' }}">
            <!-- header contactos -->
            <div class=" bg-gray-100 h-16 flex items-center px-4">
                <img class="w-10 h-10 object-cover object-center" src="{{ Auth::user()->profile_photo_url  }}"
                    alt="{{ Auth::user()->name }}">
            </div>

            <!-- buscador -->
            <div class="bg-white h-14 flex items-center px-4">
                <x-input wire:model.live="search" type="text" class="w-full text-gray-400"
                    placeholder="Busque un chat" />
            </div>

            <!-- lista chats -->
            <div class="flex-1 overflow-auto border-t border-gray-200">

                @if ($this->chats->count() == 0 || $search)

                <div class="px-4 py-3">
                    <h2 class="text-teal-600 text-lg mb-4">Contactos</h2>

                    <ul class="space-y-4">
                        @forelse ($this->contacts as $contact)
                        <li class="cursor-pointer" wire:click="open_chat_contact({{ $contact }})">
                            <div class="flex">
                                <figure class="flex-shrink-0">
                                    <img class="h-12 w-12 object-cover object-center rounded-full "
                                        src=" {{ $contact->user->profile_photo_url  }}" alt="{{ $contact->name
                                }}">
                                </figure>

                                <div class="flex-1 ml-5 border-b border-gray-200">
                                    <p class="text-gray-800">
                                        {{ $contact->name }}
                                    </p>


                                </div>
                            </div>
                        </li>
                        @empty

                        @endforelse

                    </ul>
                </div>
                @else
                @foreach ($this->chats as $chatItem)
                <div wire:key="chats-{{ $chatItem->id }}" wire:click="open_chat({{ $chatItem }})"
                    class="flex items-center {{ $chat && $chatItem->id == $chat->id ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 cursor-pointer px-3">
                    <figure>
                        <img src="{{ $chatItem->image }}" class="h-12 w-12 object-cover object-center rounded-full"
                            src="" alt="{{ $chatItem->name }}">
                    </figure>
                    <div class="ml-4 flex-1 py-4 border-b border-gray-200">
                        <p>
                            {{ $chatItem->name}}
                        </p>
                        <p class="text-xs">
                            12:45pm
                        </p>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div>

        <!-- Columna derecha (chat) -->
        <div class="col-span-2 flex flex-col h-full ">

            <!-- header chat -->
            @if ($contactChat || $chat)
            <div class="bg-gray-100 h-16 flex items-center px-3">
                <!-- Botón atrás (solo móvil) -->
                <button class="md:hidden mr-3 text-gray-700" wire:click="closeChat">
                    <i class="fa fa-arrow-left"></i>
                </button>
                <figure>
                    @if ($chat)
                    <img class="w-10 h-10 rounded-full object-cover object-center" src="{{ $chat->image }}"
                        alt="{{ $chat->name }}">
                    @else
                    <img class="w-10 h-10 rounded-full object-cover object-center"
                        src="{{ $contactChat->user->profile_photo_url  }}" alt="{{ $contactChat->name }}">
                    @endif

                </figure>

                <div class="ml-4">
                    <p class="text-gray-800">
                        @if ($chat)
                        {{ $chat->name }}
                        @else

                        {{ $contactChat->name }}
                        @endif
                    </p>
                    <p class="text-green-500 text-xs">
                        Online
                    </p>
                </div>


            </div>

            <!-- mensajes -->
            <div class="flex-1 px-3 py-2 overflow-auto">

                {{-- El contenido del chat --}}
                @foreach ($this->messages as $message)
                <div class="flex justify-end mb-2">
                    <div class="rounded px-3 py-2 bg-green-100">
                        <p class="text-sm">{{ $message->body}}</p>
                        <p class="text-right text-xs text-gray-600 mt-1">{{ $message->created_at->format('d:m:y
                            h:i:A')}}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- input -->
            <form class="bg-gray-100 h-16 flex items-center px-4" action="" wire:submit.prevent="sendMessage()">
                <x-input wire:model="bodyMessage" type="text" class="flex-1" placeholder="Escriba un mensaje aqui" />
                <button class="flex-shrink-0 ml-4 text-2xl text-gray-700">
                    <i class="fas fa-share"></i>
                </button>
            </form>

            @else

            <div class="w-full h-full flex justify-center items-center">
                <div>
                    <img class="object-cover object-center w-32" src="{{ asset('storage/chaticon.png') }}" alt="">
                </div>
            </div>
            @endif

        </div>
    </div>
</div>