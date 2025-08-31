<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
class TipoEquipoModel {
    public static function obtenerTodos() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM tipos_equipo ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
