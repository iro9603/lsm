<div>

    <!-- Modal -->
    <div class="flex items-center justify-center ">


        <!-- Contenedor modal -->
        <div class="bg-gray-100 rounded-xl p-6 shadow-lg w-full max-w-2xl ">

            <!-- Imagen y título -->
            <div class="flex flex-col items-center text-center">
                <img src="https://via.placeholder.com/80" alt="Tutor" class="rounded-full mb-3">
                <h2 class="text-xl font-bold">Contact {{ $tutorName }}</h2>
                <p class="text-sm text-gray-600 mb-4">
                    Introduce yourself to the tutor, share your learning goals and ask any questions
                </p>
            </div>

            <!-- Formulario -->
            <form wire:submit.prevent="save" class="mb-5">

                <div class="mb-4">
                    <x-validation-errors />
                    <textarea wire:model="content" placeholder="Hi {{ $tutorName }}!"
                        class="w-full border bg-gray-100 rounded-lg p-3 focus:ring-2 focus:ring-pink-500"
                        rows="3"></textarea>

                </div>
                <div class="flex justify-end">
                    <button class="mt-4 px-5 w-fit bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-lg">
                        Send message
                    </button>
                </div>
            </form>

            @if ($mensajes->count())
            <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                <ul>
                    @foreach ($messages as $message )
                    <li class="flex">
                        <div class="mr-4 shrink-0">
                            <img class="h-8 w*8 rounded-full object-cover object-center"
                                src="{{$message->user->profile_photo_url }}" alt="">
                        </div>
                        <div class="flex-1">
                            <p>
                                <b> {{ $message->user->name }}</b>
                                <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                            </p>

                            <div>{{ $message->content }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
    </div>
</div>