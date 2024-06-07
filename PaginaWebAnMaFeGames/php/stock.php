<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>
</head>
<body>
<?php
$consulta_tienda = "SELECT nombre, direccion, ciudad, codigo_postal FROM tiendas WHERE producto_id = $id_producto";
$resultado_tienda = $mysql->query($consulta_tienda);

if ($resultado_tienda->num_rows > 0) {
    $fila_tienda = $resultado_tienda->fetch_assoc();
    echo "<p>Nombre de tienda: " . $fila_tienda["nombre"] . "</p>";
    echo "<p>Dirección: " . $fila_tienda["direccion"] . "</p>";
    echo "<p>Ciudad: " . $fila_tienda["ciudad"] . "</p>";
    echo "<p>Código Postal: " . $fila_tienda["codigo_postal"] . "</p>";
} else {
    echo "No se encontraron tiendas para este producto.";
}
?>
</body>
</html>
