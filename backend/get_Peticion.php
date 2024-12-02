<?php
// Conexión a la base de datos (ajusta los parámetros)
require_once($_SERVER['DOCUMENT_ROOT'] . '/Formulario_Gestion_Cambios/config/config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado.']);
    exit;
}

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
    echo json_encode(['error' => 'Solicitud no encontrada.']);
    exit;
}

// Obtener los responsables (Líder y Miembro) del proyecto, excluyendo al cliente
$query_responsables = "
    SELECT u.id, u.nombre, up.rol_en_proyecto
    FROM usuarios u
    JOIN usuarios_proyectos up ON u.id = up.id_usuario
    WHERE up.id_proyecto = ? AND up.rol_en_proyecto IN ('Líder', 'Miembro')
";
$stmt_responsables = $conn->prepare($query_responsables);
$stmt_responsables->bind_param("i", $peticion['id_proyecto']);
$stmt_responsables->execute();
$result_responsables = $stmt_responsables->get_result();
$responsables = [];
while ($row = $result_responsables->fetch_assoc()) {
    $responsables[] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'rol_en_proyecto' => $row['rol_en_proyecto']
    ];
}

// Obtener los aprobadores del proyecto (excluyendo al cliente)
$query_aprobadores = "
    SELECT u.id, u.nombre, up.rol_en_proyecto
    FROM usuarios u
    JOIN usuarios_proyectos up ON u.id = up.id_usuario
    WHERE up.id_proyecto = ? AND up.rol_en_proyecto != 'Cliente'
";
$stmt_aprobadores = $conn->prepare($query_aprobadores);
$stmt_aprobadores->bind_param("i", $peticion['id_proyecto']);
$stmt_aprobadores->execute();
$result_aprobadores = $stmt_aprobadores->get_result();
$aprobadores = [];
while ($row = $result_aprobadores->fetch_assoc()) {
    $aprobadores[] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'rol_en_proyecto' => $row['rol_en_proyecto']
    ];
}

// Cerrar la conexión
$conn->close();

// Crear el arreglo de respuesta con los datos de la petición, aprobadores y responsables
$response = [
    'success' => true,
    'peticion' => $peticion,
    'responsables' => $responsables, // Añadimos los responsables al array de respuesta
    'aprobadores' => $aprobadores // Añadimos los aprobadores al array de respuesta
];

echo json_encode($response);
?>