<?php
// Conexión a la base de datos
require_once('../config/config.php');

// Obtener los datos del formulario
$id = $_POST['id'];
$descripcion_revision = $_POST['descripcion_revision'];
$estado = $_POST['estado'];
$acciones_implementadas = $_POST['acciones_implementadas'];
$responsable = $_POST['responsable'];

// Consulta para actualizar la petición
$query = "UPDATE peticiones SET descripcion_revision = ?, estado = ?, acciones_implementadas = ?, responsable = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $descripcion_revision, $estado, $acciones_implementadas, $responsable, $id);

// Ejecutar la consulta
if ($stmt->execute()) {
    header('Location: revisar_peticion_queries.php');
    exit();
} else {
    echo "Error al actualizar la solicitud: " . $stmt->error;
}
?>