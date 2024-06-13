<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inicioSesion.css">
    <title>Inicio de sesion</title>
</head>

<body>
    <form action="iniciarSesion.php" method="post">
        <h1>Inicio Sesión</h1>
        <p>Correo Electrónico<input type="text" name="correo_electronico" id="correo" /></p>
        <p>Clave<input type="password" name="clave" id="clave" /></p>

        <button type="submit" name="iniciar" id="iniciar">INICIAR SESIÓN</button>
        <a href="crearCuenta.php">Todavía no tienes una cuenta creada? Créate una ya!!</a>
    </form>
<?php

include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo_electronico"];
    $clave = $_POST["clave"];


    $sql = "SELECT clave FROM clientes WHERE correo_electronico = '$correo'";
    $result = $mysql->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($clave, $row['clave'])) {
                header("Location: ../index.php");
                exit; 
            } else {
                echo "la contraseña es incorrecta";
            }
        }
    } else {
        echo "Error al comprobar el registro. " . $mysql->error;
    }
}
?>
</body>

</html>