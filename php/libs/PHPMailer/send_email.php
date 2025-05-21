<?php

require __DIR__. '/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($email, $nombre, $asunto, $mensaje) {
    $mail = new PHPMailer(true);
    $mail->addAddress($email, $nombre);

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 0; // Nivel de depuración
        $mail->Debugoutput = 'html'; // Salida de depuración en formato HTML
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'veritovero1508@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'nwnhpcesmifzcnkp'; // Clave de aplicación generada en Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8';

        // Remitente y destinatario
        $mail->setFrom('veritovero1508a@gmail.com', 'Soporte');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
  

        // Enviar el correo
        $mail->send();
        return ['success' => true, 'message' => 'Correo enviado correctamente.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $mail->ErrorInfo];
    }
}


?>
