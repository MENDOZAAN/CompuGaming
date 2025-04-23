<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: http://localhost/CompuGaming/login');
    exit;
}
?>

<h2>Bienvenido al Panel de Administración, <?= $_SESSION['usuario']['nombre'] ?></h2>
