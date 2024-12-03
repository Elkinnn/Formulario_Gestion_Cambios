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
// Función para mostrar alertas personalizadas
function mostrarAlerta(tipo, mensaje) {
    // Crear la alerta
    var alert = $('<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert"></div>');

    // Agregar el contenido a la alerta
    alert.append('<strong>' + tipo.charAt(0).toUpperCase() + tipo.slice(1) + '!</strong> ' + mensaje);
    alert.append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');

    // Agregar la alerta al contenedor
    $('#alert-container').append(alert);

    // Usar jQuery para manejar el cierre de la alerta al hacer clic en la "X"
    alert.find('.close').click(function() {
        alert.remove(); // Elimina la alerta del DOM
    });
}

// Aquí va el resto de tu código JavaScript
$(document).ready(function() {
    // ... Tu lógica AJAX y otras funciones
});
    // Limpiar los campos al enviar el formulario
    $('form').submit(function(event) {
        event.preventDefault();  // Evitar que el formulario se envíe de manera tradicional

        // Establecer el estado en "Pendiente" al enviar
        $('#estado_solicitud').val('Pendiente');
        
        $.ajax({
            url: './backend/enviar_peticion_queries.php',  // Ruta al archivo PHP que maneja la solicitud
            method: 'POST',
            data: $('form').serialize(),  // Serializa todos los datos del formulario
            success: function(response) {
                // Mostrar una alerta indicando que la solicitud se ha enviado
                mostrarAlerta('success', 'Solicitud enviada exitosamente.');
        
                // Limpiar todos los campos después de enviar
                $('form')[0].reset(); // Resetea el formulario
                $('#estado_solicitud').val('Pendiente'); // Restablecer el estado a Pendiente
            },
            error: function(xhr, status, error) {
                console.error('Error al enviar la solicitud:', error);
                
                // Mostrar una alerta de error
                mostrarAlerta('danger', 'Hubo un problema al enviar la solicitud. Por favor, intente de nuevo.');
            }
        });
    });
});
