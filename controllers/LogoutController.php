<?php
session_start();

require_once __DIR__ . '/../config/config.php'; // Carga BASE_URL

// Limpiar sesión
$_SESSION = [];
session_destroy();

// Redirigir al login
header('Location: ' . BASE_URL . '/login');
exit;
