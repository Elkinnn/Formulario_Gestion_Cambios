<?php
// Incluir archivo de configuración para conexión a la base de datos
include '../config/config.php'; // Asegúrate de que config.php esté en la ruta correcta

// Recuperar proyectos desde la base de datos
$sql_proyectos = "SELECT nombre FROM proyectos";
$result_proyectos = $conn->query($sql_proyectos);

// Crear un array para los proyectos
$projects = [];
if ($result_proyectos->num_rows > 0) {
    while ($row = $result_proyectos->fetch_assoc()) {
        $projects[] = $row; // Guardamos el nombre del proyecto
    }
}

// Retornar los proyectos en formato JSON
echo json_encode($projects);

$conn->close();
?>
