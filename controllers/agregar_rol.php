<?php
require_once("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);

    // Convertir a formato: Primera letra mayúscula, resto minúscula
    $nombre_formateado = ucwords(strtolower($nombre));

    try {
        $sql = "INSERT INTO roles (nombre) VALUES (:nombre)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre_formateado, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al guardar el rol."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
