<?php
$conn = new mysqli("localhost", "root", "", "cryptoapp", 3307);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$token = $_GET["token"] ?? '';

if (empty($token)) {
    header("Location: ../login.html?verify=invalid");
    exit();
}

$stmt = $conn->prepare("UPDATE users SET token = NULL WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Token válido, redirige con mensaje de éxito
    header("Location: ../login.html?verify=success");
} else {
    // Token no encontrado o ya usado
    header("Location: ../login.html?verify=invalid");
}

$stmt->close();
$conn->close();
exit();
?>
