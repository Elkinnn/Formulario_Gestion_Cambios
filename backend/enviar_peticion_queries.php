<?php
// Incluir archivo de configuración para conexión a la base de datos
include '../config/config.php';

// Verificar si se recibió una solicitud GET para obtener el contacto del solicitante
if (isset($_POST['solicitante_id'])) {
    $solicitante_id = $_POST['solicitante_id'];

    // Obtener los datos del solicitante usando el ID
    $sql = "
        SELECT u.nombre, u.telefono, up.rol_en_proyecto, p.nombre AS proyecto
        FROM usuarios u
        JOIN usuarios_proyectos up ON u.id = up.id_usuario
        JOIN proyectos p ON up.id_proyecto = p.id
        WHERE u.id = ?
    ";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $solicitante_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el solicitante
    if ($result->num_rows > 0) {
        $solicitante = $result->fetch_assoc();
        
        // Enviar los datos del solicitante en formato JSON
        echo json_encode([
            'nombre_solicitante' => $solicitante['nombre'],
            'telefono_solicitante' => $solicitante['telefono'],
            'rol_en_proyecto' => $solicitante['rol_en_proyecto'],
            'proyecto' => $solicitante['proyecto']
        ]);
    } else {
        echo json_encode(['error' => 'Solicitante no encontrado']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

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

    // Verificar si el nombre del proyecto fue recibido correctamente
    if (!$nombre_proyecto) {
        die("Error: No se ha recibido el nombre del proyecto.");
    }

    // Obtener el ID del proyecto
    $sql_proyecto = "SELECT id FROM proyectos WHERE nombre = ?";
    $stmt = $conn->prepare($sql_proyecto);
    $stmt->bind_param('s', $nombre_proyecto);
    $stmt->execute();
    $result = $stmt->get_result();
    $proyecto = $result->fetch_assoc();
    
    // Verificar si el proyecto fue encontrado
    if (!$proyecto) {
        die("Error: Proyecto no encontrado.");
    }

    $id_proyecto = $proyecto['id'];

    // Verificar si el nombre del solicitante fue recibido correctamente
    if (!$nombre_solicitante) {
        die("Error: No se ha recibido el nombre del solicitante.");
    }

    // Obtener el ID del solicitante basado en el rol y el proyecto
    $sql_usuario = "
        SELECT u.id, u.telefono 
        FROM usuarios u
        JOIN usuarios_proyectos up ON u.id = up.id_usuario
        WHERE up.rol_en_proyecto = ? AND up.id_proyecto = ? AND u.rol = 'Solicitante'
    ";
    $stmt = $conn->prepare($sql_usuario);
    $stmt->bind_param('si', $rol_solicitante, $id_proyecto);  // Usamos el rol y el id del proyecto
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $id_solicitante = $usuario['id'];  // Obtener el ID del solicitante
        $contacto = $usuario['telefono'];  // Obtener el teléfono del solicitante
    } else {
        die("Error: Solicitante no encontrado.");
    }

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
        echo "Solicitud enviada exitosamente.";
    } else {
        echo "Error al enviar la solicitud: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
}

// Consulta para obtener los proyectos con sus roles y los usuarios con sus roles en los proyectos
$sql = "
    SELECT p.nombre AS proyecto, up.rol_en_proyecto, u.id AS usuario_id, u.nombre AS usuario_nombre, u.telefono
    FROM proyectos p
    LEFT JOIN usuarios_proyectos up ON p.id = up.id_proyecto
    LEFT JOIN usuarios u ON up.id_usuario = u.id
    WHERE u.rol = 'Solicitante'
";

// Ejecutar la consulta
$result = $conn->query($sql);

// Crear arrays para los proyectos y roles, y los usuarios y roles
$proyectos = [];
$solicitantes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Guardar los proyectos y roles
        $proyectos[$row['proyecto']][] = $row['rol_en_proyecto'];

        // Guardar los solicitantes con roles y el proyecto asociado
        $solicitantes[] = [
            'id' => $row['usuario_id'],
            'nombre' => $row['usuario_nombre'],
            'rol_en_proyecto' => $row['rol_en_proyecto'],
            'telefono' => $row['telefono'],  // Agregar el teléfono
            'proyecto' => $row['proyecto'] // Añadir la propiedad 'proyecto'
        ];
    }
}

// Retornar los datos combinados en formato JSON
$response = [
    'proyectos' => $proyectos,
    'solicitantes' => $solicitantes
];

echo json_encode($response);

$conn->close();
?>
