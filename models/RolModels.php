<?php
require_once("../config/db.php"); 

class RolModels {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerRoles() {
        $sql = "SELECT id, nombre, fecha_creacion FROM roles";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
