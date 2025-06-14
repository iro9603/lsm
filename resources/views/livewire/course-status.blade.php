<div>
    @push('css')
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    @endpush

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="col-span-1 lg:col-span-2">

            @if (Gate::allows('enrolled', $course) || $current->is_preview)

                <div wire:ignore>
                    @if ($current->platform == 1)
                        <video id="player" playsinline controls data-poster="{{ $current->image }}">
                            <source src="{{ Storage::url($current->video_path) }}" type="video/mp4">
                        </video>
                    @else

                        <div class="plyr__video-embed" id="player">
                            <iframe src="https://www.youtube.com/embed/{{ $current->video_path }}" allowfullscreen
                                allowtransparency allow="autoplay"></iframe>
                        </div>
                    @endif
                </div>

            @else

                <div class="relative">
                    <figure>
                        <img class="w-full aspect-video object-cover object-center" src="{{ $current->image }}" alt="">
                    </figure>
                </div>

                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center">
                    <p class="uppercase text-3xl font-mono font-bold text-white">
                        Adquiere el curso
                    </p>

                    <i class="fas fa-unlock text-5xl text-white"></i>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-primary mt-4">
                        Comprar curso
                    </a>
                </div>

            @endif




            <h1 class="text-3xl font-semibold mt-4 text-gray-200">
                {{ $orderLessons->search($current['id']) + 1 }}. {{ $current->name }}
            </h1>


            @if ($current->description)
                <p class="text-gray-600 mt-2">
                    {{ $current->description }}
                </p>
            @endif

            @auth
                <div class="flex items-center space-x-2 text-gray-200">
                    <x-toggle wire:model="completed" label="Marcar esta unidad como culminada" />
                </div>
            @endauth

            <div class="bg-gray-200 shadow-xl rounded-lg px-6 py-4 mt-2">
                <div class="flex justify-between">
                    <button wire:click="previousLesson()" class="font-bold">Tema anterior</button>
                    <button wire:click="nextLesson()" class="font-bold">Siguiente tema</button>
                </div>
            </div>

        </div>
        <div class="col-span-1">
            <aside class="card mb-4 bg-gray-200">
                <h1 class="text-2xl leading-8 text-center mb-4">
                    <a class="hover:text-blue-600" href="{{ route('courses.show', $course) }}">
                        {{ $course->title }}
                    </a>
                </h1>

                {{-- Informacion del profesor --}}

                <div class="flex items-center">
                    <figure class="mr-4 shrink-0">
                        <img class="w-12 h-12 object-cover rounded-full"
                            src="{{ $course->teacher->profile_photo_url }}">
                    </figure>

                    <div class="flex-1">
                        <p>
                            Profesor: {{ $course->teacher->name }}
                        </p>
                    </div>
                </div>

                {{-- Avance --}}
                <div class="mt-2">
                    <p class="text-gray-600 text-sm">
                        {{ $advance }}% completado
                    </p>


                    <div class="relative pt-1">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                            <div style="width:{{ $advance }}%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Secciones --}}
                <ul class="space-y-4 text-gray-600">

                    @foreach ($sections as $section)
                        <li x-data="{open:'{{ $section['id'] == $current->section_id }}'}">
                            <button x-on:click="open = !open" class="text-left flex justify-between">
                                <span>
                                    {{ $section['name'] }}
                                </span>
                                <i class=" mt-1 fas" x-bind:class="open ? 'fa-angle-up':'fa-angle-down'">

                                </i>
                            </button>

                            <ul class="space-y-1 mt-2" x-show="open" x-cloak>

                                @foreach ($section['lessons'] as $lesson)

                                    <li>
                                        <a class="w-full flex" href="{{ route('courses.status', [$course, $lesson['slug']]) }}">
                                            <i
                                                class="fa-solid {{ $lesson['id'] == $current->id ? 'fa-circle-dot' : 'fa-circle' }}   mr-2 mt-1 {{ $open_lessons->where('user_id', Auth::id())->where('lesson_id', $lesson['id'])->where('completed', 1)->count() ? 'text-yellow-500' : '' }}"></i>
                                            <span>
                                                {{ $orderLessons->search($lesson['id']) + 1 }}. {{ $lesson['name']}}

                                            </span>
                                        </a>
                                    </li>

                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </aside>

            @can('review_enabled', $course)
                <x-button wire:click="$set('review.open', true)" class="w-full flex justify-center">
                    Calificar este curso
                </x-button>

            @endcan

        </div>
    </div>

    {{-- Modal review --}}

    <x-dialog-modal wire:model="review.open">
        <x-slot name="title">
            <p class="text-3xl font-semibold text-center mt-4 ">!Tu opinión importa!</p>
        </x-slot>
        <x-slot name="content">
            <p class="text-center mb-4">¿Cómo fue tu experiencia?</p>
            <ul x-data="{rating:@entangle('review.rating')}" class="flex justify-center space-x-3 text-gray-600">
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

            <x-textarea wire:model="review.comment" class="w-full mt-4" placeholder="Mensaje..."></x-textarea>

        </x-slot>
        <x-slot name="footer">
            <x-button wire:click="storeReview">Dejar reseña</x-button>
        </x-slot>
    </x-dialog-modal>

    @push('js')
        <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>

        <script>
            const player = new Plyr('#player');
            /* player.on('ready', event => {
                player.play();
            }); */

            player.on('ended', event => {
                @this.call('completedLesson');
            });
        </script>

    @endpush
</div>