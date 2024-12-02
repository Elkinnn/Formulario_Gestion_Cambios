<?php
// Establecer conexión con la base de datos
require_once('../config/config.php');

// Obtener los datos del formulario
$id = $_POST['id'];
$numero_cambio = $_POST['numero_cambio'];
$tipo_cambio = $_POST['tipo_cambio'];
$descripcion_cambio = $_POST['descripcion_cambio'];
$fecha_solicitud = $_POST['fecha_solicitud'];
$costos_estimados = $_POST['costos_estimados'];
$estado = $_POST['estado'];
$descripcion_revision = $_POST['descripcion_revision'];
$cronologia_prevista = $_POST['cronologia_prevista'];
$acciones_implementar = $_POST['acciones_implementar'];
$responsable = $_POST['responsable'];
$tiempo_implementacion = $_POST['tiempo_implementacion'];
$rol_aprobador = $_POST['rol_aprobador'];
$aprobado_por = $_POST['aprobado_por'];
$fecha_aprobacion = $_POST['fecha_aprobacion'];



// 1. Actualizar el estado de la solicitud
$query_update_solicitud = "UPDATE solicitudes SET 
                          estado = ? 
                          WHERE id = ?";

if ($stmt = $conn->prepare($query_update_solicitud)) {
    // Enlace de parámetros para actualizar el estado
    $stmt->bind_param('si', $estado, $id); // 's' para string, 'i' para int
    $stmt->execute();
    $stmt->close();
} else {
    echo "Error al preparar la consulta de actualización de solicitud: " . $conn;
    exit();
}

// 2. Obtener el rol del aprobador (revisor)
$query_revisor_role = "SELECT rol FROM usuarios WHERE id = ?";
if ($stmt = $conn->prepare($query_revisor_role)) {
    $stmt->bind_param('i', $aprobado_por); // Obtenemos el rol del aprobador
    $stmt->execute();
    $stmt->bind_result($rol_revisor);
    $stmt->fetch();
    $stmt->close();

    // Validar que el aprobador sea realmente un 'Revisor'
    if ($rol_revisor !== 'Revisor') {
        echo "Error: El usuario que aprueba no tiene el rol de Revisor.";
        exit();
    }
} else {
    echo "Error al consultar el rol del aprobador: " . $conn->error;
    exit();
}

$query_insert_revision = "INSERT INTO revisiones (
    id_solicitud, 
    id_revisor, 
    tipo_cambio, 
    descripcion_revision, 
    cronologia_prevista, 
    costos_estimados, 
    decision, 
    comentario, 
    fecha_revision
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($query_insert_revision)) {
    // El ID del revisor es el aprobado_por (el usuario que aprueba la solicitud)
    $id_revisor = $aprobado_por;
    $comentario = ''; // Puedes agregar un comentario aquí si lo deseas

    // Enlace de parámetros para insertar la revisión
    $stmt->bind_param('issssdsis', $id, $id_revisor, $tipo_cambio, $descripcion_revision, $cronologia_prevista, $costos_estimados, $estado, $comentario, $fecha_aprobacion);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Error al insertar la revisión: " . $conn->error;
    exit();
}


// 4. Insertar en la tabla `seguimientos` con los datos del formulario
$query_insert_seguimiento = "INSERT INTO seguimientos (
                                id_solicitud, 
                                acciones_a_implementar, 
                                responsable, 
                                tiempo_implementacion
                            ) VALUES (?, ?, ?, ?)";

if ($stmt = $conn->prepare($query_insert_seguimiento)) {
    // Enlace de parámetros para insertar el seguimiento
    $stmt->bind_param('isss', $id, $acciones_implementar, $responsable, $tiempo_implementacion);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Error al insertar el seguimiento: " . $conn->error;
    exit();
}

// Redirigir o confirmar el éxito de la operación
echo "La solicitud ha sido actualizada correctamente, incluyendo la revisión, el seguimiento y el estado.";
header('Location: ../revisar_peticion.php');
$conexion->close();
?>