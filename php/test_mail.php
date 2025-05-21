<?php
require_once 'libs/PHPMailer/send_email.php';

$destino = 'veritovero1508@gmail.com'; // prueba contigo misma
$nombre = 'Verito';
$asunto = 'Correo de prueba';
$mensaje = '<p>Este es un mensaje de prueba.</p>';

enviarCorreo($destino, $nombre, $asunto, $mensaje);
?>
