<?php
// Incluir archivo de configuración para conexión a la base de datos
include '../config/config.php';

// Consulta para obtener las solicitudes de cambio
$sql = "
    SELECT s.id, u.nombre AS solicitante, p.nombre AS proyecto, s.numero_cambio, s.fecha_solicitud, s.estado
    FROM solicitudes s
    JOIN usuarios u ON s.id_solicitante = u.id
    JOIN proyectos p ON s.id_proyecto = p.id
";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    $peticiones = [];
    while ($row = $result->fetch_assoc()) {
        $peticiones[] = [
            'id' => $row['id'],
            'solicitante' => $row['solicitante'],
            'proyecto' => $row['proyecto'],
            'numero_cambio' => $row['numero_cambio'],
            'fecha_solicitud' => $row['fecha_solicitud'],
            'estado' => $row['estado']
        ];
    }

    // Retornar los datos en formato JSON
    echo json_encode(['peticiones' => $peticiones]);

} else {
    echo json_encode(['peticiones' => []]);  // Si no hay resultados, retornar un array vacío
}

$conn->close();
?>
