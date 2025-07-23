<x-app-layout>
    @push('css')

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs4.min.css" />

    <style>
        .highlight-date {
            background-color: rgb(34 197 94 / var(--tw-bg-opacity, 1)) !important;
            color: white;
            border-radius: 50%;
        }
    </style>
    @endpush
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-8 gap-6 mb-3">

            <div class="col-span-1 lg:col-span-2">
                <div
                    class="overflow-hidden w-full lg:h-[90%] p-8 tracking-wide bg-indigo-900 border mt-8 border-indigo-800 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-center items-center text-center h-full">

                    <!-- Encabezado principal -->
                    <h2 class="text-gray-100 text-4xl font-bold mb-4">
                        Agenda tu asesoría ahora.
                    </h2>

                    <!-- Lista de pasos -->
                    <ul class="text-gray-100 space-y-4 text-base leading-relaxed list-decimal list-inside w-full">
                        <li class="w-full">
                            <div class="w-full">
                                Los días disponibles están coloreados de un color
                                <span class="bg-green-500 text-white px-2 py-0.5 rounded-md font-medium shadow-sm">
                                    verde
                                </span>.
                            </div>
                        </li>
                        <li class="w-full">
                            <div class="w-full">
                                Al dar click en ese día con recuadro verde, se desplegarán los horarios disponibles.
                            </div>
                        </li>
                        <li class="w-full">
                            <div class="w-full">
                                Una vez seleccionado el dia y hora, el botón aceptar lo redirigirá para proceder con el
                                pago.
                            </div>
                        </li>

                        <li class="w-full">
                            <div class="w-full">
                                Una vez aprobado el pago, se enviará un correo con los detalles para la sesión de <span
                                    class="font-semibold underline">Google
                                    Meet</span>.
                                También
                                podrá consultar su reservación <a href="{{ route('classes.myClasses') }}"><span
                                        class="text-yellow-500 hover:cursor-pointer">
                                        aqui.</span></a>
                            </div>
                        </li>
                    </ul>


                </div>
            </div>


            <div class="col-span-1 lg:col-span-6">
                <form action="{{ route('asesoria.handleForm') }}" id="dateForm" method="POST">
                    @csrf
                    <div
                        class="w-full p-6  bg-indigo-900 mt-8 border-indigo-800 border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <p class="mb-10 font-normal text-center text-gray-300 text-4xl dark:text-gray-400">
                            ¿Listo para agendar tu cita? ¡Elige una fecha!
                        </p>

                        <h2 class="text-xl flex justify-center text-gray-300 dark:text-white font-bold mb-2">Digital
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
                                <span class="text-gray-200 dark:text-white text-base font-medium">{{ date('d/m/y')
                                    }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 me-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-200 dark:text-white text-base font-medium">México</span>
                            </div>
                        </div>
                        <div class="flex justify-center items-center space-x-4 rtl:space-x-reverse mb-5">
                            <div>
                                <div class="text-base font-normal text-gray-200 dark:text-gray-400 mb-2">Participantes
                                </div>
                                <div class="flex space-x-1 rtl:space-x-reverse">
                                    <img class="w-8 h-8 border border-white rounded-full dark:border-gray-800"
                                        src="{{Auth::user()->profile_photo_url }}" alt="">

                                    <img class="w-8 h-8 border border-white rounded-full dark:border-gray-800"
                                        src="/docs/images/people/profile-picture-3.jpg" alt="">

                                </div>
                            </div>
                            <div>
                                <div class="text-base font-normal text-gray-200 dark:text-gray-200 mb-3">Duración</div>
                                <span class="text-gray-200 dark:text-white text-base font-medium block">50 min</span>
                            </div>
                            <div>
                                <div class="text-base font-normal text-gray-200 dark:text-gray-200 mb-3">Tipo de reunión
                                </div>
                                <span class="text-gray-200 dark:text-gray-200 text-base font-medium block">Web
                                    conference</span>
                            </div>
                        </div>
                        <div
                            class="pt-5 border-t border-gray-200 dark:border-gray-800 flex  md:justify-center  sm:flex-row flex-col sm:space-x-5 rtl:space-x-reverse">
                            <div id="datepicker-actions" class="flex justify-center"></div>
                            <div
                                class="float sm:ms-7 sm:ps-5 sm:border-s border-gray-200 dark:border-gray-800 w-full sm:max-w-[15rem] mt-5 sm:mt-0 ">
                                <h3 id="dateHeader"
                                    class=" text-gray-200 dark:text-white text-base font-medium mb-3 text-center">
                                </h3>
                                <input type="hidden" id="dateInput" name="date" />
                                <input type="hidden" name="email" value="{{  Auth::user()->email }}" />
                                <div data-collapse-toggle="timetable"
                                    class="inline-flex items-center w-full py-2 px-5 me-2 justify-center text-sm font-medium text-gray-300 focus:outline-none bg-gray-800 rounded-lg border border-blue-300  focus:z-10 focus:ring-4 ">
                                    <svg class=" w-4 h-4 text-gray-300 dark:text-white me-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Elige un horario
                                </div>

                                {{-- Horarios --}}
                                <ul id="timetable" class="grid w-full grid-cols-2 gap-2 mt-5">
                                </ul>
                            </div>
                        </div>
                        <div class="mt-5 md:flex md:justify-end text-center">
                            {{-- @if ($errors->any())
                            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-5">
                                <ul class="list-disc pl-5 text-sm">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif --}}
                            <button class="btn btn-red w-full md:w-[13%] p-1" type="submit">Acceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </x-container>


    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        const fechasConHorarios = @json($formattedSlots);
            document.addEventListener("DOMContentLoaded", async function () {

                if (window.Datepicker) {
                   
                    // Definir locale español
                    Datepicker.locales.es = {
                        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        months: [
                            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                        ],
                        monthsShort: [
                            "Ene", "Feb", "Mar", "Abr", "May", "Jun",
                            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
                        ],
                        today: "Hoy",
                        clear: "Borrar",
                        monthsTitle: "Meses",
                        weekStart: 1,
                        format: "dd/mm/yyyy"

                    };


                    // Convertimos a Date para comparaciones
                    const fechasParseadas = fechasConHorarios.map(slot => {
                        const [y, m, d] = slot.date.split('-');
                        return new Date(y, m - 1, d);
                    });

                    // Función para comparar fechas sin horas
                    function esMismaFecha(a, b) {
                        return a.getFullYear() === b.getFullYear() &&
                            a.getMonth() === b.getMonth() &&
                            a.getDate() === b.getDate();
                    }

                    const $datepickerEl = document.getElementById('datepicker-actions');
                    if ($datepickerEl) {
                        // Inicializar datepicker vanilla con idioma español
                        const datepicker = new Datepicker($datepickerEl, {
                            language: 'es',
                            format: 'dd/mm/yyyy',
                            autohide: true,
                            minDate: new Date(),
                            beforeShowDay: function (date) {
                                const esFechaMarcada = fechasParseadas.some(f => esMismaFecha(f, date));
                                if (esFechaMarcada) {
                                    return {
                                        classes: 'highlight-date'
                                    };
                                }
                                return {};
                            }
                        });

                        // Ejecutar después de render inicial

                       let dateInput="";
                       let currentRequest;
                        $datepickerEl.addEventListener('changeDate', async function (event) {

                            const date = event.detail.date;

                            dateString = date.toISOString().split('T')[0]; // → '2025-04-25'

                            if (currentRequest) {
                                currentRequest.cancel();
                            }


                            const CancelToken = axios.CancelToken;
                            currentRequest = CancelToken.source();

                            axios.defaults.withCredentials = true;
                            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            axios.get(`/calendar/${dateString}`,{
                                 cancelToken: currentRequest.token
                            })
                                .then(function (response) {
                                    // handle success
                                    const slotContainer = document.getElementById('timetable');

                                    const dateHeader = document.getElementById('dateHeader');

                                    dateInput = document.getElementById('dateInput');

                                    const timeSlots = response.data;

                                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                    let formattedDate = new Date(dateString + "T12:00:00").toLocaleDateString('es-ES', options);

                                    // Poner primera letra mayúscula
                                    formattedDate = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);

                                    dateHeader.innerHTML = formattedDate;

                                    dateInput.value = `${dateString}`;

                                    if (timeSlots === undefined || timeSlots.length == 0) {

                                        slotContainer.innerHTML = "";

                                    } else {
                                        const today = new Date();

                                        const selectedDate = new Date(dateString);

                                        slotContainer.innerHTML = "";

                                        const now = new Date();

                                        timeSlots.forEach(slot => {


                                            const slotTime = slot.start + ':00'; // Ej. "11:00:00"

                                            const slotDateTime = new Date(`${dateString}T${slotTime}`);

                                            // Ver si hay que deshabilitar
                                            const isToday = selectedDate.toDateString() === today.toDateString();

                                            // compara solo la fecha sin tiempo
                                            const isBeforeToday = selectedDate < new Date(today.toDateString());
                                            const isPast = isBeforeToday || (isToday && slotDateTime < now);


                                            if (typeof slot.start === 'string' && slot.start.includes(':')) {
                                                const [hourStr, minuteStr] = slot.start.split(':');
                                                const dateForFormatting = new Date();
                                                dateForFormatting.setHours(parseInt(hourStr), parseInt(minuteStr || '0'), 0);

                                                const formattedTime = dateForFormatting.toLocaleTimeString('en-US', {
                                                    hour: 'numeric',
                                                    minute: '2-digit',
                                                    hour12: true
                                                }); // Ej. "8:30 AM"


                                                const listItem = document.createElement('li');

                                                // Crear input
                                                const input = document.createElement('input');
                                                input.type = 'radio';
                                                input.id = slot.start;
                                                input.value = slotTime;
                                                input.name = 'time';
                                                input.className = 'hidden peer';
                                                if (isPast) {
                                                    input.disabled = true;
                                                }

                                                // Crear label
                                                const label = document.createElement('label');
                                                label.htmlFor = slot.start;
                                                label.className = 'label-style';
                                                if (isPast) {
                                                    label.classList.add('opacity-50', 'cursor-not-allowed');
                                                }
                                                label.textContent = formattedTime;

                                                // Insertar input y label al <li>
                                                listItem.appendChild(input);
                                                listItem.appendChild(label);

                                                // Agregar <li> al contenedor
                                                slotContainer.appendChild(listItem);
                                            }
                                        });
                                    }
                                })
                                .catch(function (error) {
                                   if (axios.isCancel(error)) {
                                        console.log("Solicitud cancelada:", error.message);
                                    } else {
                                        console.error(error);
                                    }
                                })
                                .finally(function () {

                                });

                                
                        });





                        const form = document.getElementById("dateForm");

                        form.addEventListener("submit", function (event) {
                            
                                let timeInput = document.querySelector('input[name="time"]:checked');
                                if (!dateInput.value || dateInput.value === "") {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Debes elegir una fecha!",
                                    });
                                    event.preventDefault();
                                    return;
                                }
                                if (!timeInput) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Debes elegir una hora para la clase!",
                                    });
                                    event.preventDefault();
                                    return;
                                }
                        });

                    }
                }
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endpush
</x-app-layout>