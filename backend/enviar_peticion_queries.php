<?php
// Incluir archivo de configuración para conexión a la base de datos
include '../config/config.php'; // Asegúrate de que config.php esté en la ruta correcta

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtener los valores del formulario
    $fecha_solicitud = $_POST['fecha_solicitud'];
    $numero_cambio = $_POST['numero_cambio'];
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $rol_solicitante = $_POST['rol_solicitante'];
    $nombre_solicitante = $_POST['nombre_solicitante'];
    $contacto = $_POST['contacto'];
    $descripcion_cambio = $_POST['descripcion_cambio'];
    $prioridad = $_POST['prioridad'];
    $razon = $_POST['razon'];
    $estado = $_POST['estado'];

    // Obtener el ID del proyecto
    $sql_proyecto = "SELECT id FROM proyectos WHERE nombre = ?";
    $stmt = $conn->prepare($sql_proyecto);
    $stmt->bind_param('s', $nombre_proyecto);
    $stmt->execute();
    $result = $stmt->get_result();
    $proyecto = $result->fetch_assoc();
    $id_proyecto = $proyecto['id'];

    // Obtener el ID del solicitante (por ejemplo, usando el nombre del solicitante)
    $sql_usuario = "SELECT id FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($sql_usuario);
    $stmt->bind_param('s', $nombre_solicitante);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    $id_solicitante = $usuario['id'];

    // Preparar la consulta para insertar la solicitud en la tabla solicitudes
    $sql_insert_solicitud = "
        INSERT INTO solicitudes (fecha_solicitud, numero_cambio, id_proyecto, id_solicitante, 
                                contacto_solicitante, descripcion_cambio, prioridad, razon_cambio, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    // Preparar la sentencia y vincular los parámetros
    $stmt = $conn->prepare($sql_insert_solicitud);
    $stmt->bind_param('ssiiissss', $fecha_solicitud, $numero_cambio, $id_proyecto, $id_solicitante,
                     $contacto, $descripcion_cambio, $prioridad, $razon, $estado);

    // Ejecutar la inserción
    if ($stmt->execute()) {
        echo "Solicitud enviada exitosamente.<br>";
    } else {
        echo "Error al enviar la solicitud: " . $stmt->error . "<br>";
    }

    // Cerrar la conexión de la solicitud
    $stmt->close();
}

// Obtener los solicitantes
$sql_solicitantes = "SELECT id, nombre FROM usuarios"; // Asumimos que 'id' es el identificador del usuario
$result_solicitantes = $conn->query($sql_solicitantes);

// Crear un array para los nombres de los solicitantes
$solicitantes = [];
if ($result_solicitantes->num_rows > 0) {
    while ($row = $result_solicitantes->fetch_assoc()) {
        $solicitantes[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre']
        ];
    }
}

// Recuperar proyectos con sus roles desde la base de datos
$sql_proyectos_roles = "
    SELECT p.nombre AS proyecto, up.rol_en_proyecto 
    FROM proyectos p
    LEFT JOIN usuarios_proyectos up ON p.id = up.id_proyecto
";

// Ejecutar la consulta
$result_proyectos_roles = $conn->query($sql_proyectos_roles);

// Crear un array para los proyectos y roles
$data = [];

if ($result_proyectos_roles->num_rows > 0) {
    while ($row = $result_proyectos_roles->fetch_assoc()) {
        $data[$row['proyecto']][] = $row['rol_en_proyecto']; // Asociamos los roles con cada proyecto
    }
}

// Crear un array con los datos que necesitas retornar
$response = [
    'solicitantes' => $solicitantes,
    'proyectos_roles' => $data
];

// Retornar los datos en formato JSON
echo json_encode($response);

// Cerrar la conexión
$conn->close();
?>
