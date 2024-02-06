 $(function() {
      $("#tabs").tabs({
        activate: function(event, ui) {
          // Inicializar el mapa cuando la pestaña "Aenean lacinia" se activa
          if (ui.newPanel.attr('id') === 'tabs-3') {
            initMap();
          }
        }
      });
    });

    var map; // Variable global para el objeto del mapa
    var marker; // Variable global para el marcador

    function initMap() {
      // Crear un nuevo mapa con Leaflet
      map = L.map('mapa').setView([37.7799, -3.7844], 15);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

      // Inicializar el marcador (inicialmente sin ubicación)
      marker = L.marker([0, 0]).addTo(map);

      // Agregar evento para obtener latitud y longitud al hacer clic en el mapa
      map.on('click', function (e) {
          var clickedLat = e.latlng.lat;
          var clickedLng = e.latlng.lng;

          // Actualizar la posición del marcador al hacer clic
          marker.setLatLng([clickedLat, clickedLng])
              .bindPopup('Nueva ubicación')
              .openPopup();

          // Actualizar las coordenadas en el formulario
          $("#latitudIni").text(clickedLat);
          $("#longitudIni").text(clickedLng);
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