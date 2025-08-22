<x-layouts.student>
    <x-container width="5xl" class="m-12">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white">Mis cursos</h2>
        </div>
        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($courses as $course)
            <li
                class="group bg-indigo-800/90 backdrop-blur-md p-4 rounded-2xl shadow-lg hover:shadow-2xl hover:bg-indigo-700/90 transition-all duration-300 ring-1 ring-indigo-700 hover:ring-indigo-400">
                <a href="{{ route('courses.status', $course) }}" class="block space-y-2">
                    <figure class="overflow-hidden rounded-xl">
                        <img src="{{ $course->image }}" alt="{{ $course->title }}"
                            class="aspect-video w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                    </figure>
                    <p class="truncate text-base font-semibold text-gray-100">
                        {{ $course->title }}
                    </p>
                </a>
            </li>

            @empty

            <li class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4">
                <div class="card">
                    <p class="my-2 text-center">Parece que aún no tienes cursos matriculados.</p>
                    <div class="flex justify-center">
                        <a href="{{ route('courses.index') }}" class="btn btn-blue">
                            Comprar un curso.
                        </a>
                    </div>
                </div>
            </li>

            @endforelse
        </ul>
    </x-container>
</x-layouts.student>