$(document).ready(function() {
    // Obtener los proyectos, roles y solicitantes cuando la página se carga
    $.ajax({
        url: './backend/enviar_peticion_queries.php',  // Ruta al archivo PHP que devuelve los proyectos, roles y solicitantes
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Cargar proyectos en el select de proyectos
            var dataProyectos = data.proyectos;
            for (var project in dataProyectos) {
                $('#nombre_proyecto').append('<option value="' + project + '">' + project + '</option>');
            }

            // Cuando se seleccione un proyecto
            $('#nombre_proyecto').change(function() {
                var selectedProject = $(this).val();  // Obtener el proyecto seleccionado
                
                // Verificar si se seleccionó un proyecto
                if (selectedProject) {
                    // Limpiar el select de roles
                    $('#rol_solicitante').empty();
                    $('#rol_solicitante').append('<option value="" disabled selected>Seleccione un rol</option>');
                    
                    // Obtener los roles correspondientes al proyecto seleccionado
                    var roles = dataProyectos[selectedProject];
                    
                    // Insertar los roles en el select de roles
                    roles.forEach(function(role) {
                        $('#rol_solicitante').append('<option value="' + role + '">' + role + '</option>');
                    });

                    // Filtrar los solicitantes correspondientes al proyecto seleccionado
                    var solicitantes = data.solicitantes.filter(function(solicitante) {
                        return solicitante.proyecto === selectedProject;  // Filtrar por el nombre del proyecto
                    });

                    // Cargar los solicitantes en el select de nombre_solicitante
                    var solicitanteSelect = $('#nombre_solicitante');
                    solicitanteSelect.empty(); // Limpiar el select antes de llenarlo
                    solicitanteSelect.append('<option value="" disabled selected>Seleccione un solicitante</option>'); // Opción predeterminada

                    // Agregar los solicitantes como opciones en el select
                    solicitantes.forEach(function(solicitante) {
                        solicitanteSelect.append('<option value="' + solicitante.id + '">' + solicitante.nombre + ' (' + solicitante.rol_en_proyecto + ')</option>');
                    });
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar los proyectos y roles:", error);
        }
    });

});

