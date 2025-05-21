<?php
session_start();

$conn = new mysqli("localhost", "root", "", "cryptoapp", 3307);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT username, password_hash FROM users WHERE email = ? AND token IS NULL");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($username, $hash);
        $stmt->fetch();

        if (hash("sha256", $password) === $hash) {
            $_SESSION["user"] = $username;
              
            echo "<script>
                alert('✅ Iniciaste con exito');
                window.location.href = '../dashboard.php';
            </script>";
             exit();
            
        } else {
            
            echo "<script>
                alert('❌ Contraseña o usuario incorrecto');
                window.location.href = '../login.html';
            </script>";
             exit();
        }
    } else {
        echo "<script>
                alert('❌ usuario no encontrado o sin verificar');
                window.location.href = '../login.html';
            </script>";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
