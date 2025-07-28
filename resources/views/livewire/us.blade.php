<x-app-layout>
    <div class="bg-indigo-950 grid relative overflow-hidden pt-20 pb-16 h-[450px]">
        <div class="m-auto relative px-4 sm:px-6 md:px-8 w-full max-w-4xl h-full">
            <div class="flex flex-col items-center justify-center h-full">
                <p class="text-center text-gray-100 font-sans text-lg sm:text-xl font-bold">Sobre nosotros</p>
                <h1
                    class="text-center mt-14 text-4xl sm:text-4xl md:text-6xl font-mono text-gray-100 leading-tight font-bold">
                    Un lugar donde aprender matemáticas y desarrollar tu pensamiento
                </h1>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-b from-white to-indigo-50 grid relative">

        <div class="pt-12 pb-10 h-[450px] w-full max-w-4xl m-auto relative px-4">
            <div class="py-16">
                <p class="text-2xl md:text-3xl text-center text-indigo-950 font-bold font-sans">
                    Academia Xahni nace de la necesidad de ayudar a aquellas personas que desean mejorar sus habilidades
                    en matemáticas y programación, entre otras cosas. Buscamos expandir tusnp conocimientos
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-b from-white to-indigo-50 min-h-screen  grid relative">

        <div class="  grid relative">
            <div class=" pt-5 pb-5  w-full max-w-4xl m-auto relative px-4">
                <h2 class="text-3xl font-bold text-center text-indigo-950 py-14 ">¿Qué puedes encontrar aquí?</h2>

                <div class="py-12">
                    <x-container>
                        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                            <li
                                class="bg-indigo-900 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl border border-indigo-800 ">
                                <a href="{{ route('courses.index') }}">
                                    <img class="aspect-[16/9] object-center object-cover rounded-lg"
                                        src="{{ asset('img/welcome/onlinecourses.jpg') }}" alt="">
                                </a>
                                <h1
                                    class="text-xl font-semibold text-gray-100 hover:text-yellow-400 transition-colors text-center mt-1">
                                    <a href="{{ route('courses.index') }}">Cursos online</a>
                                </h1>
                                <p class="text-center text-gray-100 py-2">Recursos gratuitos y premium: videos, guías,
                                    ejercicios
                                </p>
                            </li>

                            <li
                                class="bg-indigo-900 rounded-xl shadow-lg overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-xl border border-indigo-800">
                                <a href="{{ route('asesoria') }}">
                                    <img class="aspect-[16/9] object-center
                        object-cover rounded-lg" src="{{ asset('img/welcome/tutoring.jpg') }}" alt="">
                                </a>
                                <h1
                                    class="text-xl font-semibold text-gray-100 hover:text-yellow-400 transition-colors text-center mt-1">
                                    <a href="{{ route('asesoria') }}">Asesoria</a>
                                </h1>

                                <p class="text-center text-gray-100 py-2">
                                    Asesorias personalizadas de matemáticas para secundaria, bachillerato y universidad
                                </p>
                            </li>

                            <li class=" bg-indigo-900 rounded-xl shadow-lg overflow-hidden transition-transform
                                    hover:scale-[1.02] hover:shadow-xl border border-indigo-800">
                                <a href="">
                                    <img class="aspect-[16/9] object-center
                        object-cover rounded-lg" src="{{ asset('img/welcome/blog.jpg') }}" alt="">
                                </a>
                                <h1
                                    class="text-xl font-semibold text-gray-100 hover:text-yellow-400 transition-colors text-center mb-2">
                                    <a href="">Blog</a>
                                </h1>

                                <p class="text-indigo-300 text-sm leading-relaxed text-center">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, enim sapiente et
                                </p>
                            </li>
                        </ul>

                    </x-container>
                </div>
            </div>


        </div>

        <div class="py-16 w-full max-w-4xl m-auto px-4">
            <h3 class="text-2xl font-semibold text-indigo-950 mb-4">Lo que dicen nuestros estudiantes</h3>
            <blockquote class="bg-white p-4 rounded-xl shadow text-gray-700 italic">
                “Gracias a estas clases entendí cálculo por primera vez. ¡Ahora incluso me gusta!”
                <span class="block text-right font-semibold mt-2">– Mariana G.</span>
            </blockquote>
        </div>

        <div>
            <div class="text-center p-9">
                <a href="{{ route('register') }}"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-full text-lg hover:bg-indigo-700 transition">
                    ¡Empieza a aprender ahora!
                </a>
            </div>
        </div>

        <div class="mt-12 mb-12 w-full max-w-4xl m-auto px-4">
            <h3 class="text-xl font-bold mb-4">Preguntas frecuentes</h3>
            <details class="mb-2">
                <summary class="cursor-pointer font-semibold">¿Cómo accedo a las cursos?</summary>
                <p class="ml-4 mt-2 text-gray-800">Puedes registrarte y acceder desde cualquier dispositivo.</p>
            </details>
            <details>
                <summary class="cursor-pointer font-semibold">¿Necesito conocimientos previos?</summary>
                <p class="ml-4 mt-2 text-gray-800">No, comenzamos desde lo más básico si lo necesitas. Si necesitas más
                    información, puedes hacer click en el icono de whatsapp para poder exponer las dudas que surgan.</p>
            </details>
        </div>
    </div>


</x-app-layout>