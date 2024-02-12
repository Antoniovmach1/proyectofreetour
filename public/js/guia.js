$(function () {
    
    
    // Función para hacer la solicitud a la API
    function getUsuarios() {
        fetch('/guia')
            .then(response => response.json())
            .then(data => {
               console.log(data)
                displayUsuarios(data);
            })
            .catch(error => {
                console.error('Error al obtener las usuarios:', error);
            });
    }
    

    function displayUsuarios(usuarios) {
        const usuariosSelect = document.getElementById('usuariosSelect');
    
        usuarios.forEach(usuario => {
            const option = document.createElement('option');
            option.value = usuario.id;
            option.textContent = usuario.nombre +" "+ usuario.apellidos ;
            usuariosSelect.appendChild(option);
        });

    }
    getUsuarios()
 
})