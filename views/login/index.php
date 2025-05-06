
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/CompuGaming/config/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - CompuGaming</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #000;
      font-family: 'Courier New', monospace;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      transition: background-color 0.4s ease;
    }

    .light-mode {
      background-color: #f5f5f5;
      color: #000;
    }

    .login-container {
      background-color: #333;
      padding: 60px 50px;
      border-radius: 25px;
      text-align: center;
      width: 100%;
      max-width: 520px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      position: relative;
      transition: background-color 0.4s ease, color 0.4s ease;
    }

    .light-mode .login-container {
      background-color: #fff;
      color: #000;
    }

    .login-container img {
      width: 200px;
      margin-bottom: 35px;
    }

    h2 {
      font-size: 32px;
      margin-bottom: 40px;
    }

    label {
      display: block;
      text-align: left;
      margin-bottom: 10px;
      font-size: 20px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 16px;
      font-size: 18px;
      border: none;
      border-radius: 12px;
      margin-bottom: 30px;
    }

    button[type="submit"] {
      background-color: red;
      color: white;
      border: none;
      padding: 18px 0;
      font-size: 20px;
      width: 100%;
      border-radius: 30px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: darkred;
    }

    .theme-toggle {
      position: absolute;
      top: 15px;
      right: 20px;
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: white;
      transition: color 0.4s ease;
    }

    .light-mode .theme-toggle {
      color: #000;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 35px 25px;
      }

      h2 {
        font-size: 24px;
      }

      input, button {
        font-size: 16px;
      }

      .theme-toggle {
        font-size: 20px;
        top: 10px;
        right: 15px;
      }
    }
    input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 16px;
    font-size: 18px;
    border: none;
    border-radius: 12px;
    margin-bottom: 30px;
    background-color: #1e1e1e;
    color: white;
  }

  /* Estilos en modo claro */
  .light-mode input[type="text"],
  .light-mode input[type="password"] {
    background-color: #e0e0e0;
    color: #000;
  }

  .light-mode input::placeholder {
    color: #444;
  }
    
  </style>
</head>
<body>
  <div class="login-container">
    <button class="theme-toggle" onclick="toggleTheme()">⏾ / 𖤓</button>
    <img id="logo" src="<?= BASE_URL ?>/assets/img/logo-blanco.png" alt="Logo CompuGaming">
    <h2>INICIAR SESIÓN</h2>
    <form method="post" action="<?= BASE_URL ?>/login/autenticar">
      <label for="username">USUARIO:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">CONTRASEÑA:</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">INGRESAR</button>
    </form>
  </div>

  <script>
    function toggleTheme() {
      const body = document.body;
      const logo = document.getElementById('logo');
      const isLight = body.classList.toggle('light-mode');
      localStorage.setItem('theme', isLight ? 'light' : 'dark');
      logo.src = isLight
        ? "<?= BASE_URL ?>/assets/img/logo-negro.png"
        : "<?= BASE_URL ?>/assets/img/logo-blanco.png";
    }

    window.onload = function() {
      const savedTheme = localStorage.getItem('theme');
      const logo = document.getElementById('logo');
      if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        logo.src = "<?= BASE_URL ?>/assets/img/logo-negro.png";
      } else {
        logo.src = "<?= BASE_URL ?>/assets/img/logo-blanco.png";
      }
    }
  </script>
</body>
</html>
