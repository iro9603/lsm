import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';


document.addEventListener('DOMContentLoaded', function(){
  
  let calendarEl = document.getElementById('calendar');
  if(calendarEl){
    let calendar = new Calendar(calendarEl, {
    plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
    initialView: 'timeGridWeek',
    events: '/api/timeSlots',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,listWeek'
    },
    selectable: true,
    editable: true,
    eventClick: function(info){

      Swal.fire({
        title: "¿Estás seguro?",
        text: "Eliminarás este bloque en el calendario!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, borrar!"
      }).then((result) => {
        if (result.isConfirmed) {          
          fetch(`/api/destroySlots/${info.event.title}`, { method: 'DELETE' })
          .then(() => info.event.remove())
          .then(()=> {
            calendar.refetchEvents();
            Swal.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
              icon: "success"
            });
          });
          
        }
      });
    },
    select: function(info){

      const startDateRaw = new Date(info.start);
      const startDateCopy = new Date(info.start);
      const endDateRaw = new Date(info.end);

      const startDateClean = info.start.toISOString().split('T')[0]; // objeto Date
      const endDateClean = info.end.toISOString().split('T')[0];

      const startTime = startDateRaw.toTimeString().split(' ')[0]; // HH:MM:SS
      const endTime = endDateRaw.toTimeString().split(' ')[0];


      const StartTimes = [];

      while (startDateCopy < endDateRaw){
        const time = startDateCopy.toTimeString().slice(0, 8);
        StartTimes.push(time);
        startDateCopy.setMinutes(startDateCopy.getMinutes()+30);
      }
      
      Swal.fire({
        title: "¿Estás seguro?",
        text: `Vas a seleccionar un horario de ${ startTime } a ${endTime}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, guardar!"
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('/api/reserveSlots',{
              method: 'POST',
              headers:{'Content-Type': 'application/json'},
            body: JSON.stringify({
                date: startDateClean,
                slots: StartTimes
              })
            })
            .then(res => res.json())
            .then(data => {
              calendar.refetchEvents();
              Swal.fire({
                title: "Guardado!",
                text: "Completado",
                icon: "success"
              });
            })
            .catch(err => console.error('Error:', err));
        }
      });    
    }
    });
    calendar.render();
  }


  
  
});



