$(function () {
    var crearRutaButton = $('#crearRutaButton');

    crearRutaButton.on('click', function () {
        var latitud = $('#latitudIni').text();
        var longitud = $('#longitudIni').text();

        fecha_ini= $('#startDate').val()
        fecha_fin= $('#endDate').val()

        console.log($('#tituloruta').val(), $('.richText-editor').html());

        titulo= $('#tituloruta').val()
        descripcion= $('.richText-editor').html()
        var punto_inicio = {
            latitud: latitud,
            longitud: longitud
        };
        foto="foto"
        var fecha_ini_formateada = new Date(fecha_ini).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
        var fecha_fin_formateada = new Date(fecha_fin).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
        aforo= $('#afororuta').val()


        var programacion = {
            latitud: latitud,
            longitud: longitud
        };
        



        var datosPost = {
            "titulo": titulo,
            "descripcion": descripcion,
            "foto": foto,
            "punto_inicio": punto_inicio,
            "fecha_ini": fecha_ini_formateada,
            "fecha_fin": fecha_fin_formateada,
            "aforo": aforo,
            "programacion": programacion,
 
        };

        $.ajax({
            url: '/ruta/crear',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datosPost),
            dataType: 'json',
            success: function (data) {
                console.log('Respuesta del servidor:', data);
            },
            error: function (error) {
                console.error('Error en la solicitud:', error.responseText);
            }
        });
    });
});