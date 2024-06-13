<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/devolucion.css">
    <title>Factura</title>
</head>
<body>
    <a href="inicioSesionActivado.php">Volver a la tienda</a>
</body>
</html>
<?php
// Inicia la sesión
session_start();

include 'conecta.php';

// Con un bucle if verifica si el formulario ha sido enviado y el botón "generar_factura" ha sido presionado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generar_factura"])) {
    // Consulta que selecciona una tienda aleatoria de la tabla tiendas
    $sql_tienda = "SELECT id FROM tiendas ORDER BY RAND() LIMIT 1";
    // Ejecuta la consulta de tienda
    $resultado_tienda = $mysql->query($sql_tienda); 
    // Obtiene el ID de la tienda
    $tienda_id = $resultado_tienda->fetch_assoc()['id']; 

    // Selecciona un empleado aleatorio de la tabla empleados
    $sql_empleado = "SELECT id FROM empleados ORDER BY RAND() LIMIT 1";
     // Ejecuta la consulta de empleado
    $resultado_empleado = $mysql->query($sql_empleado);
    // Obtiene el ID del empleado
    $empleado_id = $resultado_empleado->fetch_assoc()['id']; 

    // Obtiene el correo electrónico del cliente desde la sesión
    $correo_electronico = $_SESSION['correo_electronico'] ?? '';
    // Inicializa el ID del cliente en 0
    $cliente_id = 0; 

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
    if ($cliente_id == 0) {
        // Muestra un mensaje de error si no se encuentra el cliente
        echo "Error al obtener el cliente."; 
        exit;
    }

    // Genera la factura y muestra los resultados
    $factura = generarFactura($_SESSION['carrito'], $tienda_id, $cliente_id, $empleado_id); // Genera la factura
    // Con un bucle if verifica si la factura se ha generado correctamente
    if ($factura) {
        // Si se ha generado correctamente elimina los productos del carrito 
        // de la sesión si la factura se generó correctamente
        unset($_SESSION['carrito']); 
        // Muestra la factura
        mostrarFactura($factura); 
    } else {
        // Muestra un mensaje de error si no se pudo generar la factura
        echo "Error al generar la factura.";
    }
}

// Función para generar la factura
function generarFactura($productos, $tienda_id, $cliente_id, $empleado_id) {
    // Hace accesible la variable $mysql dentro de la función
    global $mysql; 

    // Inicializa el total en 0
    $total = 0; 
    // Itera sobre los productos para calcular el total
    foreach ($productos as $producto) {
        // Consulta para obtener el precio del producto
        $sql = "SELECT precio FROM productos WHERE id = " . $producto["id"]; 
        // Ejecuta la consulta
        $resultado = $mysql->query($sql);
        // Con un bucle if verifica si el resultado de la consulta tiene al 
        // menos una fila
        if ($resultado->num_rows > 0) {
            // Obtiene los datos del producto
            $fila = $resultado->fetch_assoc(); 
            // Calcula el total
            $total += $fila["precio"] * $producto["cantidad"]; 
        }
    }
    
    // Inicia una transacción
    $mysql->begin_transaction(); 
    try {
        // Inserta los datos de la venta en la tabla ventas
        $stmt = $mysql->prepare("INSERT INTO ventas (fecha, total, tienda_id, cliente_id, empleado_id) VALUES (NOW(), ?, ?, ?, ?)");
        // Vincula los parámetros
        $stmt->bind_param("diii", $total, $tienda_id, $cliente_id, $empleado_id); 
        // Ejecuta la consulta
        $stmt->execute(); 
        // Obtiene el ID de la venta insertada
        $venta_id = $stmt->insert_id; 

        // Inserta los detalles de la venta en la tabla detalle_venta
        $stmt_detalle = $mysql->prepare("INSERT INTO detalle_venta (venta_id, producto_id, cantidad) VALUES (?, ?, ?)");
        // Itera sobre cada producto en el carrito
        foreach ($productos as $producto) {
            // Vincula los parámetros
            $stmt_detalle->bind_param("iii", $venta_id, $producto["id"], $producto["cantidad"]); 
            // Ejecuta la consulta
            $stmt_detalle->execute(); 
        }

        // Confirma la transacción
        $mysql->commit(); 
        // Retorna los datos de la factura
        return array("venta_id" => $venta_id, "fecha" => date("Y-m-d H:i:s"), "total" => $total, "productos" => $productos);
    } catch (Exception $e) {
        // Revierte la transacción en caso de error
        $mysql->rollback(); 
        // Retorna false si hubo un error
        return false; 
    }
}

// Función para mostrar la factura
function mostrarFactura($factura) {
    // Título de la factura
    echo "<h1>Factura</h1>"; 
    // Muestra el ID de la factura
    echo "<p>Factura ID: " . $factura["venta_id"] . "</p>"; 
    // Muestra la fecha de la factura
    echo "<p>Fecha: " . $factura["fecha"] . "</p>"; 
    // Muestra el total de la factura
    echo "<p>Total: " . $factura["total"] . "€</p>"; 
    // Título de los detalles de la compra
    echo "<h2>Detalles de la Compra</h2>"; 
    // Itera sobre los productos de la factura
    foreach ($factura["productos"] as $producto) {
        // Hace accesible la variable $mysql dentro de la función
        global $mysql; 
        // Consulta para obtener los datos del producto
        $sql = "SELECT nombre, precio FROM productos WHERE id = " . $producto["id"]; 
        // Ejecuta la consulta
        $resultado = $mysql->query($sql); 
        // Con un bucle if verifica si el resultado de la consulta tiene al 
        // menos una fila
        if ($resultado->num_rows > 0) {
            // Obtiene los datos del producto
            $fila = $resultado->fetch_assoc(); 
            // Contenedor del producto
            echo "<div class='producto'>"; 
            // Muestra el nombre del producto
            echo "<h3>" . $fila["nombre"] . "</h3>";
            // Muestra el precio unitario del producto
            echo "<p>Precio Unitario: " . $fila["precio"] . "€</p>"; 
            // Muestra la cantidad del producto
            echo "<p>Cantidad: " . $producto["cantidad"] . "</p>";
            // Muestra el subtotal del producto
            echo "<p>Subtotal: " . ($fila["precio"] * $producto["cantidad"]) . "€</p>";
            // Cierra el contenedor del producto
            echo "</div>"; 
        }
    }
}
?>