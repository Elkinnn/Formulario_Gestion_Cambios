<?php
// Conexión a la base de datos
require_once('../config/config.php');

// Obtener los datos del formulario
$id = $_POST['id'];
$descripcion_revision = $_POST['descripcion_revision'];
$estado = $_POST['estado'];
$acciones_implementadas = $_POST['acciones_implementadas'];
$responsable = $_POST['responsable'];

// Nuevos campos que se agregarán a la base de datos
$aprobado_por = $_POST['aprobado_por'];  // Nuevo campo
$rol_aprobador = $_POST['rol_aprobador'];  // Nuevo campo

// Consulta para actualizar la petición
$query = "
    UPDATE peticiones
    SET descripcion_revision = ?, estado = ?, acciones_implementadas = ?, responsable = ?, aprobado_por = ?, rol_aprobador = ?
    WHERE id = ?
";
$stmt = $conn->prepare($query);

// Vincular los parámetros con los valores de la consulta
$stmt->bind_param("ssssssi", $descripcion_revision, $estado, $acciones_implementadas, $responsable, $aprobado_por, $rol_aprobador, $id);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a la página de revisión si la actualización fue exitosa
    header('Location: revisar_peticion_queries.php');
    exit();
} else {
    // Mostrar un mensaje de error si la actualización falla
    echo "Error al actualizar la solicitud: " . $stmt->error;
}
?>