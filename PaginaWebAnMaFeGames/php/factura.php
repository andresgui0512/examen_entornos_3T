<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
</head>
<body>
    <a href="../index.php">Volver a la tienda</a>
</body>
</html>
<?php
session_start();

include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generar_factura"])) {
    $tienda_id = $_SESSION['tienda_id'] ?? 1; 
    $cliente_id = $_SESSION['cliente_id'] ?? 1; 
    $empleado_id = $_SESSION['empleado_id'] ?? 1; 

    $factura = generarFactura($_SESSION['carrito'], $tienda_id, $cliente_id, $empleado_id);
    if ($factura) {
        unset($_SESSION['carrito']);
        mostrarFactura($factura);
    } else {
        echo "Error al generar la factura.";
    }
}

function generarFactura($productos, $tienda_id, $cliente_id, $empleado_id) {
    global $mysql;
    
    $total = 0;
    foreach ($productos as $producto) {
        $sql = "SELECT precio FROM productos WHERE id = " . $producto["id"];
        $resultado = $mysql->query($sql);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $total += $fila["precio"] * $producto["cantidad"];
        }
    }
    
    $mysql->begin_transaction();
    try {
        $stmt = $mysql->prepare("INSERT INTO ventas (fecha, total, tienda_id, cliente_id, empleado_id) VALUES (NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("diii", $total, $tienda_id, $cliente_id, $empleado_id);
        $stmt->execute();
        $venta_id = $stmt->insert_id;

        $stmt_detalle = $mysql->prepare("INSERT INTO detalle_venta (venta_id, producto_id, cantidad) VALUES (?, ?, ?)");
        foreach ($productos as $producto) {
            $stmt_detalle->bind_param("iii", $venta_id, $producto["id"], $producto["cantidad"]);
            $stmt_detalle->execute();
        }

        $mysql->commit();
        return array("venta_id" => $venta_id, "fecha" => date("Y-m-d H:i:s"), "total" => $total, "productos" => $productos);
    } catch (Exception $e) {
        $mysql->rollback();
        return false;
    }
}

function mostrarFactura($factura) {
    echo "<h1>Factura</h1>";
    echo "<p>Factura ID: " . $factura["venta_id"] . "</p>";
    echo "<p>Fecha: " . $factura["fecha"] . "</p>";
    echo "<p>Total: " . $factura["total"] . "€</p>";
    echo "<h2>Detalles de la Compra</h2>";
    foreach ($factura["productos"] as $producto) {
        global $mysql;
        $sql = "SELECT nombre, precio FROM productos WHERE id = " . $producto["id"];
        $resultado = $mysql->query($sql);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            echo "<div class='producto'>";
            echo "<h3>" . $fila["nombre"] . "</h3>";
            echo "<p>Precio Unitario: " . $fila["precio"] . "€</p>";
            echo "<p>Cantidad: " . $producto["cantidad"] . "</p>";
            echo "<p>Subtotal: " . ($fila["precio"] * $producto["cantidad"]) . "€</p>";
            echo "</div>";
        }
    }
}
?>
