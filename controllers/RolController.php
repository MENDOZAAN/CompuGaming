<?php
require_once("../config/db.php");
require_once("../models/RolModels.php");

$rolModel = new RolModels($pdo);
$roles = $rolModel->obtenerRoles();
?>
