<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/formulario.css">
    <title>Formulario</title>
</head>
<body>
    <a href="incioSesionActivado.php">Volver a la tienda</a>
    <form action="formulario.php" method="post">
        <h1>Formulario</h1>
        <div class="form-group">
            <label for="mensaje">Incidencia:</label>
            <textarea name="mensaje" id="mensaje"></textarea>
        </div>
        <button type="submit" name="enviar" id="enviar">Enviar formulario</button>
    </form>
</body>
</html>

<?php
// Inicia la sesión
session_start();

include 'conecta.php'; 

// Verifica si se ha enviado el formulario y se ha hecho clic en el botón "enviar"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
    // Obtiene el mensaje del formulario
    $mensaje = $_POST['mensaje'];
    // Obtiene la fecha actual
    $fecha = date("Y-m-d H:i:s");
    
    // Obtiene el correo electrónico del cliente desde la sesión
    $correo_electronico = $_SESSION['correo_electronico'] ?? '';
    // Inicializa el ID del cliente en null
    $cliente_id = null; 

    // Con un bucle if verifica si el correo electrónico no está vacío
    if (!empty($correo_electronico)) {
        // Consulta para obtener el ID del cliente a partir del correo electrónico
        $sql_cliente = "SELECT id FROM clientes WHERE correo_electronico = ?";
        // Prepara la consulta
        $stmt_cliente = $mysql->prepare($sql_cliente); 
        // Vincula el parámetro del correo electrónico
        $stmt_cliente->bind_param("s", $correo_electronico); 
        // Ejecuta la consulta
        $stmt_cliente->execute(); 
         // Obtiene el resultado de la consulta
        $resultado_cliente = $stmt_cliente->get_result();

        // Con un bucle if verifica si se encontró un cliente
        if ($resultado_cliente->num_rows > 0) {
            // Obtiene los datos del cliente
            $cliente = $resultado_cliente->fetch_assoc(); 
            // Asigna el ID del cliente
            $cliente_id = $cliente['id'];
        }
    }

    // Con un bucle if verifica si el ID del cliente es válido
    if ($cliente_id === null) {
        // Muestra un mensaje de error si no se encuentra el cliente
        echo "Error al obtener el cliente."; 
        exit;
    }

    // Consulta SQL para insertar los datos del formulario en la base de datos
    $sql = "INSERT INTO incidentes (mensaje, fecha, cliente_id) VALUES (?, ?, ?)";
    // Prepara la consulta SQL
    $stmt = $mysql->prepare($sql);
    // Vincula los parámetros a la consulta
    $stmt->bind_param("ssi", $mensaje, $fecha, $cliente_id);
    // Ejecuta la consulta y verifica si se ha ejecutado correctamente
    if ($stmt->execute()) {
        // Muestra un mensaje que indica que los datos se han almacenado correctamente
        echo "Los datos se han almacenado correctamente.";
    } else {
        // Muestra un mensaje de error
        echo "Error al guardar los datos: " . $mysql->error;
    }
    // Cierra la consulta 
    $stmt->close();
    // Cierra la conexión
    $mysql->close();
}
?>

