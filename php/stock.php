<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>
</head>
<body>
<?php
// Consulta SQL para seleccionar la información de la tienda donde está disponible el producto con el ID especificado
$consulta_tienda = "SELECT nombre, direccion, ciudad, codigo_postal FROM tiendas WHERE producto_id = $id_producto";
// Ejecuta la consulta SQL y almacena el resultado en la variable '$resultado_tienda'
$resultado_tienda = $mysql->query($consulta_tienda);

// Mediante un bucle if verifica si hay resultados en la consulta
if ($resultado_tienda->num_rows > 0) {
    // Obtiene la primera fila de resultados
    $fila_tienda = $resultado_tienda->fetch_assoc();
    // Imprime el nombre de la tienda
    echo "<p>Nombre de tienda: " . $fila_tienda["nombre"] . "</p>";
    // Imprime la dirección de la tienda
    echo "<p>Dirección: " . $fila_tienda["direccion"] . "</p>";
    // Imprime la ciudad de la tienda
    echo "<p>Ciudad: " . $fila_tienda["ciudad"] . "</p>";
    // Imprime el código postal de la tienda
    echo "<p>Código Postal: " . $fila_tienda["codigo_postal"] . "</p>";
} else {
    // Si no hay resultados, imprime un mensaje indicando que no se encontraron tiendas para el producto
    echo "No se encontraron tiendas para este producto.";
}
?>
</body>
</html>
