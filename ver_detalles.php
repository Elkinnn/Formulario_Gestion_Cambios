<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Petición</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="css/ver_detalles.css" rel="stylesheet">
</head>

<body>

    <?php
    // Incluir el archivo que obtiene la solicitud
    require_once('backend/get_peticion.php');
    ?>

    <div class="container mt-5">
        <h2 class="text-center">Detalles de la Solicitud</h2>

        <form action="backend/modificar_peticion_queries.php" method="POST">

            <!-- Información básica -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                    <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud"
                        value="<?php echo $peticion['fecha_solicitud']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="numero_cambio" class="form-label">Número de Cambio</label>
                    <input type="text" class="form-control" id="numero_cambio" name="numero_cambio"
                        value="<?php echo $peticion['numero_cambio']; ?>" readonly>
                </div>
            </div>

            <!-- Solicitud de Cambio -->
            <h4>1. Solicitud de Cambio</h4>
            <div class="mb-3">
                <label for="descripcion_cambio" class="form-label">Descripción del Cambio</label>
                <textarea class="form-control" id="descripcion_cambio" name="descripcion_cambio" rows="4"
                    readonly><?php echo $peticion['descripcion_cambio']; ?></textarea>
            </div>

            <!-- Revisión del Cambio (Bloqueada para el usuario) -->
            <h4 class="text-muted">2. Revisión del Cambio</h4>
            <div class="mb-3">
                <label for="descripcion_revision" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion_revision" name="descripcion_revision" rows="4"
                    readonly><?php echo $peticion['descripcion_revision']; ?></textarea>
            </div>

            <!-- Seguimiento del Cambio -->
            <h4 class="text-muted">3. Seguimiento del Cambio</h4>
            <div class="mb-3">
                <label for="acciones_implementar" class="form-label">Acciones a Implementar</label>
                <textarea class="form-control" id="acciones_implementar" name="acciones_implementar" rows="4"
                    readonly><?php echo $peticion['acciones_implementar']; ?></textarea>
            </div>

            <!-- Estado de la Petición -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado de la Petición</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="Pendiente" <?php echo ($peticion['estado'] == 'Pendiente') ? 'selected' : ''; ?>>
                        Pendiente</option>
                    <option value="Aprobado" <?php echo ($peticion['estado'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado
                    </option>
                    <option value="Rechazado" <?php echo ($peticion['estado'] == 'Rechazado') ? 'selected' : ''; ?>>
                        Rechazado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Solicitud</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestión de Cambios. Todos los derechos reservados.</p>
    </footer>
</body>

</html>