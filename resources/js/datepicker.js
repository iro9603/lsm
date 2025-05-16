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

            let formatted = "";

            $datepickerEl.addEventListener('changeDate', async function (event) {
                const date = event.detail.date;
                formatted = date.toISOString().split('T')[0]; // → '2025-04-25'


                axios.get(`/calendar/${formatted}`)
                    .then(function (response) {

                        // handle success
                        const slotContainer = document.getElementById('timetable');
                        const dateHeader = document.getElementById('dateHeader');
                        const dateInput = document.getElementById('dateInput');
                        const timeSlots = response.data;
                        dateHeader.innerHTML = `${new Date(formatted + "T12:00:00").toDateString()}`;
                        dateInput.value = `${formatted}`;
                        if (timeSlots === undefined || timeSlots.length == 0) {

                            slotContainer.innerHTML = "";



                        } else {

                            slotContainer.innerHTML = "";
                            timeSlots.forEach(slot => {

                                const listItem = document.createElement('li');

                                listItem.innerHTML = `
                                <input type="radio" id="${slot.start}" value="${slot.start}" class="hidden peer" name="timetable">
                                <label for="${slot.start}"
                                    class="label-style">
                                    ${slot.start}
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
                    let timeInput = document.querySelector('input[name="timetable"]:checked');
                    if (!formatted || formatted === "") {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Debes elegir una fecha!",
                            /* footer: '<a href="#">Why do I have this issue?</a>' */
                        });
                        event.preventDefault();
                        return;
                    }
                    if (!timeInput) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Debes elegir una hora para la clase!",
                            /* footer: '<a href="#">Why do I have this issue?</a>' */
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