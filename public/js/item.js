$(function () {
    var crearItemButton = $('#crearItemButton');

    crearItemButton.on('click', function () {
        var latitud = $('#latitudIni').text();
        var longitud = $('#longitudIni').text();

     

        console.log($('#imageTitle').val(), $('.richText-editor').html());

        titulo= $('#imageTitle').val()
        descripcion= $('.richText-editor').html()
        var localizacion = {
            latitud: latitud,
            longitud: longitud
        };
        foto="foto"
        localidad=$('#localidadesSelect').val();

        var datosPost = {
            "titulo": titulo,
            "descripcion": descripcion,
            "localizacion": localizacion,
            "foto": foto,
            "localidad": localidad
        };


        $.ajax({
            url: '/item/crear',
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