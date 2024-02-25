$(function() {
  initMap();
});

var map; // Variable global para el objeto del mapa
var marker; // Variable global para el marcador

function initMap() {
  var rutaId = $('#idruta').text()
  var apiUrl = '/ruta/' + rutaId;

  // Make an AJAX request to get the route by ID
  $.ajax({
      url: apiUrl,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
          // Access the punto_inicio object containing latitude and longitude
          var puntoInicio = data.punto_inicio;

          // Crear un nuevo mapa con Leaflet
          map = L.map('mapa').setView([puntoInicio.latitud, puntoInicio.longitud], 15);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

          // Inicializar el marcador con la ubicación proporcionada
          marker = L.marker([puntoInicio.latitud, puntoInicio.longitud]).addTo(map);

          // Popup opcional para mostrar información en el marcador
          marker.bindPopup('Ubicación Inicial').openPopup();
      },
      error: function() {
          console.error('Error fetching route by ID');
      }
  });
}

function geocodificarDireccion() {
  var direccion = $("#ini-ruta").val();
  var nominatimURL = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(direccion);

  $.ajax({
    url: nominatimURL,
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      if (data.length > 0) {
        var latitud = data[0].lat;
        var longitud = data[0].lon;

        // Actualizar la posición del marcador
        marker.setLatLng([latitud, longitud])
          .bindPopup('Ubicación: ' + direccion)
          .openPopup();

        // Centrar el mapa en la nueva posición del marcador
        map.setView([latitud, longitud], 15);

        // Actualizar las coordenadas en el formulario
        $("#latitudIni").text(latitud);
        $("#longitudIni").text(longitud);
      } else {
        alert("No se encontraron coordenadas para la dirección proporcionada.");
      }
    },
    error: function () {
      alert("Error al obtener las coordenadas. Por favor, inténtalo de nuevo.");
    }
  });
}