<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.html"); // o tu página de login
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CryptoApp - Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .dashboard-container h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .dashboard-container a {
            display: block;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 10px 0;
            width: 90%;
            text-align: center;
            border-radius: 6px;
            font-weight: bold;
        }

        .dashboard-container a:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="logo">
            <img src="img/logo.png" alt="Logo de CryptoApp">
        </div>
        <div class="text-content">
            <h1>CryptoApp</h1>
            <p>Protegiendo tu identidad digital</p>
        </div>
    </div>

    <div class="dashboard-container">
        <h2 style="text-align: center;">👋 Hola, <?php echo $_SESSION["user"]; ?></h2>

        <h2>Datos curiosos sobre criptografía</h2>
        <a href="clasica.html">La Máquina Enigma: El Rompecabezas de la Segunda Guerra Mundial</a>
        <a href="moderna.html">WhatsApp y el Cifrado de Extremo a Extremo</a>
        <a href="tendencias.html">Al-Kindi y el Origen del Criptoanálisis</a>
    </div>
</body>
</html>
