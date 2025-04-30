<x-app-layout>

    {{-- Portada --}}

    <figure class="mb-20">
        <img class="w-full aspect-[1/1] md:aspect-[3/1] object-cover object-center"
            src="{{ asset('img/welcome/maths.jpg') }}" alt="">
    </figure>

    {{-- Contenido --}}

    <section class="mb-24">
        <x-container>
            <h1 class="text-2xl font-semibold text-center mb-8">CONTENIDO</h1>

            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

                <li>
                    <a href="">
                        <img class="aspect-[16/9] object-center
                        object-cover rounded-lg" src="{{ asset('img/welcome/onlinecourses.jpg') }}" alt="">
                    </a>
                    <h1 class="text-xl text-center font-semibold mt-4 mb-2">
                        <a href="">Cursos online</a>
                    </h1>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, enim sapiente et
                    </p>
                </li>

                <li>
                    <a href="">
                        <img class="aspect-[16/9] object-center
                        object-cover rounded-lg" src="{{ asset('img/welcome/tutoring.jpg') }}" alt="">
                    </a>
                    <h1 class="text-xl text-center font-semibold mt-4 mb-2">
                        <a href="{{ route('asesoria') }}">Asesoria</a>
                    </h1>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, enim sapiente et
                    </p>
                </li>

                <li>
                    <a href="">
                        <img class="aspect-[16/9] object-center
                        object-cover rounded-lg" src="{{ asset('img/welcome/blog.jpg') }}" alt="">
                    </a>
                    <h1 class="text-xl text-center font-semibold mt-4 mb-2">
                        <a href="">Blog</a>
                    </h1>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, enim sapiente et
                    </p>
                </li>

                <li>
                    <a href="">
                        <img class="aspect-[16/9] object-center
                        object-cover rounded-lg" src="" alt="">
                    </a>
                    <h1 class="text-xl text-center font-semibold mt-4 mb-2">
                        <a href="">Cursos online</a>
                    </h1>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, enim sapiente et
                    </p>
                </li>

            </ul>

        </x-container>
    </section>


    {{-- Cursos --}}

    <section>
        <x-container>

            <h1 class="text-2xl font-semibold text-center mb-8">Últimos cursos</h1>

            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($courses as $course)
                    <li>
                        <div class="bg-white rounded-lg overflow-hidden">
                            <figure>
                                <img class="  w-full aspect-video object-cover object-center" src="{{ $course->image }}"
                                    alt="{{ $course->title }}">
                            </figure>

                            <div class="px-6 pt-4 pb-5">
                                <h1 class="line-clamp-2 text-lg leading-5 min-h-[42px] mb-1">
                                    <a href="{{ route('courses.show', $course) }}">
                                        {{ $course->title }}
                                    </a>
                                </h1>
                                <p class="text-gray-500 text-sm mb-1">
                                    Prof: {{ $course->teacher->name }}
                                </p>

                                <ul class="text-xs flex space-x-1 mb-1">
                                    <li>
                                        <i class="fas fa-star  text-yellow-400"></i>
                                    </li>
                                    <li>
                                        <i class="fas fa-star  text-yellow-400"></i>
                                    </li>
                                    <li>
                                        <i class="fas fa-star  text-yellow-400"></i>
                                    </li>
                                    <li>
                                        <i class="fas fa-star  text-yellow-400"></i>
                                    </li>
                                </ul>

                                <p class="font-semibold mb-2">
                                    @if ($course->price->value == 0)
                                        <span class="text-green-500">
                                            Gratis
                                        </span>
                                    @else

                                        <span class="text-gray-700">
                                            {{ number_format($course->price->value, 2) }}
                                        </span>

                                    @endif
                                </p>

                                <a class="btn btn-blue block w-full text-center"
                                    href="{{ route('courses.show', $course) }}"> Más información</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </x-container>
    </section>

</x-app-layout>