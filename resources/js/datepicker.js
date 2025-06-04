document.addEventListener("DOMContentLoaded", function () {
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

            if($datepickerEl){
            const datepicker = new Datepicker($datepickerEl, options, instanceOptions);

            let dateString = "";

            $datepickerEl.addEventListener('changeDate', async function (event) {
                const date = event.detail.date;
                dateString = date.toISOString().split('T')[0]; // → '2025-04-25'


                axios.get(`api/calendar/${dateString}`)
                    .then(function (response) {

                        // handle success
                        const slotContainer = document.getElementById('timetable');

                        const dateHeader = document.getElementById('dateHeader');

                        const dateInput = document.getElementById('dateInput');

                        const timeSlots = response.data;

                        dateHeader.innerHTML = `${new Date(dateString + "T12:00:00").toDateString()}`;

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


                                 const [hourStr, minuteStr] = slot.start.split(':');
                                const dateForFormatting = new Date();
                                dateForFormatting.setHours(parseInt(hourStr), parseInt(minuteStr || '0'), 0);

                                const formattedTime = dateForFormatting.toLocaleTimeString('en-US', {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    hour12: true
                                }); // Ej. "8:30 AM"

                                const listItem = document.createElement('li');

                                listItem.innerHTML = `
                                    <input type="radio" id="${slot.start}" value="${slotTime}" class="hidden peer" name="time" ${isPast ? 'disabled' : ''}>
                                    <label for="${slot.start}"
                                        class="label-style ${isPast ? 'opacity-50 cursor-not-allowed' : ''}">
                                        ${formattedTime}
                                    </label>
                                `;
                                // Append the list item to the container
                                slotContainer.appendChild(listItem);
                            });
                        }


                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {

                    });

            });

              const form = document.getElementById("dateForm");

            form.addEventListener("submit", function (event) {
                try {
                    let timeInput = document.querySelector('input[name="time"]:checked');
                    if (!dateString || dateString === "") {
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
                } catch (error) {
                    console.error("Error en validación:", error);
                    alert("Error inesperado. Intenta de nuevo.");
                }


            });
            }

           

          
});