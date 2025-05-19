<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

$codigo = $_POST['codigo'] ?? '';

if (empty($codigo)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Ingrese un DNI o correlativo']);
    exit;
}

// Obtener internamiento con cliente y técnico
$sql = "SELECT i.*, 
               CASE 
                 WHEN c.tipo_doc = 'DNI' THEN CONCAT(c.nombres, ' ', c.apellidos)
                 ELSE c.razon_social
               END AS cliente,
               u.nombre AS tecnico_nombre,
               u.apellido AS tecnico_apellido
        FROM internamientos i
        JOIN clientes c ON i.cliente_id = c.id
        LEFT JOIN usuarios u ON i.tecnico_id = u.id
        WHERE c.dni_ruc = ? OR i.correlativo = ?
        ORDER BY i.id DESC
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([$codigo, $codigo]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $internamiento_id = $row['id'];

    // Obtener equipos asociados
    $equipos = [];
    $stmtEquipos = $pdo->prepare("SELECT tipo_equipo, marca, modelo, nro_serie, falla_reportada, servicio_solicitado
                                   FROM equipos_internamiento
                                   WHERE internamiento_id = ?");
    $stmtEquipos->execute([$internamiento_id]);
    $equipos = $stmtEquipos->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'ok',
        'cliente' => $row['cliente'],
        'correlativo' => $row['correlativo'],
        'estado' => $row['estado_general'],
        'fecha' => date('d/m/Y H:i', strtotime($row['fecha_ingreso'])),
        'observaciones' => $row['observaciones'],
        'tecnico' => $row['tecnico_nombre'] ? $row['tecnico_nombre'] . ' ' . $row['tecnico_apellido'] : 'No asignado',
        'equipos' => $equipos
    ]);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'No se encontró ningún registro con ese código.']);
}
