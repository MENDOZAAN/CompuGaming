<?php
require_once __DIR__ . '/../models/ClienteModel.php';
header('Content-Type: application/json');

$datos = [
    'tipo_doc' => $_POST['tipo_doc'],
    'dni_ruc' => $_POST['dni_ruc'],
    'nombres' => $_POST['nombres'],
    'apellidos' => $_POST['apellidos'],
    'razon_social' => $_POST['razon_social'],
    'direccion' => $_POST['direccion'],
    'telefono' => $_POST['telefono'],
    'correo' => $_POST['correo'],
];

$id = ClienteModel::insertar($datos);

if ($id) {
    $nombre = $datos['razon_social'] ?: ($datos['nombres'] . ' ' . $datos['apellidos']);
    echo json_encode(['status' => 'ok', 'id' => $id, 'nombre' => $nombre]);
} else {
    echo json_encode(['status' => 'error']);
}
?>