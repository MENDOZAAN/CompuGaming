<?php
require_once __DIR__ . '/../../config/config.php'; // se carga UNA vez
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

include __DIR__ . '/../../includes/header.php';
?>