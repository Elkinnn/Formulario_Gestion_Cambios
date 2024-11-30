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
                    if (roles.length === 0) {
                        $('#rol_solicitante').append('<option value="" disabled>No hay roles disponibles</option>');
                    } else {
                        roles.forEach(function(role) {
                            $('#rol_solicitante').append('<option value="' + role + '">' + role + '</option>');
                        });
                    }

                    // Filtrar los solicitantes correspondientes al proyecto seleccionado
                    var solicitantes = data.solicitantes.filter(function(solicitante) {
                        return solicitante.proyecto === selectedProject;  // Filtrar por el nombre del proyecto
                    });

                    // Cargar los solicitantes en el select de nombre_solicitante
                    var solicitanteSelect = $('#nombre_solicitante');
                    solicitanteSelect.empty(); // Limpiar el select antes de llenarlo
                    solicitanteSelect.append('<option value="" disabled selected>Seleccione un solicitante</option>'); // Opción predeterminada

                    // Agregar los solicitantes como opciones en el select
                    if (solicitantes.length === 0) {
                        solicitanteSelect.append('<option value="" disabled>No hay solicitantes disponibles</option>');
                    } else {
                        solicitantes.forEach(function(solicitante) {
                            // Solo agregar el nombre del solicitante (sin el rol entre paréntesis)
                            solicitanteSelect.append('<option value="' + solicitante.id + '">' + solicitante.nombre + '</option>');
                        });
                    }
                }
            });

            // Este código se ejecuta cuando un solicitante es seleccionado
            $('#nombre_solicitante').change(function() {
                var solicitanteId = $(this).val(); // ID del solicitante seleccionado

                // Verificar si se ha seleccionado un solicitante
                if (solicitanteId) {
                    // Hacer una solicitud AJAX al servidor para obtener los datos del solicitante
                    $.ajax({
                        url: './backend/enviar_peticion_queries.php', // Ruta al archivo PHP que devuelve los datos del solicitante
                        method: 'POST',
                        data: {
                            'solicitante_id': solicitanteId
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);  // Para verificar la respuesta

                            // Verificar si la respuesta contiene datos del solicitante
                            if (response && response.telefono_solicitante) {
                                // Completar el campo 'contacto' con el teléfono del solicitante
                                $('#contacto').val(response.telefono_solicitante);
                            } else {
                                // Si no hay teléfono, vaciar el campo de contacto
                                $('#contacto').val('');
                                alert('No se encontró el teléfono del solicitante o la respuesta es incorrecta.');
                            }
                            
                            // Completar el campo de rol
                            if (response && response.rol_en_proyecto) {
                                $('#rol_solicitante').val(response.rol_en_proyecto); // Mostrar el rol en el campo de solo lectura
                            } else {
                                alert('No se encontró el rol del solicitante.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener datos del solicitante:', error);
                        }
                    });
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar los proyectos y roles:", error);
        }
    });
});
