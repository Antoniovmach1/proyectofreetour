$(function () {
    

let todasLasLocalidades = [];


function getProvincias() {
    fetch('/provincia')
        .then(response => response.json())
        .then(data => {
         
            displayProvincias(data);
        })
        .catch(error => {
            console.error('Error al obtener las provincias:', error);
        });
}

function displayProvincias(provincias) {
    const provinciasSelect = document.getElementById('provinciasSelect');



    const optionvacio = document.createElement('option');
    optionvacio.value = "-2";
    optionvacio.textContent = "";
    provinciasSelect.appendChild(optionvacio);
    
   
    const optiontodos = document.createElement('option');
    optiontodos.value = "-1";
    optiontodos.textContent = "Todos los item";
    provinciasSelect.appendChild(optiontodos);
    

    provincias.forEach(provincia => {
        const option = document.createElement('option');
        option.value = provincia.id;
        option.textContent = provincia.nombre;
      
        provinciasSelect.appendChild(option);
    });

    getTodasLasLocalidades();
}

function getTodasLasLocalidades() {
    fetch('/localidad')
        .then(response => response.json())
        .then(data => {

            todasLasLocalidades = data;


            getLocalidades();
        })
        .catch(error => {
            console.error('Error al obtener todas las localidades:', error);
        });
}


function getLocalidades() {

    const provinciasSelect = document.getElementById('provinciasSelect');
    const provinciaId = provinciasSelect.value;


    const localidadesFiltradas = todasLasLocalidades.filter(localidad => localidad.provincia_id == provinciaId);


    displayLocalidades(localidadesFiltradas);
}


function displayLocalidades(localidades) {
    const localidadesSelect = document.getElementById('localidadesSelect');
    localidadesSelect.innerHTML = ''; 

    if (provinciasSelect.value !=-1 ) {
        // alert(provinciasSelect.value)
        const optiontodos = document.createElement('option');
        optiontodos.value = "0";
        optiontodos.textContent = ""
        localidadesSelect.appendChild(optiontodos);
     
    }
    

    localidades.forEach(localidad => {
        const option = document.createElement('option');
        option.value = localidad.id;
        option.textContent = localidad.nombre;
        localidadesSelect.appendChild(option);
    });
}


function filtrarLocalidadesPorProvincia() {
   
    getLocalidades();
}

$("#provinciasSelect").on("change",function () {

    filtrarLocalidadesPorProvincia()
    
})



getProvincias();


})