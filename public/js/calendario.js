$(document).ready(function() {
    var calendarEl = $('#calendar');
  
    var calendar = new FullCalendar.Calendar(calendarEl[0], {
        initialView: 'dayGridMonth',
        contentHeight: 400,
        updateSize: true,
        events: obtenerEventos(),
        eventDataTransform: function(eventData) {
            return eventData;
        },
        eventClick: function(info) {
            alert('ID del evento: ' + info.event.id);
        }
    });
   
    calendar.render();
});

function obtenerEventos() {
    var eventos = [];
    var idusuario = $('#idusuario').html();
    $.ajax({
        url: '/tour/' +  idusuario,
        method: 'GET',
        async: false,
        success: function(data) {
            eventos = data.map(function(item) {
                return {
                    id: item.id,
                    title: 'Tour ' + item.id,
                    start: item.fecha_inicio.date,
                    // end: item.fecha_inicio.date,
                };
            });
        },
        error: function(error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });


    return eventos;
}
