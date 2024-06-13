<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/devolucion.css">
    <title>Devolución</title>
</head>
<body>
    <a href="incioSesionActivado.php">Volver a la tienda</a>
    <h1>Generar Devolución</h1>
    <form method="POST" action="">
        <label for="venta_id">ID de la Venta:</label>
        <input type="text" id="venta_id" name="venta_id" required>
        <br><br>
        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" required></textarea>
        <br><br>
        <button type="submit" name="generar_devolucion">Generar Devolución</button>
    </form>

    <?php
    // Inicia la sesión
    session_start();

    include 'conecta.php';

    // Con un bucle if comprueba si el formulario se ha enviado con el método POST y si 
    // el botón generar_devolucion ha sido pulsado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generar_devolucion"])) {
        // Obtiene el ID de la venta 
        $venta_id = $_POST['venta_id'];
        // Obtiene el comentario
        $comentario = $_POST['comentario'];
        // Se especifica el campo 'estado' en "Pendiente"
        $estado = "Pendiente"; 

        // Variable global de conexión a la base de datos
        global $mysql;

        // Consulta SQL para seleccionar la venta por su ID
        $sql_venta = "SELECT * FROM ventas WHERE id = ?";
        // Prepara la consulta SQL
        $stmt_venta = $mysql->prepare($sql_venta);
        // Vincula el parámetro de ID de venta
        $stmt_venta->bind_param("i", $venta_id);
        // Ejecuta la consulta
        $stmt_venta->execute();
        // Obtiene el resultado de la consulta
        $resultado_venta = $stmt_venta->get_result();

        // Comprueba si no se encontraron filas en el resultado de la consulta
        if ($resultado_venta->num_rows == 0) {
            // Imprime un mensaje de error
            echo "Venta no encontrada.";
            // Detiene la ejecución del script
            return;
        }

        // Obtiene la fila de la venta
        $venta = $resultado_venta->fetch_assoc();
        // Obtiene el total de la venta
        $total = $venta['total'];
        // Obtiene la fecha actual 
        $fecha = date("Y-m-d H:i:s");

        // Consulta los detalles de la venta para obtener los productos vendidos
        $sql_productos = "SELECT * FROM detalle_venta WHERE venta_id = ?";
        // Prepara la consulta
        $stmt_productos = $mysql->prepare($sql_productos);
        // Vincula el parámetro de la venta_id
        $stmt_productos->bind_param("i", $venta_id);
        // Ejecuta la consulta
        $stmt_productos->execute();
        // Obtiene el resultado de la consulta
        $resultado_productos = $stmt_productos->get_result();

        // Inicializa un array para almacenar los productos vendidos
        $productos = [];
        // Recorre los resultados 
        while ($fila = $resultado_productos->fetch_assoc()) {
            // Almacena los resultados en el array productos
            $productos[] = $fila;
        }

        // Consulta para obtener los IDs de todos los empleados
        $sql_empleados = "SELECT id FROM empleados";
        // Ejecuta la consulta
        $resultado_empleados = $mysql->query($sql_empleados);
        // Inicializa un array para almacenar los IDs de los empleados
        $empleados = [];
        // Recorre los resultados 
        while ($fila = $resultado_empleados->fetch_assoc()) {
            // Almacena los IDs en el array $empleados
            $empleados[] = $fila['id'];
        }

        // Verifica si no hay empleados disponibles
        if (empty($empleados)) {
            // Muestra un mensaje indicando que no hay empleados disponibles
            echo "No hay empleados disponibles.";
            // Finaliza el proceso
            return;
        }

        // Selecciona un empleado aleatorio
        $empleado_id = $empleados[array_rand($empleados)];

        // Inicia la transacción
        $mysql->begin_transaction();
        try {
            // Prepara la consulta para insertar la devolución en la tabla devoluciones
            $stmt_devolucion = $mysql->prepare("INSERT INTO devoluciones (venta_id, fecha, empleado_id, total, comentario, estado) VALUES (?, ?, ?, ?, ?, ?)");
            // Vincula los parámetros de la consulta
            $stmt_devolucion->bind_param("isidss", $venta_id, $fecha, $empleado_id, $total, $comentario, $estado);
            // Ejecuta la consulta
            $stmt_devolucion->execute();
            // Obtiene el ID de la devolución insertada
            $devolucion_id = $stmt_devolucion->insert_id;

            // Prepara la consulta para insertar los detalles de la devolución en la tabla detalles_devolucion
            $stmt_detalle_devolucion = $mysql->prepare("INSERT INTO detalles_devolucion (devolucion_id, producto_id, cantidad) VALUES (?, ?, ?)");
            // Recorre los productos y añade cada detalle de devolución
            foreach ($productos as $producto) {
                // Vincula los parámetros de la consulta
                $stmt_detalle_devolucion->bind_param("iii", $devolucion_id, $producto["producto_id"], $producto["cantidad"]);
                // Ejecuta la consulta
                $stmt_detalle_devolucion->execute();
            }

            // Confirma la transacción
            $mysql->commit();

            // Título de la devolución
            echo "<h1>Devolución</h1>"; 
            // ID de la devolución
            echo "<p>Devolución ID: " . $devolucion_id . "</p>"; 
            // Fecha de la devolución
            echo "<p>Fecha: " . $fecha . "</p>"; 
            // Total de la devolución
            echo "<p>Total: " . $total . "€</p>"; 
            // Título de los detalles de la devolución
            echo "<h2>Detalles de la Devolución</h2>"; 

            // Recorre los productos de la devolución
            foreach ($productos as $producto) {
                // Consulta para obtener información del producto
                $sql = "SELECT nombre, precio FROM productos WHERE id = " . $producto["producto_id"];
                // Ejecuta la consulta SQL 
                $resultado = $mysql->query($sql);
                // Con un bucle if se verifica que si hay resultados en la consulta...
                if ($resultado->num_rows > 0) {
                    // Obtiene la siguiente fila de resultados
                    $fila = $resultado->fetch_assoc();
                    // Muestra la información del producto
                    echo "<div class='producto'>";
                     // Nombre del producto
                    echo "<h3>" . $fila["nombre"] . "</h3>";
                    // Precio del producto
                    echo "<p>Precio Unitario: " . $fila["precio"] . "€</p>"; 
                    // Cantidad devuelta
                    echo "<p>Cantidad: " . $producto["cantidad"] . "</p>"; 
                    // Subtotal
                    echo "<p>Subtotal: " . ($fila["precio"] * $producto["cantidad"]) . "€</p>"; 
                    // Cierra el contenedor 
                    echo "</div>";
                }
            }
        } catch (Exception $e) {
            // Revierte la transacción en caso de error
            $mysql->rollback(); 
            // Muestra el mensaje de error
            echo "Error al generar la devolución: " . $e->getMessage(); 
        }
    }
    ?>
</body>
</html>
