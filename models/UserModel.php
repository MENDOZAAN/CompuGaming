<?php
require_once 'config/database.php';

class UserModel {
    public static function getByUsername($username) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ? LIMIT 1");
        $stmt->execute([$username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
