<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cambios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Gestión de Cambios</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="index.html">Enviar Petición</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="review.html">Revisar Peticiones</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero d-flex flex-column align-items-center text-center text-white">
        <h1 class="display-3 fw-bold mb-4">Gestión de Cambios</h1>
        <p class="lead px-3 mx-auto" style="max-width: 700px;">
            Una herramienta colaborativa para registrar, revisar y dar seguimiento a solicitudes de cambio en proyectos. Diseñada para optimizar y organizar procesos con facilidad.
        </p>
        <a href="#info" class="btn btn-primary btn-lg mt-4 shadow">Más Información</a>
    </div>

    <!-- Info Section -->
    <div id="info" class="container my-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="info-card p-4 rounded shadow bg-light">
                    <h3 class="fw-bold text-primary">¿Qué es?</h3>
                    <p class="text-muted">
                        Una plataforma que permite a los equipos de trabajo gestionar los cambios en proyectos de forma eficiente. Desde el registro de solicitudes hasta su aprobación.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card p-4 rounded shadow bg-light">
                    <h3 class="fw-bold text-primary">¿Cómo Funciona?</h3>
                    <p class="text-muted">
                        Los usuarios pueden registrar solicitudes, los revisores pueden aprobar o rechazar con observaciones, y todos los cambios quedan documentados para referencia futura.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="team-section bg-dark text-white py-5">
        <div class="container text-center">
            <h3 class="mb-4 text-uppercase fw-bold">Equipo de Trabajo</h3>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <div class="team-card p-3 rounded shadow bg-light text-dark">
                    <p class="mb-0 fw-bold">Angel Ayuquina</p>
                </div>
                <div class="team-card p-3 rounded shadow bg-light text-dark">
                    <p class="mb-0 fw-bold">Leonel Barros</p>
                </div>
                <div class="team-card p-3 rounded shadow bg-light text-dark">
                    <p class="mb-0 fw-bold">Diego Jijón</p>
                </div>
                <div class="team-card p-3 rounded shadow bg-light text-dark">
                    <p class="mb-0 fw-bold">Elkin López</p>
                </div>
                <div class="team-card p-3 rounded shadow bg-light text-dark">
                    <p class="mb-0 fw-bold">Sebastian Ortiz</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-dark text-white">
        <p>&copy; 2024 Gestión de Cambios. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
