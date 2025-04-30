<x-app-layout>
    <x-container class="mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="col-span-1 lg:col-span-2 order-2 lg:order-1">

                {{-- Portada --}}
                <div>
                    <h1 class="text-2xl font-semibold">{{ $course->title }}</h1>
                    <p class="mb-2">{{ $course->summary }}</p>

                    <figure>
                        <img class="w-full aspect-video object-cover object-center" src="{{ $course->image }}" alt="">
                    </figure>
                </div>

                {{-- Objetivos --}}

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">
                        Objetivos del curso
                    </h2>

                    <div class="bg-white rounded-lg shadow p-6">
                        <ul class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-gray-800">
                            @foreach ($course->goals as $goal)
                                <li class="flex space-x-4">
                                    <i class="fa-regular fa-circle-check text-lg"></i>
                                    <p>
                                        {{ $goal->name }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>


                {{-- Curriculum --}}

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">
                        Temario del curso
                    </h2>

                    <ul class="space-y-4">
                        @foreach ($course->sections as $section)
                            <li
                                x-data="{
                                                                                                                                                                                                                                                                                                                                                                                                open:false
                                                                                                                                                                                                                                                                                                                                                                                            }">
                                <div class="bg-white rounded-lg">

                                    <button x-on:click="open = !open" class="flex w-full p-4 bg-gray-50 text-left border-b">
                                        <span class="text-xl font-semibold">
                                            {{ $section->name }}
                                        </span>

                                        <span class="ml-auto">
                                            {{ $section->lessons->count() }} clases
                                        </span>
                                    </button>

                                    <div class="p-4" x-show="open" x-cloak>
                                        <ul>
                                            @foreach ($section->lessons as $lesson)

                                                <li>
                                                    <a class="flex" href="">
                                                        <i class="far fa-play-circle text-blue-500 mt-0.5 mr-2"></i>

                                                        <span class="font-semibold text-gray-600 hover:blue  text-sm">
                                                            {{ $lesson->name }}
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

                {{-- Requisitos --}}

                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">
                        Requisitos del curso
                    </h2>

                    <ul class="list-disc list-inside">
                        @foreach ($course->requirements as $requirement)
                            <li>
                                {{ $requirement->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Descripcion --}}

                <div>
                    <h2 class="text-2xl font-semibold mb-4">
                        Descripción
                    </h2>

                    <div>
                        {!! $course->description !!}
                    </div>
                </div>

            </div>

            <div class="col-span-1 order-1 lg:order-2">
                <div class="bg-white rounded-lg shadow p-6">
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
                                <i class="far fa-clock inline-block w-6"></i> Duración:
                                {{ $course->updated_at->format('d/m/Y') }}
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