$(function () {
    var jsonArrayProgramacion = [];
    var crearRutaButton = $('#crearRutaButton');

    crearRutaButton.on('click', function () {

        console.log(jsonArrayProgramacion);
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
            jsonArrayProgramacion
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




        
var btnAgregar = $('#btnAgregar');
i=0

btnAgregar.on('click', function () {
    i=i+1
    validadordiasemana=0
 
  

    diasdelasemana=[]

    if ($('#btn-lunes').is(':checked')) {
         diasdelasemana.push($('#btn-lunes + label').text());
         validadordiasemana=validadordiasemana+1
    }
    if ($('#btn-martes').is(':checked')) {
        diasdelasemana.push($('#btn-martes + label').text());
        validadordiasemana=validadordiasemana+1
    }
    if ($('#btn-miercoles').is(':checked')) {
        diasdelasemana.push($('#btn-miercoles + label').text());
        validadordiasemana=validadordiasemana+1
    }
    if ($('#btn-jueves').is(':checked')) {
        diasdelasemana.push($('#btn-jueves + label').text());
        validadordiasemana=validadordiasemana+1
    }
    if ($('#btn-viernes').is(':checked')) {
        diasdelasemana.push($('#btn-viernes + label').text());
        validadordiasemana=validadordiasemana+1
    }
    if ($('#btn-sabado').is(':checked')) {
        diasdelasemana.push($('#btn-sabado + label').text());
        validadordiasemana=validadordiasemana+1
    }
    if ($('#btn-domingo').is(':checked')) {
        diasdelasemana.push($('#btn-domingo + label').text());
        validadordiasemana=validadordiasemana+1
    }



        nombreguia=$('#usuariosSelect option:selected').text();
        idguia=$('#usuariosSelect').val()

        startDateProg=$('#startDateProg').val()
        endDateProg=$('#endDateProg').val()

        horaProg=$('#horaProg').val()
        minutoProg=$('#minutoProg').val()

        var numeroFilas = $("#tablaprog tbody tr").length;

    
       

    
    console.log(nombreguia+" "+idguia)
    console.log(diasdelasemana)
    console.log(startDateProg+" - "+endDateProg)
    console.log(horaProg+":"+minutoProg)
  


  
    var nuevaFila =  '<tr id="fila' + i + '">' +
    '<td id="nombreGuia' + i + '" class="nombreGuia" value="' + idguia + '">' + nombreguia + '</td>' +
    '<td id="diasSemana'+ i + '" class="diasSemana">' + diasdelasemana + '</td>' +
    '<td id="hora'+ i + '" class="hora">' + horaProg + ':' + minutoProg + '</td>' +
    '<td id="temporadaInicio' + i + '" class="temporadaIni">' + startDateProg + '</td>' +
    '<td id="temporadaFinal' + i + '" class="temporadaFin">' + endDateProg + '</td>' +
    '<td><button class="btn btn-danger btnEliminar" data-indice="' + i + '">Eliminar</button></td>' +
  '</tr>';

  if (validadordiasemana != 0) {
    if (startDateProg !== "" && endDateProg !== "") {
        if (horaProg.length === 2 && minutoProg.length === 2 && horaProg !== "" && minutoProg !== "" && horaProg >= 0 && horaProg <= 23 && minutoProg >= 0 && minutoProg <= 59) {
            $('table tbody').append(nuevaFila);



            console.log("Número de filas: " + numeroFilas);

           
              
            jsonArrayProgramacion = [];
                for (var j = 0; j < numeroFilas+1; j++) {
                    var filaActual = $("#tablaprog tbody tr").eq(j);
    
                    var idGuiaSeleccionada = filaActual.find("td.nombreGuia").attr("value");
                    var diassemanaSeleccionada = filaActual.find("td.diasSemana").text();
                    var arrayDiasSemana = diassemanaSeleccionada.split(',');
                    var horaSeleccionada = filaActual.find("td.hora").text();
                    var tiniSeleccionada = filaActual.find("td.temporadaIni").text();
                    var tfinSeleccionada = filaActual.find("td.temporadaFin").text();
            
                    
                    var jsonData = {
                        idGuia: idGuiaSeleccionada,
                        diasSemana: arrayDiasSemana,
                        hora: horaSeleccionada,
                        temporadaIni: tiniSeleccionada,
                        temporadaFin: tfinSeleccionada
                    };
                
            
                    jsonArrayProgramacion.push(jsonData);
                
                   
      
                }
              
                console.log(jsonArrayProgramacion);
            
    



        } else {
            alert("Debe seleccionar una hora válida");
        }
    } else {
        alert("Debe seleccionar una fecha de inicio y fin");
    }
} else {
    alert("Debe seleccionar por lo menos un día de la semana");
}
    

    $(document).on('click', '.btnEliminar', function() {
        var indice = $(this).data('indice');
        $('#fila' + indice).remove();
      });
      

});



// programacion


});