document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id'); 


    console.log(id);
    fetch(`backend/get_Peticion.php?id=${id}`)


        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                const peticion = data.peticion;

                // Verifica si el objeto existe antes de modificar sus valores
                const nombreSolicitante = document.getElementById('nombre_solicitante');
                if (nombreSolicitante) {
                    nombreSolicitante.value = peticion.nombre_solicitante || '';
                }

                const contactoSolicitante = document.getElementById('contacto');
                if (contactoSolicitante) {
                    contactoSolicitante.value = peticion.contacto_solicitante || '';
                }

                const nombreProyecto = document.getElementById('nombre_proyecto');
                if (nombreProyecto) {
                    nombreProyecto.value = peticion.nombre_proyecto || '';
                }

                const rolSolicitante = document.getElementById('rol_solicitante');
                if (rolSolicitante) {
                    rolSolicitante.value = peticion.rol_solicitante || '';
                }

                const descripcionCambio = document.getElementById('descripcion_cambio');
                if (descripcionCambio) {
                    descripcionCambio.value = peticion.descripcion_cambio || '';
                }

                const prioridad = document.getElementById('prioridad');
                if (prioridad) {
                    prioridad.value = peticion.prioridad || '';
                }

                const razon = document.getElementById('razon');
                if (razon) {
                    razon.value = peticion.razon_cambio || '';
                }

                const tipoCambio = document.getElementById('tipo_cambio');
                if (tipoCambio) {
                    tipoCambio.value = peticion.tipo_cambio || '';
                }

                const descripcionRevision = document.getElementById('descripcion_revision');
                if (descripcionRevision) {
                    descripcionRevision.value = peticion.descripcion_revision || '';
                }

                const cronologiaPrevista = document.getElementById('cronologia_prevista');
                if (cronologiaPrevista) {
                    cronologiaPrevista.value = peticion.cronologia_prevista || '';
                }

                const costosEstimados = document.getElementById('costos_estimados');
                if (costosEstimados) {
                    costosEstimados.value = peticion.costos_estimados || '';
                }

                const accionesImplementar = document.getElementById('acciones_implementar');
                if (accionesImplementar) {
                    accionesImplementar.value = peticion.acciones_implementar || '';
                }

                const responsable = document.getElementById('responsable');
                if (responsable) {
                    responsable.value = peticion.responsable || '';
                }

                const tiempoImplementacion = document.getElementById('tiempo_implementacion');
                if (tiempoImplementacion) {
                    tiempoImplementacion.value = peticion.tiempo_implementacion || '';
                }

                const rolAprobador = document.getElementById('rol_aprobador');
                if (rolAprobador) {
                    rolAprobador.value = peticion.rol_aprobador || '';
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
                    fechaAprobacion.value = peticion.fecha_aprobacion || '';
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
