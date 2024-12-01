fetch('./backend/revisar_peticion_queries.php')
.then(response => response.json())
.then(data => {
    let peticionesHTML = '';
    data.peticiones.forEach(peticion => {
        peticionesHTML += `
            <tr>
                <td>${peticion.id}</td>
                <td>${peticion.solicitante}</td>
                <td>${peticion.proyecto}</td>
                <td>${peticion.numero_cambio}</td>
                <td>${peticion.fecha_solicitud}</td>
                <td>${peticion.estado}</td>
                <td><a href="ver_detalles.php?id=${peticion.id}" class="btn btn-info btn-sm">Ver detalles</a></td>
            </tr>
        `;
    });
    document.getElementById('tabla_peticiones').innerHTML = peticionesHTML;
})
.catch(error => console.error('Error al cargar las peticiones:', error));