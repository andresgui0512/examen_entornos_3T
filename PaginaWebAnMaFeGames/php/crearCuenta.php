<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/crearCuenta.css">
    <title>Crear Cuenta</title>
</head>
<body>
    <form action="crearCuenta.php" method="post">
        <h1>Crear Cuenta</h1>
        <p>Nombre<input type="text" name="nombre" id="nom"/></p>
        <p>Apellido<input type="text" name="apellido" id="ape"/></p>
        <p>Correo Electrónico<input type="text" name="correo" id="correo"/></p>
        <p>Dirección<input type="text" name="direccion" id="dir"/></p>
        <p>Ciudad<input type="text" name="ciudad" id="ciudad"/></p>
        <p>Código Postal<input type="text" name="codigo" id="codigo"/></p>
        <p>Fecha de Nacimiento<input type="date" name="fecha" id="fecha"/></p>
        <p>DNI<input type="text" name="dni" id="dni"/></p>
        <p>Clave<input type="password" name="clave" id="clave"/></p>

        <button type="submit" name="iniciar" id="iniciar">CREAR CUENTA</button>
        <a href="iniciarSesion.php">Ya tienes una cuenta creada? Inicia sesión ya!!</a>
    </form>
</body>
</html>
<?php
include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $codigo = $_POST["codigo"];
    $fecha = date("Y-m-d"); 
    $fecha_nacimiento = $_POST["fecha"];
    $dni = $_POST["dni"];
    $clave = $_POST["clave"];

    $hash = password_hash($clave, PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes VALUES (null, '$nombre', '$apellido', '$correo', '$direccion', '$ciudad', '$codigo', '$fecha', '$fecha_nacimiento', '$dni', '$hash')";

    if ($mysql->query($sql) === TRUE) {
        echo "Registro insertado correctamente";
    } else {
        echo "Error al insertar el registro. " . $mysql->error;
    }
}
?>