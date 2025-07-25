<div>
    <x-container class="mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-4">
            <aside class="col-span-1 ">

                {{-- Ordernar por --}}

                

                <div class="mb-4">
                    <p class="text-lh font-semibold text-white">
                        Ordernar por
                    </p>
                    <x-select class="bg-gray-800 text-white rounded-md px-4 py-2 w-full focus:ring-2 focus:ring-blue-500">
                        <option value="published_at">Más reciente</option>
                        <option value="students_count">Más alumnos</option>
                        <option value="rating">Mejor calificado</option>
                    </x-select>
                </div>

                {{-- Filtra por categorias --}}
                <div class="mb-4 border-b border-gray-700">
                    <h3 class="font-semibold text-lg mb-2 text-white">Categorías</h3>

                    <ul class="space-y-1">
                        @foreach ($categories as $category)

                            <li>
                                <label for="" class="text-blue-100">
                                    <x-checkbox wire:model.live="selectedCategories"  value="{{ $category->id }}" />{{ $category->name }}
                                </label>
                            </li>

                        @endforeach
                    </ul>
                </div>

                {{-- Filtrar por niveles --}}

                <div class="mb-4 border-b border-gray-700">
                    <p class="text-lg font-semibold mb-2 text-white">
                        Niveles
                    </p>
                    <ul class="space-y-1">
                        @foreach ($levels as $level)

                            <li>
                                <label for="" class="text-blue-100">
                                    <x-checkbox wire:model.live="selectedLevels" value="{{ $level->id }}" />{{ $level->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div >
                    <p class="text-lg font-semibold text-white">
                        Precios
                    </p>
                    <ul class="space-y-1">


                        <li>
                            <label for="" class="text-blue-100">
                                <x-checkbox wire:model.live="selectedPrices" value="free" />Gratis
                            </label>
                        </li>

                        <li>
                            <label for="" class="text-blue-100">
                                <x-checkbox wire:model.live="selectedPrices" value="premium" />Premium
                            </label>
                        </li>
                    </ul>
                </div>

            </aside>



            <div class="col-span-1 lg:col-span-3">
                    <div class="mb-12">
                        <x-input wire:model.live="search" placeholder="Buscar curso" class=" bg-gray-800 text-white px-4 py-2 rounded-full w-full  focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    {{-- Listado de cursos --}}

                
                    <ul class="space-y-4">
                        @foreach ($courses as $course)
                            <li wire:key="course-{{ $course->id }}">
                                <div class="bg-gray-800 hover:bg-gray-700 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                                    <a href="{{ route('courses.show', $course) }}" class="block sm:flex w-full">
                                        <figure>
                                            <img class="w-full sm:w-64 aspect-video object-cover object-center" src="{{ $course->image }}"
                                                alt="">
                                        </figure>

                                        <div class="flex-1 mt-2 sm:mt-0 sm:ml-4 ">
                                            <h3 class="text-lg mb-1 font-bold text-white">
                                                {{ $course->title }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mb-1">
                                                {{ $course->summary }}
                                            </p>

                                            <p class="text-sm text-gray-400 mb-1">
                                                Prof: {{ $course->teacher->name }}
                                            </p>

                                            <div class="flex items-center">
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

                                                <span class="text-sm text-gray-500 font-semibold ml-1">(5)</span>


                                            </div>

                                            <p class="font-semibold mb-2">
                                                @if ($course->price->value == 0)
                                                    <span class="text-green-500">
                                                        Gratis
                                                    </span>
                                                @else

                                                    <span class="text-gray-400">
                                                        {{ number_format($course->price->value, 2) }} MX
                                                    </span>

                                                @endif
                                            </p>

                                        </div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        {{ $courses->links() }}
                    </div>
            </div>
        </div>
    </x-container>
</div>