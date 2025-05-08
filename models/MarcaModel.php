<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class MarcaModel
{
    public static function obtenerTodas()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT id, nombre FROM marcas ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
