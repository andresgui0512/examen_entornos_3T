<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>
<body>
<?php
session_start();

include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar"])) {
        agregarAlCarrito($_POST["producto_id"], $_POST["tipo_producto"]);
        header("Location: carrito.php"); 
        exit(); 
    } elseif (isset($_POST["quitar"])) {
        quitarDelCarrito($_POST["quitar"]);
        header("Location: carrito.php");
        exit(); 
    }
}

function agregarAlCarrito($producto_id, $tipo_producto) {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $producto_id && $item['tipo'] == $tipo_producto) {
            $item['cantidad'] += 1;
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        $_SESSION['carrito'][] = array("id" => $producto_id, "tipo" => $tipo_producto, "cantidad" => 1);
    }
}

function quitarDelCarrito($indice) {
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);  
    }
}

if (!empty($_SESSION['carrito'])) {
    echo "<h1>Carrito de Compras</h1>";
    echo "<form action='factura.php' method='post'>";
    foreach ($_SESSION['carrito'] as $indice => $producto) {
        $sql = "SELECT * FROM productos WHERE id = " . $producto["id"];
        $resultado = $mysql->query($sql);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            echo "<div class='producto'>";
            echo "<h2>" . $fila["nombre"] . "</h2>";
            echo "<p>Precio: " . $fila["precio"] . "€</p>";
            echo "<p>Cantidad: " . $producto["cantidad"] . "</p>";
            echo "<button type='submit' name='quitar' value='$indice'>Quitar</button>";
            echo "</div>";
        }
    }
    echo "<input type='hidden' name='generar_factura' value='true'>";
    echo "<button type='submit' name='factura'>Realizar compra</button>";
    echo "</form>";
} else {
    echo "<h1>Cesta de Compras Vacía</h1>";
}

$mysql->close();
?>
</body>
</html>