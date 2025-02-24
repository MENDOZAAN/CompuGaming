<?php
session_start();
$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CompuGaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-4 shadow-lg" style="width: 350px;">
    <h3 class="text-center">Iniciar Sesión</h3>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="/compugaming/auth/login" method="POST">
    <div class="mb-3">
            <label for="nombre_usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
