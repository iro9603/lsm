<div>

    <div class="grid grid-cols-4 gap-6 mb-8">

        <div class="col-span-1">
            <p class="text-6xl fon-bold text-center">
                {{ $course->rating}}
            </p>
            <x-stars class="justify-center" rating="{{ $course->rating }}" />
            <p class="text-lg text-center">Valoraciones</p>
        </div>

        <div class="col-span-3">
            <ul>
                @for ($i = 5; $i >= 1; $i--)
                    <li class="flex items-center">
                        <x-progress-bar :width="$course->reviews->where('rating', $i)->count() ? round($course->reviews->where('rating', $i)->count() * 100 / $course->reviews->count(), 2) : 0"
                            class="flex-1" />
                        <x-stars rating="{{ $i }}" class="ml-4 mr-2" />
                        <span class="w-16">
                            {{ $course->reviews->where('rating', $i)->count() ? round($course->reviews->where('rating', $i)->count() * 100 / $course->reviews->count(), 2) : 0}}
                        </span>
                    </li>
                @endfor
            </ul>
        </div>

    </div>

    <ul class="space-y-6">
        @foreach ($reviews as $review)
            <li class="flex space-x-8">
                <figure class="shrink-0">
                    <img class="w-12 h-12 object-cover object-center rounded-full"
                        src="{{ $review->user->profile_photo_url }}" alt="">
                </figure>
                <div class="flex-1">
                    <p class="font-semibold">
                        {{ $review->user->name }}
                    </p>
                    <div class="flex space-x-2 items-center">
                        <x-stars rating="{{ $review->rating }}" class="inline" />
                        <p class="text-sm">{{ $review->created_at->diffForHumans() }}</p>
                    </div>

                    <div>
                        {{ $review->comment }}
                    </div>
                </div>


                @if (Auth::check() && $review->user_id === Auth::id())
                    <div class="shrink-0">
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link wire:click="edit({{ $review }})">
                                    Editar
                                </x-dropdown-link>
                                <x-dropdown-link wire:click="delete({{ $review }})">
                                    Eliminar
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

            </li>
        @endforeach
    </ul>
    {{-- Modal review --}}

    <x-dialog-modal wire:model="reviewEdit.open">
        <x-slot name="title">
            <p class="text-3xl font-semibold text-center mt-4 ">!Tu opinión importa!</p>
        </x-slot>
        <x-slot name="content">
            <p class="text-center mb-4">¿Cómo fue tu experiencia?</p>
            <ul x-data="{rating:@entangle('reviewEdit.rating')}" class="flex justify-center space-x-3 text-gray-600">
                <li>
                    <button x-on:click="rating = 1">
                        <i class="fas fa-star text-2xl" x-bind:class="rating >= 1 ? 'text-yellow-500' : ''"></i>
                    </button>
                </li>
                <li>
                    <button x-on:click="rating = 2">
                        <i class="fas fa-star text-2xl" x-bind:class="rating >= 2 ? 'text-yellow-500' : ''"></i>
                    </button>
                </li>
                <li>
                    <button x-on:click="rating = 3">
                        <i class="fas fa-star text-2xl" x-bind:class="rating >= 3 ? 'text-yellow-500' : ''"></i>
                    </button>
                </li>
                <li>
                    <button x-on:click="rating = 4">
                        <i class="fas fa-star text-2xl" x-bind:class="rating >= 4 ? 'text-yellow-500' : ''"></i>
                    </button>
                </li>
                <li>
                    <button x-on:click="rating = 5">
                        <i class="fas fa-star text-2xl" x-bind:class="rating >= 5 ? 'text-yellow-500' : ''"></i>
                    </button>
                </li>
            </ul>

            <x-textarea wire:model="reviewEdit.comment" class="w-full mt-4" placeholder="Mensaje..."></x-textarea>

        </x-slot>
        <x-slot name="footer">
            <x-button wire:click="update">Actualizar reseña</x-button>
        </x-slot>
    </x-dialog-modal>
</div>