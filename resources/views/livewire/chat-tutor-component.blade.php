<div x-data="data()"
    class="bg-gray-50 w-full rounded-lg mx-auto  shadow border border-gray-200 overflow-hidden h-[calc(100vh-4rem)]">
    <div class="  flex flex-col md:flex-row divide-x divide-gray-200 h-full">
        <!-- Columna izquierda -->
        <div class="w-full md:w-1/3 border flex flex-col {{ $chat || $contactChat ? 'hidden md:flex' : 'flex' }}">
            <!-- header contactos -->
            <div class=" bg-gray-100 h-16 flex items-center px-4"> <img class="w-10 h-10 object-cover object-center"
                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"> </div> <!-- buscador -->
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
                                <figure class="flex-shrink-0"> <img
                                        class="h-12 w-12 object-cover object-center rounded-full "
                                        src=" {{ $contact->user->profile_photo_url }}" alt="{{ $contact->name }}">
                                </figure>
                                <div class="flex-1 ml-5 border-b border-gray-200">
                                    <p class="text-gray-800"> {{ $contact->name }} </p>
                                </div>
                            </div>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                @else
                @foreach ($this->chats as $chatItem) <div wire:key="chats-{{ $chatItem->id }}"
                    wire:click="open_chat({{ $chatItem }})"
                    class="flex items-center justify-between {{ $chat && $chatItem->id == $chat->id ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 cursor-pointer px-3">
                    <figure> <img src="{{ $chatItem->image }}" class="h-12 w-12 object-cover object-center rounded-full"
                            src="" alt="{{ $chatItem->name }}"> </figure>
                    <div class="w-[calc(100%-4rem)] py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <p> {{ $chatItem->users->where('id', '!=', Auth::id())->first()->name }} </p>
                            <p class="text-xs"> {{ $chatItem->last_message_at->format('h:i:A') }} </p>
                        </div>
                        <p class="text-sm text-gray-700 mt-1 truncate">{{ $chatItem->messages->last()->body }}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <!-- Columna derecha (chat) -->
        <div class="w-full md:w-2/3 border flex flex-col h-full">
            @if ($contactChat || $chat)
            <!-- header -->
            <div class="bg-gray-100 h-16 flex items-center px-3"> <button class="md:hidden mr-3 text-gray-700"
                    wire:click="closeChat"> <i class="fa fa-arrow-left"></i> </button>
                <figure>
                    @if ($chat) <img class="w-10 h-10 rounded-full object-cover object-center" src="{{ $chat->image }}"
                        alt="{{ $chat->name }}">
                    @else <img class="w-10 h-10 rounded-full object-cover object-center"
                        src="{{ $contactChat->user->profile_photo_url }}" alt="{{ $contactChat->name }}">
                    @endif
                </figure>
                <div class="ml-4">
                    <p class="text-gray-800">
                        @if($chat)
                        {{ $chat->users->where('id', '!=', Auth::id())->first()->name }}
                        @elseif($contactChat)
                        {{ $contactChat->user->name }}
                        @endif
                    </p>

                    <p class="text-gray-600 text-xs" x-show="chat_id === typingChatId">
                        Escribiendo...
                    </p>

                    @if ($this->active)

                    <p class="text-green-500   text-xs" x-show="chat_id != typingChatId" id="online">
                        Online
                    </p>
                    @else
                    <p class="text-red-600  text-xs" x-show="chat_id != typingChatId" id="offline">
                        Offline
                    </p>
                    @endif
                </div>
            </div> <!-- contenedor de mensajes + input -->
            <div class="flex-1 overflow-auto">
                <!-- mensajes (scrollable) -->
                <div class="flex-1 overflow-y-auto p-4 space-y-2 bg-gray-50">
                    @foreach ($this->messages as $message)
                    <div class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : '' }} mb-2">
                        <div
                            class="rounded px-3 py-2 {{ $message->user_id == Auth::id() ? 'bg-green-100' : 'bg-gray-200' }}">
                            <p class="text-sm">{{ $message->body }}</p>
                            <p
                                class="text-xs text-gray-600 mt-1 {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                                {{ $message->created_at->format('d:m:y h:i:A') }} </p>
                        </div>
                    </div>
                    @endforeach
                    <span id="final"></span>
                </div>
            </div> <!-- input fijo abajo -->
            <form wire:submit.prevent="sendMessage" class="bg-gray-100 h-16 flex items-center px-4 flex-shrink-0">
                <x-input wire:model.live="bodyMessage" type="text" class="flex-1"
                    placeholder="Escriba un mensaje aqui" />
                <button type="submit" class="flex-shrink-0 ml-4 text-2xl text-gray-700"> <i class="fas fa-share"></i>
                </button>
            </form>
            @else
            <!-- placeholder -->
            <div class="w-full h-full flex justify-center items-center"> <img class="object-cover object-center w-32"
                    src="{{ asset('storage/chaticon.png') }}" alt=""> </div>
            @endif
        </div>
    </div>
    @push('js')
    <script>
        function data() {
            return {
                chat_id: @entangle('chat_id'),
                typingChatId: null,

                init() {
                    Echo.private('App.Models.User.' + {{ Auth::id() }})
                        .listen('.UserTyping', (e) => {
                            // cuando el otro usuario escribe en este chat
                            if (e.chat_id === this.chat_id) {
                                this.typingChatId = e.chat_id;

                                // reiniciar el indicador después de 3s sin actividad
                                clearTimeout(this._typingTimeout);
                                this._typingTimeout = setTimeout(() => {
                                    this.typingChatId = null;
                                }, 3000);
                            }
                        });
                }
            }
        }
        Livewire.on('scrollIntoView', function(){

            setTimeout(() => {

                var finalElement = document.getElementById('final');

                if (finalElement) {


                    finalElement.scrollIntoView({ behavior: 'smooth', block: 'end' });

                } else {

                    //console.error("Elemento con id 'final' no encontrado en el DOM.");

                }

            }, 5); 


       
        });
    </script>
    @endpush
</div>