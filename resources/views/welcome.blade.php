<x-app-layout>

    {{-- Portada --}}

    <div id="default-carousel" class="relative w-full max-w-7xl mx-auto mb-10" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative  overflow-hidden rounded-lg aspect-video">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('storage/thanks.jpg') }}" class=" block w-full h-full object-cover" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-2.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-3.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-4.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="/docs/images/carousel/carousel-5.svg"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>


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

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @endpush
</x-app-layout>