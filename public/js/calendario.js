$(document).ready(function() {
    if ($('#calendar').length > 0) {
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
            // alert('ID del evento: ' + info.event.id);

            var entityId = info.event.id;
            var entityTitle = info.event.title;
            var fecha = info.event.start;

         
            $('#modaldatos').modal('show');

            
            $('#modaldatos .modal-body').html('<p>ID: ' + entityId + '</p> <p>Titulo: ' + entityTitle + '</p>'+'<p>Fecha y hora: ' + fecha);


             $('#pasarlista').on('click', function () {
                
                window.location.href = "informes/"+entityId;

            })
        }
    });
   
    calendar.render();
}if($('#calendariogeneral').length > 0) {
    alert("esto va")

    var calendarEl = $('#calendariogeneral');
  
    var calendar = new FullCalendar.Calendar(calendarEl[0], {
        initialView: 'dayGridMonth',
        contentHeight: 400,
        updateSize: true,
        events: obtenerEventosTodos(),
        eventDataTransform: function(eventData) {
            return eventData;
        },
        eventClick: function(info) {
            // alert('ID del evento: ' + info.event.id);

            var entityId = info.event.id;
            var entityTitle = info.event.title;
            var fecha = info.event.start;
                var usuario_nombre = info.event.extendedProps.usuario_nombre;
                var usuario_apellido = info.event.extendedProps.usuario_apellido;

         
            $('#modaldatos').modal('show');

            
            $('#modaldatos .modal-body').html('<p>ID: ' + entityId + '</p> <p>Titulo: ' + entityTitle + '</p>'+'<p>Fecha y hora: ' + fecha+ '<p>Usuario: ' + usuario_nombre+ ' ' + usuario_apellido);


             $('#pasarlista').on('click', function () {
                
                window.location.href = "http://localhost:8000/admin?crudAction=editTour&crudControllerFqcn=App%5CController%5CAdmin%5CTourCrudController&entityId="+entityId;

            })
        }
    });
   
    calendar.render();
}
});

function obtenerEventos() {
    var eventos = [];
    var idusuario = $('#idusuario').html();
    $.ajax({
        url: '/tour/' +  idusuario,
        method: 'GET',
        async: false,
        success: function(data) {
            eventos = data.map(function(tour) {
                return {
                    id: tour.id,
                    title: tour.ruta_nombre,
                    start: tour.fecha_inicio.date,
                    // end: tour.fecha_inicio.date,
                };
            });
        },
        error: function(error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });

 

    return eventos;
}


function obtenerEventosTodos() {
    var eventos = [];
    $.ajax({
        url: '/tour/',
        method: 'GET',
        async: false,
        success: function(data) {
            eventos = data.map(function(tour) {
                return {
                    id: tour.id,
                    usuario_id: tour.usuario_id,
                    title: tour.ruta_nombre,
                    start: tour.fecha_inicio.date,
                    extendedProps: {
                        usuario_nombre: tour.usuario_nombre,
                        usuario_apellido: tour.usuario_apellido,
                    }
                };
            });
        },
        error: function(error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });

 

    return eventos;
}