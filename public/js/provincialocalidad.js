$(function () {
    

let todasLasLocalidades = [];

// Función para hacer la solicitud a la API de provincias
function getProvincias() {
    fetch('/provincia')
        .then(response => response.json())
        .then(data => {
            // Llamada a la función para mostrar los datos en el DOM
            displayProvincias(data);
        })
        .catch(error => {
            console.error('Error al obtener las provincias:', error);
        });
}

// Función para mostrar las provincias en el DOM
function displayProvincias(provincias) {
    const provinciasSelect = document.getElementById('provinciasSelect');

    provincias.forEach(provincia => {
        const option = document.createElement('option');
        option.value = provincia.id;
        option.textContent = provincia.nombre;
        provinciasSelect.appendChild(option);
    });

    // Almacenar todas las localidades cuando se cargan las provincias
    getTodasLasLocalidades();
}

// Función para hacer la solicitud a la API de localidades
function getTodasLasLocalidades() {
    fetch('/localidad')
        .then(response => response.json())
        .then(data => {
            // Almacenar todas las localidades en la variable global
            todasLasLocalidades = data;

            // Llamada a la función para obtener las localidades al cargar la página
            getLocalidades();
        })
        .catch(error => {
            console.error('Error al obtener todas las localidades:', error);
        });
}

// Función para hacer la solicitud a la API de localidades por provincia
function getLocalidades() {
    // Obtener la provincia seleccionada
    const provinciasSelect = document.getElementById('provinciasSelect');
    const provinciaId = provinciasSelect.value;

    // Filtrar las localidades por la provincia seleccionada
    const localidadesFiltradas = todasLasLocalidades.filter(localidad => localidad.provincia_id == provinciaId);

    // Llamada a la función para mostrar los datos en el DOM
    displayLocalidades(localidadesFiltradas);
}


function displayLocalidades(localidades) {
    const localidadesSelect = document.getElementById('localidadesSelect');
    localidadesSelect.innerHTML = ''; 

    localidades.forEach(localidad => {
        const option = document.createElement('option');
        option.value = localidad.id;
        option.textContent = localidad.nombre;
        localidadesSelect.appendChild(option);
    });
}

// Función para filtrar las localidades por provincia al cambiar la selección
function filtrarLocalidadesPorProvincia() {
    // Llamada a la función para obtener las localidades según la provincia seleccionada
    getLocalidades();
}

$("#provinciasSelect").on("change",function () {

    filtrarLocalidadesPorProvincia()
    
})


// Llamada a la función para obtener las provincias al cargar la página
getProvincias();


})