<div class="relative">

    <div class="max-w-7xl mx-auto mt-10 px-4">
        {{-- Filtros --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <select class="bg-gray-800 text-white rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option>English</option>
            </select>
            <select class="bg-gray-800 text-white rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option>$3 - $40+</option>
            </select>
            <select class="bg-gray-800 text-white rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option>Any country</option>
            </select>
            <select class="bg-gray-800 text-white rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500">
                <option>Any time</option>
            </select>
            <input type="text" placeholder="Search by name"
                class="bg-gray-800 text-white rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-500 w-full sm:w-auto" />
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mb-10">
        <h1 class="text-2xl font-bold mb-4 text-gray-100">
            37,747 English tutors to help you succeed at work
        </h1>

        {{-- Contenedor tarjeta + video --}}
        <div x-data="{ hoveredTutor: null}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            @foreach ($tutors as $index => $tutor)
            <div class="lg:col-span-2 bg-indigo-800 border rounded-lg shadow-md flex flex-col sm:flex-row p-4 gap-4"
                @mouseenter="hoveredTutor = {{ $index }}" @mouseleave="hoveredTutor = null">
                <a href="">
                    <img src="" class="w-full sm:w-32 sm:h-32 rounded object-cover" />
                </a>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                        <a href="">
                            <h2 class="font-bold text-gray-300 text-lg">{{ $tutor->name }}</h2>
                        </a>
                        <span class="text-yellow-500">★ 4.9</span>
                    </div>
                    <p class="text-gray-200 text-sm">Professional • Super Tutor</p>
                    <p class="text-gray-200 text-sm mt-1">52 active students • 3,132 lessons</p>
                    <p class="mt-2 text-gray-100 text-sm">
                        Learn from an interactive, fun-filled, professional trainer...
                    </p>
                    <div class="flex flex-col sm:flex-row gap-2 mt-4 sm:justify-end">
                        <button class="bg-pink-500 text-white px-4 py-2 rounded">Book trial lesson</button>
                        <a href="{{ route('contacts.create', ['tutor_id' => $tutor->id]) }}"><button
                                class="bg-gray-200 px-4 py-2 rounded">
                                Enviar mensaje
                            </button></a>
                        <button class="border bg-gray-200 px-4 py-2 rounded">Ver horario</button>
                    </div>
                </div>
            </div>

            <!-- Video introductorio (1/3 ancho en escritorio) -->
            <div class="hidden lg:block lg:col-span-1 w-full">
                <div class="lg:aspect-video md:aspect-w-16 md:aspect-h-10">
                    <template x-if="hoveredTutor === {{ $index }}">
                        <iframe class="w-full h-full rounded-lg" src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                            title="Intro video" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </template>
                </div>
            </div>

            @endforeach
        </div>
    </div>

</div>

@push('js')
{{-- Alpine.js --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endpush