<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitud y Control de Cambios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/enviar_peticion.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Gestión de Cambios</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="enviar_peticion.php">Enviar Petición</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="review.html">Revisar Peticiones</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
    <h2 class="text-center">Formulario de Solicitud y Control de Cambios</h2>
    <form action="procesar_peticion.php" method="POST" class="mt-4">
        <!-- Información básica -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" required>
            </div>
            <div class="col-md-6">
                <label for="numero_cambio" class="form-label">Número de Cambio</label>
                <input type="text" class="form-control" id="numero_cambio" name="numero_cambio" placeholder="Ej: NC-001" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre_proyecto" class="form-label">Nombre del Proyecto</label>
                <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" required>
            </div>
            <div class="col-md-6">
                <label for="rol_solicitante" class="form-label">Rol Solicitante</label>
                <select class="form-select" id="rol_solicitante" name="rol_solicitante" required>
                    <option value="Solicitante">Solicitante</option>
                    <option value="Revisor">Revisor</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre_solicitante" class="form-label">Nombre del Solicitante</label>
                <input type="text" class="form-control" id="nombre_solicitante" name="nombre_solicitante" required>
            </div>
            <div class="col-md-6">
                <label for="contacto" class="form-label">Contacto del Solicitante</label>
                <input type="text" class="form-control" id="contacto" name="contacto" required>
            </div>
        </div>

        <!-- Solicitud de Cambio -->
        <h4>1. Solicitud de Cambio</h4>
        <div class="mb-3">
            <label for="descripcion_cambio" class="form-label">Descripción del Cambio</label>
            <textarea class="form-control" id="descripcion_cambio" name="descripcion_cambio" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select class="form-select" id="prioridad" name="prioridad" required>
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="razon" class="form-label">Razón del Cambio</label>
            <textarea class="form-control" id="razon" name="razon" rows="4" required></textarea>
        </div>

        <!-- Revisión del Cambio (Bloqueada para el usuario) -->
        <h4 class="text-muted">2. Revisión del Cambio</h4>
        <div class="mb-3">
            <label for="tipo_cambio" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo_cambio" name="tipo_cambio" value="No definido" readonly>
        </div>
        <div class="mb-3">
            <label for="descripcion_revision" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion_revision" name="descripcion_revision" rows="4" readonly>No definido</textarea>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cronologia_prevista" class="form-label">Cronología Prevista</label>
                <input type="text" class="form-control" id="cronologia_prevista" name="cronologia_prevista" value="No definido" readonly>
            </div>
            <div class="col-md-6">
                <label for="costos_estimados" class="form-label">Costos Estimados</label>
                <input type="text" class="form-control" id="costos_estimados" name="costos_estimados" value="No definido" readonly>
            </div>
        </div>

        <!-- Aprobación (Bloqueada para el usuario) -->
        <h4 class="text-muted">Aprobación</h4>
        <div class="mb-3">
            <label for="rol_aprobador" class="form-label">Rol en Aprobación</label>
            <input type="text" class="form-control" id="rol_aprobador" name="rol_aprobador" value="No definido" readonly>
        </div>
        <div class="mb-3">
            <label for="aprobado_por" class="form-label">Aprobado por</label>
            <input type="text" class="form-control" id="aprobado_por" name="aprobado_por" value="No definido" readonly>
        </div>
        <div class="mb-3">
            <label for="fecha_aprobacion" class="form-label">Fecha de Aprobación</label>
            <input type="text" class="form-control" id="fecha_aprobacion" name="fecha_aprobacion" value="No definido" readonly>
        </div>
        <input type="hidden" name="estado" value="Pendiente">

        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
    </form>
</div>

</body>
</html>
