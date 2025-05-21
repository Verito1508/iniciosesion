<?php
$conn = new mysqli("localhost", "root", "", "cryptoapp", 3307); // <-- usa puerto 3307

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$username = $_POST["username"];
$email = $_POST["email"];
$password_plain = $_POST["password"];
var_dump($_POST);  // Agrega esto para verificar si llega el campo

$confirm_password = $_POST["confirm_password"];

// Validar que coincidan
if ($password_plain !== $confirm_password) {
    die("❌ Las contraseñas no coinciden.");
}

// ✅ Validar requisitos de seguridad
if (
    strlen($password_plain) < 8 ||
    !preg_match('/[A-Z]/', $password_plain) ||        // al menos una mayúscula
    !preg_match('/[a-z]/', $password_plain) ||        // al menos una minúscula
    !preg_match('/[0-9]/', $password_plain) ||        // al menos un número
    !preg_match('/[\W_]/', $password_plain) ||        // al menos un símbolo (no letra/numero)
    preg_match('/\d{2,}/', $password_plain)           // ❌ dos o más números consecutivos
) {
    die("❌ La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número, un símbolo y no debe tener números consecutivos.");
}

$token = bin2hex(random_bytes(16));
echo "Token generado: $token<br>"; // <-- Verifica que se muestre

$password_hash = hash("sha256", $password_plain);

// Guardar en la base de datos
$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, token) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password_hash, $token);
$stmt->execute();
$stmt->close();

$verification_link = "http://localhost/INICIOSESION/php/verify_email.php?token=$token";
$logo_url = "https://i.ibb.co/JFCvYv1y/logo-compressed.jpg";

$mensajeHTML = "
<div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; background: #fff; border: 1px solid #ddd; padding: 20px; border-radius: 8px;'>
    <div style='text-align: center;'>
        <img src='$logo_url' alt='Logo de CryptoApp' style='width: 80px; margin-bottom: 10px;'>
        <h2 style='margin: 5px 0; color: #333;'>CryptoApp</h2>
        <p style='color: #777;'>Protegiendo tu identidad digital</p>
    </div>
    <hr style='margin: 20px 0;'>
    <p style='font-size: 16px; color: #333;'>Hola <strong>$username</strong>,</p>
    <p style='font-size: 15px;'>Gracias por registrarte. Haz clic en el botón de abajo para verificar tu cuenta:</p>
    <div style='text-align: center; margin: 20px 0;'>
        <a href='$verification_link' style='padding: 12px 25px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>Verificar cuenta</a>
    </div>
    <p style='font-size: 13px; color: #888;'>Si no solicitaste este registro, puedes ignorar este correo.</p>
</div>
";


require_once 'libs/PHPMailer/send_email.php';




if (enviarCorreo($email, $username, "Verifica tu cuenta en CryptoApp", $mensajeHTML)) {
    echo "
    <script>
        alert('✅ Te registraste con éxito. Valida tu cuenta con el correo electrónico que se envió.');
        window.location.href = '../login.html';
    </script>
    ";
} else {
    echo "
    <script>
        alert('❌ Error al enviar el correo. Verifica tus credenciales SMTP.');
        window.location.href = '../register.html';
    </script>
    ";
}



echo "Registro exitoso. Revisa tu correo para verificar tu cuenta.";
?>


