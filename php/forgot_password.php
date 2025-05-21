<?php
$conn = new mysqli("localhost", "root", "", "cryptoapp", 3307);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username);
if ($stmt->num_rows === 0) die("❌ No existe ninguna cuenta asociada a ese correo.");
$stmt->close();

$stmt = $conn->prepare("UPDATE users SET token = ? WHERE email = ?");
$stmt->bind_param("ss", $token, $email);
$stmt->execute();
$stmt->close();

$link = "http://localhost/INICIOSESION/reset_password_form.php?token=$token";

$logo_url = "https://i.ibb.co/JFCvYv1y/logo-compressed.jpg";

$mensajeHTML = "
<div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; background-color: #f9f9f9; padding: 20px; border-radius: 8px;'>
    <div style='text-align: center;'>
        <img src='$logo_url' alt='Logo de CryptoApp' style='width: 120px; margin-bottom: 10px;'>
        <h2 style='margin: 5px 0; color: #333;'>CryptoApp</h2>
        <p style='color: #777;'>Protegiendo tu identidad digital</p>
    </div>
    <hr style='margin: 20px 0;'>
    <p style='font-size: 16px; color: #333;'>Hola <strong>$username</strong>,</p>
    <p style='font-size: 15px;'>Haz clic en el botón para restablecer tu contraseña:</p>
    <div style='margin: 20px 0; text-align: center;'>
        <a href='$link' style='padding: 12px 25px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Restablecer contraseña</a>
    </div>
    <p style='font-size: 13px; color: #555;'>Si no solicitaste esta acción, puedes ignorar este correo.</p>
</div>";



require_once 'libs/PHPMailer/send_email.php';
if (enviarCorreo($email, 'Usuario', 'Restablece tu contraseña', $mensajeHTML)) {
    echo "<script>
    alert('✅ Revisa tu correo para recuperar tu contraseña.');
    window.location.href = '../forgot_password.html';
</script>";
exit();

} else {
    "<script>
    alert('❌ El correo no está registrado.');
    window.location.href = '../forgot_password.html';
</script>";
exit();
}
?>
