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

// Con un bucle if verifica si se está enviando el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el nombre del formulario
    $nombre = $_POST["nombre"];
    // Obtiene el apellido del formulario
    $apellido = $_POST["apellido"];
    // Obtiene el correo electrónico del formulario
    $correo = $_POST["correo"];
    // Obtiene la dirección del formulario
    $direccion = $_POST["direccion"];
    // Obtiene la ciudad del formulario
    $ciudad = $_POST["ciudad"];
    // Obtiene el código postal del formulario
    $codigo = $_POST["codigo"];
    // Obtiene la fecha actual
    $fecha = date("Y-m-d");
    // Obtiene la fecha de nacimiento del formulario
    $fecha_nacimiento = $_POST["fecha"];
    // Obtiene el DNI del formulario
    $dni = $_POST["dni"];
    // Obtiene la clave del formulario
    $clave = $_POST["clave"];


    // Encripta la clave
    $hash = password_hash($clave, PASSWORD_DEFAULT);

    // Consulta para insertar un nuevo cliente en la base de datos
    $sql = "INSERT INTO clientes VALUES (null, '$nombre', '$apellido', '$correo', '$direccion', '$ciudad', '$codigo', '$fecha', '$fecha_nacimiento', '$dni', '$hash')";

    // Con un bucle if verifica que si la consulta SQL se ejecutó correctamente...
    if ($mysql->query($sql) === TRUE) {
        // ...muestra un mensaje que indica que se ha insertado el registro correctamente
        echo "Registro insertado correctamente";
    } else {
        // Muestra el mensaje que indica que ha surgido un error al insertar el registro
        echo "Error al insertar el registro. " . $mysql->error;
    }
}
?>