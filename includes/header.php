<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: " . URL_WEB . "views/login");
    exit;
}
