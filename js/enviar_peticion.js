$(document).ready(function() {
    // Obtener proyectos con roles cuando la página se carga
    $.ajax({
        url: './backend/enviar_peticion_queries.php',  // Ruta al archivo PHP que devuelve los proyectos y roles
        method: 'GET',
        success: function(data) {
            var data = JSON.parse(data);  // Parseamos la respuesta JSON
            
            // Cargar proyectos en el select de proyectos
            for (var project in data.proyectos_roles) {
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
                    var roles = data.proyectos_roles[selectedProject];
                    
                    // Insertar los roles en el select de roles
                    if (roles) {
                        roles.forEach(function(role) {
                            $('#rol_solicitante').append('<option value="' + role + '">' + role + '</option>');
                        });
                    } else {
                        $('#rol_solicitante').append('<option value="">No hay roles disponibles</option>');
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los proyectos y roles:', error);
        }
    });

    // Obtener los solicitantes cuando la página se carga
    $.ajax({
        url: './backend/enviar_peticion_queries.php', // Ruta al archivo PHP que devuelve los solicitantes
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Llenar el select con los solicitantes
            var solicitanteSelect = $('#nombre_solicitante');
            solicitanteSelect.empty(); // Limpiar el select antes de llenarlo
            solicitanteSelect.append('<option value="" disabled selected>Seleccione un solicitante</option>'); // Opción predeterminada

            // Agregar los solicitantes como opciones en el select
            data.forEach(function(solicitante) {
                solicitanteSelect.append('<option value="' + solicitante.id + '">' + solicitante.nombre + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar los solicitantes:", error);
        }
    });
});
