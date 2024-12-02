<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Petición</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="css/ver_detalles.css" rel="stylesheet">
</head>

<body>

    <?php
    // Incluir el archivo que obtiene la solicitud
    require_once('backend/get_peticion.php');
    ?>
    <a href="revisar_peticion.php" class="btn btn-outline-secondary btn-regresar">
        <i class="bi bi-arrow-left-circle"></i> Regresar
    </a>

    <div class="container mt-5">
        <h2 class="text-center">Detalles de la Solicitud</h2>

        <form action="backend/modificar_peticion_queries.php" method="POST">

            <!-- Información básica -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                    <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud"
                        value="<?php echo isset($peticion['fecha_solicitud']) ? $peticion['fecha_solicitud'] : 'No definido'; ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label for="numero_cambio" class="form-label">Número de Cambio</label>
                    <input type="text" class="form-control" id="numero_cambio" name="numero_cambio"
                        value="<?php echo isset($peticion['numero_cambio']) ? $peticion['numero_cambio'] : 'No definido'; ?>"
                        readonly>
                </div>
            </div>

            <!-- Información del Proyecto y Solicitante -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre_proyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto"
                        value="<?php echo isset($peticion['nombre_proyecto']) ? $peticion['nombre_proyecto'] : 'No definido'; ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label for="rol_solicitante" class="form-label">Rol Solicitante</label>
                    <input type="text" class="form-control" id="rol_solicitante" name="rol_solicitante"
                        value="<?php echo isset($peticion['rol_solicitante']) ? $peticion['rol_solicitante'] : 'No definido'; ?>"
                        readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre_solicitante" class="form-label">Nombre Solicitante</label>
                    <input type="text" class="form-control" id="nombre_solicitante" name="nombre_solicitante"
                        value="<?php echo isset($peticion['nombre_solicitante']) ? $peticion['nombre_solicitante'] : 'No definido'; ?>"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label for="contacto" class="form-label">Contacto del Solicitante</label>
                    <input type="text" class="form-control" id="contacto" name="contacto"
                        value="<?php echo isset($peticion['contacto_solicitante']) ? $peticion['contacto_solicitante'] : 'No definido'; ?>"
                        readonly>
                </div>
            </div>

            <!-- Solicitud de Cambio -->
            <h4>1. Solicitud de Cambio</h4>
            <div class="mb-3">
                <label for="descripcion_cambio" class="form-label">Descripción del Cambio</label>
                <textarea class="form-control" id="descripcion_cambio" name="descripcion_cambio" rows="4" readonly>
                    <?php echo isset($peticion['descripcion_cambio']) ? $peticion['descripcion_cambio'] : 'No definido'; ?>
                </textarea>
            </div>
            <div class="mb-3">
                <label for="prioridad" class="form-label">Prioridad</label>
                <select class="form-select" id="prioridad" name="prioridad" disabled>
                    <option value="Alta" <?php echo (isset($peticion['prioridad']) && $peticion['prioridad'] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                    <option value="Media" <?php echo (isset($peticion['prioridad']) && $peticion['prioridad'] == 'Media') ? 'selected' : ''; ?>>Media</option>
                    <option value="Baja" <?php echo (isset($peticion['prioridad']) && $peticion['prioridad'] == 'Baja') ? 'selected' : ''; ?>>Baja</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="razon" class="form-label">Razón del Cambio</label>
                <textarea class="form-control" id="razon" name="razon" rows="4" readonly>
        <?php echo isset($peticion['razon_cambio']) ? $peticion['razon_cambio'] : 'No definido'; ?>
    </textarea>
            </div>

            <!-- Revisión del Cambio -->
            <h4 class="text-muted">2. Revisión del Cambio</h4>

            <div class="mb-3">
                <label for="tipo_cambio" class="form-label">Tipo</label>
                <select class="form-select" id="tipo_cambio" name="tipo_cambio">
                    <option value="Correctivo" <?php echo (isset($peticion['tipo_cambio']) && $peticion['tipo_cambio'] == 'Correctivo') ? 'selected' : ''; ?>>Correctivo</option>
                    <option value="Mejora" <?php echo (isset($peticion['tipo_cambio']) && $peticion['tipo_cambio'] == 'Mejora') ? 'selected' : ''; ?>>Mejora</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion_revision" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion_revision" name="descripcion_revision"
                    rows="4"><?php echo isset($peticion['descripcion_revision']) ? $peticion['descripcion_revision'] : ''; ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cronologia_prevista" class="form-label">Cronología Prevista</label>
                    <input type="text" class="form-control" id="cronologia_prevista" name="cronologia_prevista"
                        value="<?php echo isset($peticion['cronologia_prevista']) ? $peticion['cronologia_prevista'] : ''; ?>">
                </div>
                <div class="col-md-6">
                    <label for="costos_estimados" class="form-label">Costos Estimados</label>
                    <input type="text" class="form-control" id="costos_estimados" name="costos_estimados"
                        value="<?php echo isset($peticion['costos_estimados']) ? $peticion['costos_estimados'] : ''; ?>">
                </div>
            </div>

            <!-- Seguimiento del Cambio -->
            <h4 class="text-muted">3. Seguimiento del Cambio</h4>
            <div class="mb-3">
                <label for="acciones_implementar" class="form-label">Acciones a Implementar</label>
                <textarea class="form-control" id="acciones_implementar" name="acciones_implementar"
                    rows="4"><?php echo isset($peticion['acciones_implementar']) ? $peticion['acciones_implementar'] : ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="responsable" class="form-label">Responsable</label>
                <input type="text" class="form-control" id="responsable" name="responsable"
                    value="<?php echo isset($peticion['responsable']) ? $peticion['responsable'] : ''; ?>">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tiempo_implementacion" class="form-label">Tiempo de Implementación</label>
                    <input type="text" class="form-control" id="tiempo_implementacion" name="tiempo_implementacion"
                        value="<?php echo isset($peticion['tiempo_implementacion']) ? $peticion['tiempo_implementacion'] : ''; ?>">
                </div>
            </div>

            <!-- Aprobación -->
            <h4 class="text-muted">Aprobación</h4>
            <div class="mb-3">
                <label for="rol_aprobador" class="form-label">Rol en Aprobación</label>
                <input type="text" class="form-control" id="rol_aprobador" name="rol_aprobador"
                    value="<?php echo isset($rol_aprobador) ? $rol_aprobador : ''; ?>" readonly>
            </div>


            <div class="mb-3">
                <label for="aprobado_por" class="form-label">Aprobado por</label>
                <select class="form-select" id="aprobado_por" name="aprobado_por">
                    <!-- Opciones se cargarán desde la base de datos -->
                    <?php
                    if (isset($aprobadores)) {
                        foreach ($aprobadores as $aprobador) {
                            echo "<option value='" . $aprobador['id'] . "' " . (isset($peticion['aprobado_por']) && $peticion['aprobado_por'] == $aprobador['id'] ? 'selected' : '') . ">" . $aprobador['nombre'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_aprobacion" class="form-label">Fecha de Aprobación</label>
                <input type="date" class="form-control" id="fecha_aprobacion" name="fecha_aprobacion"
                    value="<?php echo isset($peticion['fecha_aprobacion']) ? $peticion['fecha_aprobacion'] : ''; ?>">
            </div>

            <!-- Estado de la Petición -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado de la Petición</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="Pendiente" <?php echo (isset($peticion['estado']) && $peticion['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Aprobado" <?php echo (isset($peticion['estado']) && $peticion['estado'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                    <option value="Rechazado" <?php echo (isset($peticion['estado']) && $peticion['estado'] == 'Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Solicitud</button>
            <input type="hidden" name="id" value="<?php echo $peticion['id']; ?>">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestión de Cambios. Todos los derechos reservados.</p>
    </footer>
    <script src="js/ver_detalles.js"></script>
</body>

</html>