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
        <a href="crearCuenta.php">¿Todavía no tienes una cuenta creada? ¡Créate una ya!</a>
    </form>
    <?php
    // Inicia la sesión PHP
    session_start();
    include 'conecta.php';

    // Mediante un bucle if verifica si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtiene el correo electrónico del formulario
        $correo = $_POST["correo_electronico"];
        // Obtiene la clave del formulario
        $clave = $_POST["clave"];

        // Consulta SQL para obtener la clave y el nombre del usuario asociado al correo electrónico
        $sql = "SELECT clave, nombre FROM clientes WHERE correo_electronico = ?";
        // Prepara la consulta SQL
        $stmt = $mysql->prepare($sql);
        // Vincula el parámetro a la consulta
        $stmt->bind_param("s", $correo);
        // Ejecuta la consulta
        $stmt->execute();
        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();


        // Con un bucle if verifica si se encontró algún registro
        if ($result->num_rows > 0) {
            // Obtiene el primer registro
            $row = $result->fetch_assoc();
            // Con un bucle if verifica si la contraseña coincide
            if (password_verify($clave, $row['clave'])) {
                // Establece las variables de sesión
                $_SESSION['correo_electronico'] = $correo;
                $_SESSION['nombre'] = $row['nombre'];
                // Redirige al usuario a la página de inicio de sesión activado
                header("Location: inicioSesionActivado.php");
                exit;
            } else {
                // Muestra un mensaje de error si la contraseña es incorrecta
                echo "La contraseña es incorrecta";
            }
        } else {
            // Muestra un mensaje de error si no se encuentra el correo electrónico en la base de datos
            echo "Error al comprobar el registro: " . $conn->error;
        }
    }
    ?>
</body>
</html>
