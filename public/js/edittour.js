$(function () {



    function getRutas() {
        fetch('/ruta') // Ajusta la URL según la configuración de tu Symfony
            .then(response => response.json())
            .then(data => {
                console.log(data);
                displayRutas(data);
            })
            .catch(error => {
                console.error('Error al obtener las rutas:', error);
            });
    }
    
    function displayRutas(rutas) {
        const rutasSelect = document.getElementById('rutasSelect'); // Ajusta el ID según tu estructura HTML
    
        rutas.forEach(ruta => {
            const option = document.createElement('option');
            option.value = ruta.id;
            option.textContent = ruta.titulo + " - " + ruta.descripcion; // Puedes ajustar la presentación según tus necesidades
            rutasSelect.appendChild(option);
        });
    }
    
    // Llama a la función para obtener y mostrar las rutas al cargar la página
    getRutas();



    var actualizartour = $('#actualizartourButton');

    actualizartour.on('click', function () {
        var idtour= $('#idtour').html()
        var fechaYHora = $('#fechaYHora').val();
        var usuariosSelect = $('#usuariosSelect').val();
        var rutasSelect = $('#rutasSelect').val();

        var datos = {
            id: idtour,
            fecha_inicio: fechaYHora,
            ruta_id: rutasSelect,
            usuario_id: usuariosSelect
        };
    
    
        $.ajax({
            url: '/tour/actualizar',
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(datos),
            success: function (response) {
                console.log(response.message);
                alert("se ha actualizado correctamente")
             
            },
            error: function (error) {
                console.error('Error al actualizar el tour:', error.responseJSON.error);
                alert("Error")
             
            }
        });
    });


})

