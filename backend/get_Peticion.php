<?php
// Conexión a la base de datos (ajusta los parámetros)
require_once('./config/config.php');

// Obtener el ID de la solicitud desde la URL
$id = $_GET['id'];

// Consulta para obtener los detalles de la solicitud, incluyendo el rol del solicitante
$query = "
    SELECT s.*, p.nombre AS nombre_proyecto, u.nombre AS nombre_solicitante, u.telefono AS contacto_solicitante,
           up.rol_en_proyecto AS rol_solicitante
    FROM solicitudes s
    JOIN proyectos p ON s.id_proyecto = p.id
    JOIN usuarios u ON s.id_solicitante = u.id
    JOIN usuarios_proyectos up ON u.id = up.id_usuario AND s.id_proyecto = up.id_proyecto
    WHERE s.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$peticion = $result->fetch_assoc();

// Asegurarse de que la consulta fue exitosa
if (!$peticion) {
    die('Solicitud no encontrada.');
}
?>