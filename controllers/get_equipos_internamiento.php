<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_GET['id'])) {
  echo json_encode([]);
  exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT tipo_equipo, marca, modelo, nro_serie, falla_reportada, servicio_solicitado 
                       FROM equipos_internamiento 
                       WHERE internamiento_id = ?");
$stmt->execute([$id]);
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($equipos);
