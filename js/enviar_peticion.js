// scripts.js
$(document).ready(function() {
    // Fetch projects when the page loads
    $.ajax({
        url: './backend/enviar_peticion_queries.php',  // Ruta al archivo PHP que devuelve los proyectos
        method: 'GET',
        success: function(data) {
            var projects = JSON.parse(data);  // Parseamos la respuesta JSON
            projects.forEach(function(project) {
                // Insertamos los proyectos en el select
                $('#nombre_proyecto').append('<option value="' + project.nombre + '">' + project.nombre + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los proyectos:', error);
        }
    });
});
