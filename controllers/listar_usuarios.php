<?php
require_once "../models/UsuarioModels.php";

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function listarUsuarios() {
        return $this->usuarioModel->obtenerUsuarios();
    }
}

// Instancia del controlador
$usuarioController = new UsuarioController();
$usuarios = $usuarioController->listarUsuarios();
?>

