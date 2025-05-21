
document.addEventListener("DOMContentLoaded", function () {
 // set the target element of the input field
    const $datepickerElAdmin = document.getElementById('date-range-picker');

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
        rangePicker: true,
        onShow: () => { },
        onHide: () => { },
    };

    const instanceOptions = {
        id: 'datepicker-custom-example',
        override: true
    };


    const datepickerAdmin = new Datepicker($datepickerElAdmin, options, instanceOptions);          
});