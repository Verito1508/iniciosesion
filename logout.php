<?php
session_start();
session_unset();  // Limpia variables de sesión
session_destroy();  // Destruye la sesión

// Redirigir al login
header("Location: login.html");
exit();
?>

