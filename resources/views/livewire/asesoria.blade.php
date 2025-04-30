<x-app-layout>
    {{-- {{ dd($formattedSlots) }} --}}
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-8 gap-6">

            <div class="col-span-1 lg:col-span-2">
                <div
                    class="overflow-hidden lg:h-80 p-6 tracking-wide items-center bg-white border mt-8 border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <p class="mb-3 font-normal text-gray-700 text-4xl dark:text-gray-400">
                        Agenda una clase con nosotros.
                    </p>
                </div>
            </div>

            <div class="col-span-1 lg:col-span-6">
                <form action="{{ route('calendar.handleForm') }}" method="POST">
                    @csrf
                    <div
                        class="w-full p-6  bg-white border mt-8 border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <p class="mb-10 font-normal text-gray-700 text-4xl dark:text-gray-400">
                            ¿Listo para agendar tu cita? ¡Elige una fecha!
                        </p>

                        <h2 class="text-xl flex justify-center text-gray-900 dark:text-white font-bold mb-2">Digital
                            Transformation</h2>
                        <div class="flex justify-center items-center space-x-4 rtl:space-x-reverse mb-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 me-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span
                                    class="text-gray-900 dark:text-white text-base font-medium">{{ date('d/m/y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 me-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-900 dark:text-white text-base font-medium">México</span>
                            </div>
                        </div>
                        <div class="flex justify-center items-center space-x-4 rtl:space-x-reverse mb-5">
                            <div>
                                <div class="text-base font-normal text-gray-500 dark:text-gray-400 mb-2">Participantes
                                </div>
                                <div class="flex -space-x-4 rtl:space-x-reverse">
                                    <img class="w-8 h-8 border border-white rounded-full dark:border-gray-800"
                                        src="/docs/images/people/profile-picture-5.jpg" alt="">
                                    <img class="w-8 h-8 border border-white rounded-full dark:border-gray-800"
                                        src="/docs/images/people/profile-picture-2.jpg" alt="">
                                    <img class="w-8 h-8 border border-white rounded-full dark:border-gray-800"
                                        src="/docs/images/people/profile-picture-3.jpg" alt="">
                                    <a class="flex items-center justify-center w-8 h-8 text-xs font-medium text-white bg-gray-700 border border-white rounded-full hover:bg-gray-600 dark:border-gray-800"
                                        href="#">+99</a>
                                </div>
                            </div>
                            <div>
                                <div class="text-base font-normal text-gray-500 dark:text-gray-400 mb-3">Duración</div>
                                <span class="text-gray-900 dark:text-white text-base font-medium block">50 min</span>
                            </div>
                            <div>
                                <div class="text-base font-normal text-gray-500 dark:text-gray-400 mb-3">Tipo de reunión
                                </div>
                                <span class="text-gray-900 dark:text-white text-base font-medium block">Web
                                    conference</span>
                            </div>
                        </div>
                        <div
                            class="pt-5 border-t border-gray-200 dark:border-gray-800 flex justify-center sm:flex-row flex-col sm:space-x-5 rtl:space-x-reverse">
                            <div id="datepicker-actions"></div>
                            <div
                                class="sm:ms-7 sm:ps-5 sm:border-s border-gray-200 dark:border-gray-800 w-full sm:max-w-[15rem] mt-5 sm:mt-0">
                                <h3 id="dateHeader"
                                    class=" text-gray-900 dark:text-white text-base font-medium mb-3 text-center">
                                </h3>
                                <input type="hidden" id="dateInput" name="date" />
                                <button type="button" data-collapse-toggle="timetable"
                                    class="inline-flex items-center w-full py-2 px-5 me-2 justify-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white me-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Elige un horario
                                </button>
                                <label class="sr-only">
                                    Pick a time
                                </label>
                                {{-- Horarios --}}
                                <ul id="timetable" class="grid w-full grid-cols-2 gap-2 mt-5">
                                </ul>
                            </div>
                        </div>
                        <div class="mt-5 flex justify-end">
                            <button class="btn btn-red">Acceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-container>


    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <script>

            // set the target element of the input field
            const $datepickerEl = document.getElementById('datepicker-actions');

            // optional options with default values and callback functions
            const options = {
                defaultDatepickerId: null,
                autohide: true,
                format: 'dd/mm/yyyy',
                maxDate: null,
                minDate: new Date(),
                orientation: 'bottom',
                buttons: false,
                autoSelectToday: false,
                title: null,
                rangePicker: false,
                onShow: () => { },
                onHide: () => { },
            };

            const instanceOptions = {
                id: 'datepicker-actions-example',
                override: true
            };

            /*
             * $datepickerEl: required
             * options: optional
             */


        </script>

    @endpush
</x-app-layout>