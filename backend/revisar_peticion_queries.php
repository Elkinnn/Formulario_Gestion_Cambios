<?php
include '../config/config.php';

$sql = "
    SELECT s.id, u.nombre AS solicitante, p.nombre AS proyecto, s.numero_cambio, s.fecha_solicitud, s.estado
    FROM solicitudes s
    JOIN usuarios u ON s.id_solicitante = u.id
    JOIN proyectos p ON s.id_proyecto = p.id
";

$result = $conn->query($sql);

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

    echo json_encode(['peticiones' => $peticiones]);

} else {
    echo json_encode(['peticiones' => []]);  
}

$conn->close();
?>
