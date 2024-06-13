<?php
            // Configuración de la base de datos
            $servidor="localhost";
            $usuario="root";
            $contra="";
            $bbdd="anmafe_games_bd";

            // Crear una conexión
            $mysql = new mysqli($servidor, $usuario, $contra, $bbdd);
            $mysql ->set_charset("utf8");

            // Verificar la conexión
            if ($mysql->connect_error) {
                die("Error de conexión: " . $mysql->connect_error);
            }
?>