<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100  leading-tight">
            Lista de cursos
        </h2>
    </x-slot>

    <x-container class="m-24">
        <div class="md:flex md:justify-end mb-6">
            <a href="{{ route('instructor.courses.create') }}" class="btn btn-red block  w-full md:w-auto text-center">
                Crear curso
            </a>
        </div>

        <ul class="space-y-4">
            @forelse ($courses as $course)
            <li class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <a href="{{ route('instructor.courses.edit', $course) }}">
                        <figure class=" flex-shrink-0">
                            <img src="{{ $course->image }}"
                                class="w-full md:w-36 aspect-video md:aspect-square object-cover object-center">
                        </figure>
                    </a>

                    <div class="flex-1">
                        <div class="py-4 px-8">

                            <div class="grid md:grid-cols-9">

                                <div class="md:col-span-3">

                                    <a href="{{ route('instructor.courses.edit', $course) }}"
                                        class="hover:text-blue-800">
                                        <h1>{{ $course->title }}</h1>
                                    </a>
                                    @switch($course->status->name)
                                    @case('BORRADOR')
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">{{
                                        $course->status->name }}</span>
                                    @break

                                    @case('PENDIENTE')
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">{{
                                        $course->status->name }}</span>
                                    @break

                                    @case('PUBLICADO')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">{{
                                        $course->status->name }}</span>
                                    @break

                                    @endswitch

                                    <form method="POST"
                                        action="{{ route('instructor.courses.update-status', $course) }}" class="mt-2">
                                        @csrf
                                        @method('PUT')

                                        <select name="status" onchange="this.form.submit()"
                                            class="mt-1 block w-full md:w-40 rounded-md border-gray-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @foreach(App\Enums\CourseStatus::cases() as $status)
                                            <option value="{{ $status->value }}" {{ $course->status === $status ?
                                                'selected' : '' }}>
                                                {{ ucfirst(strtolower($status->name)) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </form>

                                </div>
                                <div class=" hidden md:block col-span-2">
                                    <p class="text-sm font-bold">100 US</p>
                                    <p class="mb-1 text-sm">Ganado este mes</p>
                                    <p class="text-sm font-bold">1000 US</p>
                                    <p class="text-sm">Ganado Total</p>
                                </div>
                                <div class=" hidden md:block col-span-2">
                                    <p>50</p>
                                    <p class="text-sm">Inscripciones este mes</p>
                                </div>
                                <div class=" hidden md:block col-span-2">
                                    <div class="flex justify-end">
                                        <p class="mr-3">5</p>
                                        <ul class="text-xs space-x-1 flex items-center">
                                            <li>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star text-yellow-400"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </li>

            @empty
            <li class="bg-gray-200 rounded-lg shadow-lg p-6">
                <div class="flex justify-between">
                    <p>Salta la creación de un curso</p>
                    <a href="{{ route('instructor.courses.create') }}" class="btn btn-blue">
                        Crea tu curso
                    </a>
                </div>

            </li>

            @endforelse
        </ul>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>

    </x-container>

</x-instructor-layout>