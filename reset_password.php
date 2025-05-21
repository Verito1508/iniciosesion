<?php
$conn = new mysqli("localhost", "root", "", "cryptoapp", 3307);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

$token = $_POST["token"];
$new = $_POST["new_password"];
$confirm = $_POST["confirm_password"];

// Validar coincidencia
if ($new !== $confirm) {
    echo "<script>alert('❌ Las contraseñas no coinciden.'); window.history.back();</script>";
    exit;
}

// Validar reglas
if (
    strlen($new) < 8 ||
    !preg_match('/[A-Z]/', $new) ||
    !preg_match('/[a-z]/', $new) ||
    !preg_match('/[0-9]/', $new) ||
    !preg_match('/[\W_]/', $new) ||
    preg_match('/\d{2,}/', $new)
) {
    echo "<script>alert('❌ La contraseña no cumple con los requisitos.'); window.history.back();</script>";
    exit;
}

$hash = hash("sha256", $new);

$stmt = $conn->prepare("UPDATE users SET password_hash = ?, token = NULL WHERE token = ?");
$stmt->bind_param("ss", $hash, $token);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>
            alert('✅ Contraseña restablecida correctamente.');
            window.location.href = 'login.html';
          </script>";
} else {
    echo "<script>
            alert('❌ Token inválido o expirado.');
            window.location.href = 'forgot_password.html';
          </script>";
}

$stmt->close();
$conn->close();
?>
