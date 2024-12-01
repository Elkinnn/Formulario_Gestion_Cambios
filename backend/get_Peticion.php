<?php
// Conexión a la base de datos (ajusta los parámetros)
require_once('./config/config.php');

// Obtener el ID de la solicitud desde la URL
$id = $_GET['id'];

// Consultar la solicitud en la base de datos
// Consultar la solicitud en la base de datos
$query = "SELECT * FROM solicitudes WHERE id = ?";
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
