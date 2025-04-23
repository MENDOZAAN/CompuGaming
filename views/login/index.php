<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/CompuGaming/config/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
      <div class="text-center mb-3">
        <img src="<?= LOGO_ROJO ?>" alt="Logo" style="height: 60px;">
        <h3 class="mt-2">Iniciar sesión</h3>
      </div>
      <form method="post" action="<?= BASE_URL ?>/login/autenticar">
        <div class="mb-3">
          <label for="username" class="form-label">Usuario</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Ingresar</button>
      </form>
    </div>
  </div>
</body>
</html>
