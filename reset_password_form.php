<?php
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restablecer Contraseña - CryptoApp</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .reset-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    input, button {
      width: 90%;
    }

    .note {
      font-size: 13px;
      text-align: left;
      color: #666;
      margin-top: 5px;
      width: 90%;
    }

    .note ul {
      margin-top: 0;
      padding-left: 18px;
    }

    .header-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      margin-bottom: 20px;
    }

    .logo img {
      width: 100px;
    }

    .text-content {
      text-align: left;
    }

    .text-content h1 {
      margin: 0;
      font-size: 26px;
      font-weight: bold;
    }

    .text-content p {
      margin: 0;
      color: #777;
    }
  </style>
</head>
<body>

  <!-- ENCABEZADO -->
  <div class="header-container">
    <div class="logo">
      <img src="img/logo.png" alt="Logo de CryptoApp" />
    </div>
    <div class="text-content">
      <h1>CryptoApp</h1>
      <p>Protegiendo tu identidad digital</p>
    </div>
  </div>

  <!-- FORMULARIO -->
  <form
    id="resetForm"
    class="reset-container"
    action="reset_password.php"
    method="POST"
    onsubmit="return validarFormulario()"
  >
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />
    
    <input
      type="password"
      name="new_password"
      id="password"
      placeholder="Nueva contraseña"
      required
    />
    <input
      type="password"
      name="confirm_password"
      id="confirm_password"
      placeholder="Confirmar contraseña"
      required
    />
    <div id="error" class="error"></div>

    <div class="note">
      La contraseña debe tener:
      <ul>
        <li>Al menos 8 caracteres</li>
        <li>Una mayúscula y una minúscula</li>
        <li>Un número y un símbolo</li>
        <li>No debe tener números consecutivos</li>
      </ul>
    </div>

    <button type="submit">Actualizar contraseña</button>
  </form>

  <script>
    function validarFormulario() {
      const pass = document.getElementById("password").value;
      const confirm = document.getElementById("confirm_password").value;
      const error = document.getElementById("error");

      if (pass !== confirm) {
        error.textContent = "❌ Las contraseñas no coinciden.";
        return false;
      }

      if (
        pass.length < 8 ||
        !/[A-Z]/.test(pass) ||
        !/[a-z]/.test(pass) ||
        !/[0-9]/.test(pass) ||
        !/[\W_]/.test(pass) ||
        /\d{2,}/.test(pass)
      ) {
        error.textContent = "❌ La contraseña no cumple con los requisitos.";
        return false;
      }

      error.textContent = "";
      return true;
    }
  </script>

</body>
</html>
