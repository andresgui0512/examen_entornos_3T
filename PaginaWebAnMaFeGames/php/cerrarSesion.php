<?php
// Inicia la sesión

$_SESSION = array();// Destruye la sesión
session_destroy();

// Redirige al usuario a la página de inicio
header("Location: iniciarSesion.php");
?>
