<?php
require_once "../config/db.php";

class Usuario {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function obtenerUsuarios() {
        $query = "SELECT u.id, u.nombre, u.apellido, u.nombre_usuario, u.estado, r.nombre as rol 
                  FROM usuarios u 
                  INNER JOIN roles r ON u.rol_id = r.id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>


