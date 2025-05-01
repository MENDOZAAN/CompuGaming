<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/CompuGaming/config/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - CompuGaming</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg,rgb(174, 182, 185),rgb(25, 27, 28),rgb(255, 2, 2));
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .login-card {
      background-color: #ffffff;
      color: #333;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 420px;
    }

    .login-card .logo {
      height: 60px;
      margin-bottom: 20px;
    }

    .login-card h3 {
      font-weight: 600;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-login {
      background-color: #e63946;
      color: white;
      border-radius: 10px;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: #d62828;
    }

    .form-label i {
      margin-right: 8px;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="text-center">
      <img src="../assets/img/Logo grande blanco.png" alt="Logo" class="logo">
      <h3>Bienvenido a CompuGaming</h3>
    </div>
    <form method="post" action="<?= BASE_URL ?>/login/autenticar">
      <div class="mb-3">
        <label for="username" class="form-label"><i class="fas fa-user"></i>Usuario</label>
        <input type="text" name="username" class="form-control" placeholder="Ingresa tu usuario" required>
      </div>
      <div class="mb-4">
        <label for="password" class="form-label"><i class="fas fa-lock"></i>Contraseña</label>
        <input type="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
      </div>
      <button type="submit" class="btn btn-login w-100">Iniciar sesión</button>
    </form>
  </div>
</body>
</html>
