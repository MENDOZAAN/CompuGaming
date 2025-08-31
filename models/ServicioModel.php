<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class ServicioModel {
    public static function obtenerTodos()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM servicios ORDER BY descripcion ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
