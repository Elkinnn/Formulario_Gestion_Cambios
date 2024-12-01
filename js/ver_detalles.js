document.addEventListener('DOMContentLoaded', function () {
    // Fetch data from the backend or JSON file
    fetch('backend/get_Peticion.php?id=${id}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const peticion = data.peticion;

                // Verifica si el objeto existe antes de modificar sus valores
                const nombreSolicitante = document.getElementById('nombre_solicitante');
                if (nombreSolicitante) {
                    nombreSolicitante.value = peticion.nombre_solicitante || 'No definido';
                }

                const contactoSolicitante = document.getElementById('contacto');
                if (contactoSolicitante) {
                    contactoSolicitante.value = peticion.contacto_solicitante || 'No definido';
                }

                const nombreProyecto = document.getElementById('nombre_proyecto');
                if (nombreProyecto) {
                    nombreProyecto.value = peticion.nombre_proyecto || 'No definido';
                }

                const rolSolicitante = document.getElementById('rol_solicitante');
                if (rolSolicitante) {
                    rolSolicitante.value = peticion.rol_solicitante || 'No definido';
                }

                const descripcionCambio = document.getElementById('descripcion_cambio');
                if (descripcionCambio) {
                    descripcionCambio.value = peticion.descripcion_cambio || 'No definido';
                }

                const prioridad = document.getElementById('prioridad');
                if (prioridad) {
                    prioridad.value = peticion.prioridad || 'No definido';
                }

                const razon = document.getElementById('razon');
                if (razon) {
                    razon.value = peticion.razon_cambio || 'No definido';
                }

                const tipoCambio = document.getElementById('tipo_cambio');
                if (tipoCambio) {
                    tipoCambio.value = peticion.tipo_cambio || 'No definido';
                }

                const descripcionRevision = document.getElementById('descripcion_revision');
                if (descripcionRevision) {
                    descripcionRevision.value = peticion.descripcion_revision || 'No definido';
                }

                const cronologiaPrevista = document.getElementById('cronologia_prevista');
                if (cronologiaPrevista) {
                    cronologiaPrevista.value = peticion.cronologia_prevista || 'No definido';
                }

                const costosEstimados = document.getElementById('costos_estimados');
                if (costosEstimados) {
                    costosEstimados.value = peticion.costos_estimados || 'No definido';
                }

                const accionesImplementar = document.getElementById('acciones_implementar');
                if (accionesImplementar) {
                    accionesImplementar.value = peticion.acciones_implementar || 'No definido';
                }

                const responsable = document.getElementById('responsable');
                if (responsable) {
                    responsable.value = peticion.responsable || 'No definido';
                }

                const tiempoImplementacion = document.getElementById('tiempo_implementacion');
                if (tiempoImplementacion) {
                    tiempoImplementacion.value = peticion.tiempo_implementacion || 'No definido';
                }

                const rolAprobador = document.getElementById('rol_aprobador');
                if (rolAprobador) {
                    rolAprobador.value = peticion.rol_aprobador || 'No definido';
                }

                const aprobadoPor = document.getElementById('aprobado_por');
                if (aprobadoPor) {
                    // Si hay un valor para aprobado_por, selecciona la opción correspondiente
                    const options = aprobadoPor.querySelectorAll('option');
                    options.forEach(option => {
                        if (option.value == peticion.aprobado_por) {
                            option.selected = true;
                        }
                    });
                }

                const fechaAprobacion = document.getElementById('fecha_aprobacion');
                if (fechaAprobacion) {
                    fechaAprobacion.value = peticion.fecha_aprobacion || 'No definido';
                }

                const estado = document.getElementById('estado');
                if (estado) {
                    estado.value = peticion.estado || 'Pendiente';
                }
            } else {
                console.error('Error al obtener los detalles de la solicitud');
            }
        })
        .catch(error => {
            console.error('Error al obtener los detalles:', error);
        });
});
