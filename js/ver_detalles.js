document.addEventListener('DOMContentLoaded', function () {
    // Obtener el ID de la solicitud desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    let aprobadoresData = [];  // Variable para almacenar la lista de aprobadores

    // Cargar los detalles de la solicitud
    fetch(`backend/get_Peticion.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los detalles de la solicitud');
            }
            return response.json();
        })
        .then(data => {
            if (data.peticion) {
                // Mostrar detalles de la solicitud
                document.getElementById('nombre_solicitante').textContent = data.peticion.nombre_solicitante;
                document.getElementById('contacto_solicitante').textContent = data.peticion.contacto_solicitante;
                document.getElementById('nombre_proyecto').textContent = data.peticion.nombre_proyecto;
                document.getElementById('rol_solicitante').textContent = data.peticion.rol_solicitante;

                // Llenar el campo "Aprobado por" con los miembros y líderes del proyecto
                const aprobadoSelect = document.getElementById('aprobado_por');
                aprobadoresData = data.aprobadores || [];  // Guardar los aprobadores en una variable externa

                // Limpiar las opciones previas
                aprobadoSelect.innerHTML = '';

                // Agregar los nuevos aprobadores al select
                aprobadoresData.forEach(aprobador => {
                    const option = document.createElement('option');
                    option.value = aprobador.id;
                    option.textContent = `${aprobador.nombre} - ${aprobador.rol_en_proyecto}`;
                    aprobadoSelect.appendChild(option);
                });

                // Si ya tiene un aprobador seleccionado, establecerlo
                if (data.peticion.aprobado_por) {
                    document.getElementById('aprobado_por').value = data.peticion.aprobado_por;
                    document.getElementById('rol_en_aprobacion').value = data.peticion.rol_en_aprobacion;
                }
            }
        })
        .catch(error => console.error('Error al cargar la solicitud:', error));

    // Cambiar el rol en el campo "Rol en Aprobación" cuando se selecciona un aprobador
    document.getElementById('aprobado_por').addEventListener('change', function () {
        const aprobadoId = this.value;

        // Buscar el aprobador seleccionado por su id
        const seleccionado = aprobadoresData.find(aprobador => aprobador.id == aprobadoId);

        // Si el aprobador existe, actualizar el rol en aprobación
        if (seleccionado) {
            document.getElementById('rol_en_aprobacion').value = seleccionado.rol_en_proyecto;
        }
    });
});
