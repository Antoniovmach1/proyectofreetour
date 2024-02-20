$(function () {

    var tituloElemento = document.querySelector('.content-header-title .title');


    tituloElemento.textContent = ' ';


    $(".content").append($("#todoitem"))


    var crearItemButton = $('#crearItemButton');

    crearItemButton.on('click', function () {
        var latitud = $('#latitudIni').text();
        var longitud = $('#longitudIni').text();

        console.log($('#imageTitle').val(), $('.richText-editor').html());

        var titulo = $('#imageTitle').val();
        var descripcion = $('.richText-editor').html();
        var localizacion = {
            latitud: latitud,
            longitud: longitud
        };
        foto = $("input[type=file]")[0].files[0];

        localidad = $('#localidadesSelect').val();

        

        // var datosPost = {
        //     "titulo": titulo,
        //     "descripcion": descripcion,
        //     "localizacion": localizacion,
        //     "foto": JSON.stringify(foto),
        //     "localidad": localidad
        // };
        var formdata = new FormData()
        formdata.append("titulo" ,titulo)
        formdata.append("descripcion" ,descripcion)
        formdata.append("localizacion" ,JSON.stringify(localizacion))
        formdata.append("foto" ,foto, foto.name)
        formdata.append("localidad" ,localidad)
       

        $.ajax({
            url: '/item/crear',
            type: 'POST',
            contentType: 'application/json',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log('Respuesta del servidor:', data);
            },
            error: function (error) {
                console.error('Error en la solicitud:', error.responseText);
            }
        });
    });

    var todosLosItem = [];
    // getItemPorLocalidad();

    function getItemPorLocalidad() {
        localidadiditem = document.getElementById("localidadesSelect").value;
        fetch('/item/' + localidadiditem)
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                todosLosItem = data;
                getItems();
            })
            .catch(error => {
                console.error('Error al obtener todos los items:', error);
            });
    }

    function getItems() {
        const sortable2 = $("#sortable2");
        const sortable1 = $("#sortable1");
        sortable2.empty(); 
        sortable1.empty(); 
        todosLosItem.forEach(item => {
            const listItem = $("<li>").text(item.nombre);
            listItem.addClass('list-group-item');
            listItem.css('width', '180px');
            listItem.attr('id', item.id)
            sortable2.append(listItem);
        });
    }

    $("#localidadesSelect, #provinciasSelect").on("change", function () {
        getItemPorLocalidad();
    });
});
