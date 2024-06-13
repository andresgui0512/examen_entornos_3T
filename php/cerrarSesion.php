<?php
    // Inicia la sesión
    session_start();
    // Elimina todas las variables de sesión
    session_unset();
    // Elimina la sesión
    session_destroy();
    // Redirige al usuario a la página de inicio
    header("Location: ../index.php");
    // Detiene la ejecución del script
    exit;
?>
