const datepicker = new Datepicker($datepickerEl, options, instanceOptions);

let formatted="";

$datepickerEl.addEventListener('changeDate', async function (event) {
    const date = event.detail.date;
    formatted = date.toISOString().split('T')[0]; // → '2025-04-25'
    

    axios.get(`/calendar/${formatted}`)
    .then(function (response) {
      
      // handle success
      const slotContainer = document.getElementById('timetable');
      const dateHeader =document.getElementById('dateHeader');
      const dateInput =document.getElementById('dateInput');
      const timeSlots = response.data;
      dateHeader.innerHTML=`${new Date(formatted + "T12:00:00").toDateString()}`;
      dateInput.value=`${formatted}`;
      if (timeSlots === undefined || timeSlots.length == 0) {
        
        slotContainer.innerHTML="";
        
      
        
    }else{
      
      slotContainer.innerHTML="";
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

document.querySelector("form").addEventListener("submit", function (event) {
  try {
      ;// Ensure correct date input
      let timeInput = document.querySelector('input[name="timetable"]:checked'); // Ensure radio button is selected
      
      // Ensure the date field is selected
      if (!formatted || formatted === "") {
          alert("Porfavor selecciona una fecha.");
          event.preventDefault();
          return;
      }


      // Time validation
      if (!timeInput) {
          alert("Porfavor seleccione una hora para la clase.");
          event.preventDefault();
          return;
      }
  } catch (error) {
      console.error("Error occurred during form validation:", error);
      console.log(formatted);
      
      alert("An unexpected error occurred. Please try again.");
      event.preventDefault();
  }
});
