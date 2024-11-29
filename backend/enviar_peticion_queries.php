<?php
// Incluir archivo de configuración para conexión a la base de datos
include '../config/config.php'; // Asegúrate de que config.php esté en la ruta correcta

// Verifica si hubo un error de conexión
if (!$conn) {
    echo json_encode(["error" => "No se pudo conectar a la base de datos: " . $conn->connect_error]);
    exit;
}

// Obtener los proyectos para el combo
$sql_proyectos = "SELECT id, nombre FROM proyectos";
$result_proyectos = $conn->query($sql_proyectos);

// Obtener los roles de los usuarios para el combo
$sql_roles = "SELECT DISTINCT rol_en_proyecto FROM usuarios_proyectos";
$result_roles = $conn->query($sql_roles);

$proyectos = [];
$roles = [];

// Llenar los arrays con los proyectos
if ($result_proyectos->num_rows > 0) {
    while ($row = $result_proyectos->fetch_assoc()) {
        $proyectos[] = $row;
    }
}

// Llenar los arrays con los roles
if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Verificar si es una solicitud POST para insertar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos enviados por el formulario
    $fecha_solicitud = $_POST['fecha_solicitud'];
    $numero_cambio = $_POST['numero_cambio'];
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $rol_solicitante = $_POST['rol_solicitante'];
    $nombre_solicitante = $_POST['nombre_solicitante'];
    $contacto = $_POST['contacto'];
    $descripcion_cambio = $_POST['descripcion_cambio'];
    $prioridad = $_POST['prioridad'];
    $razon = $_POST['razon'];
    $estado = 'Pendiente'; // Estado siempre será 'Pendiente'

    // Verificar que el proyecto y el solicitante existen
    $sql_proyecto = "SELECT id FROM proyectos WHERE nombre = '$nombre_proyecto'";
    $result_proyecto = $conn->query($sql_proyecto);

    $sql_usuario = "SELECT id FROM usuarios WHERE nombre = '$nombre_solicitante'";
    $result_usuario = $conn->query($sql_usuario);

    if ($result_proyecto->num_rows > 0 && $result_usuario->num_rows > 0) {
        // Obtener IDs de proyecto y usuario
        $id_proyecto = $result_proyecto->fetch_assoc()['id'];
        $id_solicitante = $result_usuario->fetch_assoc()['id'];

        // Insertar solicitud
        $sql = "INSERT INTO solicitudes (
                    fecha_solicitud, 
                    numero_cambio, 
                    id_proyecto, 
                    id_solicitante, 
                    contacto_solicitante, 
                    descripcion_cambio, 
                    prioridad, 
                    razon_cambio, 
                    estado
                ) VALUES (
                    '$fecha_solicitud', 
                    '$numero_cambio', 
                    '$id_proyecto', 
                    '$id_solicitante', 
                    '$contacto', 
                    '$descripcion_cambio', 
                    '$prioridad', 
                    '$razon', 
                    '$estado'
                )";

        if ($conn->query($sql) === TRUE) {
            // Envío de respuesta de éxito
            echo json_encode(["success" => "Solicitud enviada correctamente."]);
        } else {
            // Envío de error en caso de fallo en la consulta
            echo json_encode(["error" => "Error al enviar la solicitud: " . $conn->error]);
        }
    } else {
        // Envío de error si no se encuentran proyecto o usuario
        echo json_encode(["error" => "El proyecto o el solicitante no existen."]);
    }

    // Cerrar conexión
    $conn->close();
} else {
    // Respuesta en caso de que no se use el método POST
    echo json_encode(["error" => "Método de solicitud no autorizado."]);
    exit;
}
?>
