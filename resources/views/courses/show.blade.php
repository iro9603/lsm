<x-app-layout>
    <x-container class="mt-12 mb-14">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="col-span-1 lg:col-span-2 order-2 lg:order-1">

                {{-- Portada --}}
                <div class="mb-6 ">
                    <h1 class="text-3xl tracking-tight font-semibold text-gray-100">{{ $course->title }}</h1>
                    <p class="mb-2 text-gray-300">{{ $course->summary }}</p>

                    <figure>
                        <img class="w-full aspect-video object-cover object-center" src="{{ $course->image }}" alt="">
                    </figure>
                </div>



                {{-- Objetivos --}}

                <div class="mb-8 ">
                    <h2 class="text-3xl tracking-tight font-semibold mb-4 text-gray-100">
                        Objetivos del curso
                    </h2>



                    <div
                        class="flex items-center bg-white/10 border border-white/20 rounded-xl p-4 mb-4 text-white backdrop-blur">
                        <ul class="grid grid-cols-1 lg:grid-cols-2 gap-4 ">
                            @foreach ($course->goals as $goal)
                            <li class="flex space-x-1">
                                <svg class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ $goal->name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="flex items-center justify-center my-8">
                    <div class="w-full h-px bg-white/20"></div>
                    <div class="mx-4 text-white/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="w-full h-px bg-white/20"></div>
                </div>



                {{-- Curriculum --}}

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-100">
                        Temario del curso
                    </h2>

                    <ul class="space-y-4">
                        @foreach ($course->sections as $section)
                        <li x-data="{ open: false }">
                            <div
                                class="justify-between items-center bg-white/10 border border-white/20 rounded-lg p-4 text-gray-100 hover:bg-white/20 transition">

                                <button x-on:click="open = !open" class=" flex w-full p-3 text-left">

                                    <span class="text-xl font-semibold ">
                                        {{ $section->name }}
                                    </span>

                                    <span class="ml-auto">
                                        {{ $section->lessons->count() }} clases
                                    </span>
                                </button>

                                <div class="p-4" x-show="open" x-cloak>
                                    <div
                                        class="my-8 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent">
                                    </div>
                                    <ul>
                                        @foreach ($section->lessons->sortBy('position') as $lesson)
                                        <li>
                                            <a class="flex justify-between items-center"
                                                href="{{ route('courses.status', [$course, $lesson]) }}">
                                                <div class="flex items-center">
                                                    <i class="far fa-play-circle text-blue-500 mt-0.5 mr-2"></i>
                                                    <span
                                                        class="font-semibold text-gray-100 hover:text-blue-500 text-sm">
                                                        {{ $lesson->name }}
                                                    </span>
                                                </div>

                                                <span class="text-sm text-gray-400 ml-4">
                                                    {{ gmdate('i:s', $lesson->duration) }}
                                                </span>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                </div>
                <div class="flex items-center justify-center my-8">
                    <div class="w-full h-px bg-white/20"></div>
                    <div class="mx-4 text-white/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="w-full h-px bg-white/20"></div>
                </div>
                {{-- Requisitos --}}

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-100">
                        Requisitos del curso
                    </h2>

                    <ul class="list-disc list-inside text-gray-200 space-y-1">
                        @foreach ($course->requirements as $requirement)
                        <li>
                            {{ $requirement->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex items-center justify-center my-8">
                    <div class="w-full h-px bg-white/20"></div>
                    <div class="mx-4 text-white/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="w-full h-px bg-white/20"></div>
                </div>

                {{-- Descripcion --}}

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-100">
                        Descripción
                    </h2>

                    <div class="text-gray-300">
                        {!! $course->description !!}
                    </div>
                </div>

                {{-- Reseñas --}}
                @if ($course->reviews->count())
                <div>
                    @livewire(
                    'manage-reviews',
                    [
                    'course' => $course,
                    ],
                    key('manage-reviews')
                    )
                </div>
                @endif

            </div>

            <div class="col-span-1 order-1 lg:order-2">
                <div class="bg-gray-100 rounded-lg shadow p-6">
                    <div class="mb-4">


                        @can('enrolled', $course)
                        <p class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="current h-5 w-5 mr-2" viewBox="0 0 56 56"
                                xml:space="preserve">

                                <path
                                    d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 27.9765 32.2422 C 29.1014 32.2422 29.7343 31.6094 29.7577 30.3906 L 30.1093 18.0156 C 30.1327 16.8203 29.1952 15.9297 27.9530 15.9297 C 26.6874 15.9297 25.7968 16.7968 25.8202 17.9922 L 26.1249 30.3906 C 26.1483 31.5859 26.8046 32.2422 27.9765 32.2422 Z M 27.9765 39.8594 C 29.3124 39.8594 30.5077 38.7812 30.5077 37.4219 C 30.5077 36.0390 29.3358 34.9844 27.9765 34.9844 C 26.5936 34.9844 25.4452 36.0625 25.4452 37.4219 C 25.4452 38.7578 26.6171 39.8594 27.9765 39.8594 Z" />

                            </svg>
                            <span class="font-semibold">
                                Adquirido el {{ $course->dateOfAcquisition->format('d/m/Y') }}
                            </span>
                        </p>
                        <a href="{{ route('courses.status', $course) }}"
                            class="btn btn-red block text-center uppercase w-full">
                            Continuar con el curso
                        </a>
                        @else
                        <p class="font-semibold text-2xl text-center mb-2">
                            @if ($course->price->value == 0)
                            <span class="text-green-500">
                                Gratis
                            </span>
                            @else
                            <span class="text-gray-700">
                                {{ number_format($course->price->value, 2) }} USD
                            </span>
                            @endif
                        </p>
                        @livewire('course-enrolled', ['course' => $course])
                        @endcan
                    </div>

                    <div>
                        <p class="font-semibold text-lg mb-1">
                            Detalle del curso
                        </p>

                        <ul class="space-y-1">
                            <li>
                                <i class="far fa-calendar-alt inline-block w-6"></i> Ultima actualización:
                                {{ $course->updated_at->format('d/m/Y') }}
                            </li>
                            <li>
                                <i class="far fa-clock inline-block w-6"></i> Duración total:
                                @if ($totalDuration > 0)
                                @php
                                $hours = floor($totalDuration / 3600);
                                $minutes = floor(($totalDuration % 3600) / 60);
                                $seconds = $totalDuration % 60;
                                @endphp
                                {{ $hours }}h {{ $minutes }}min {{ $seconds }}s
                                @else
                                Sin lecciones aún
                                @endif
                            </li>
                            <li>
                                <i class="fas fa-chart-line inline-block w-6"></i> Nivel:
                                {{ $course->level->name }}
                            </li>

                            <li>
                                <i class="fas fa-star inline-block w-6"></i> Calificación:
                                5
                            </li>

                            <li>
                                <i class="fas fa-infinity inline-block w-6"></i> Accesso de por vida
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </x-container>
</x-app-layout>