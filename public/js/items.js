$(function () {
    
    
    // Función para hacer la solicitud a la API
    function getItem() {
        fetch('/item')
            .then(response => response.json())
            .then(data => {
               console.log(data)
                displayItems(data);
            })
            .catch(error => {
                console.error('Error al obtener las items:', error);
            });
    }
    

    function displayItems(items) {
        const itemsSelect = document.getElementById('itemsSelect');
    
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.nombre;
            usuariosSelect.appendChild(option);
        });

    }
    getUsuarios()
 
})