<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/videojuegos.css">
    <title>Videojuegos</title>
</head>
<body>
    <div id="buscar">
        <form action="buscar.php" method="post">
            <input type="text" name="buscar" placeholder="Buscar...">
            <button type="submit">
                <img src="../imagenes_pagina/buscar.png" width="20" height="auto" alt="Buscar">
            </button>
        </form>
    </div>
    <div>
        <a href="carrito.php" class="carrito">
            <img src="../imagenes_pagina/cesta2.png" class="cesta" alt="Carrito">
        </a>
    </div>
    <?php
    include 'conecta.php';

    // Consulta SQL para seleccionar los productos junto con los detalles de inventario
    $sql = "SELECT p.*, i.cantidad, i.estado, t.direccion, t.ciudad
            FROM productos p
            JOIN inventario i ON p.id = i.producto_id
            JOIN tiendas t ON i.tienda_id = t.id
            WHERE p.consola_id IS NOT NULL";
    
    // Ejecuta la consulta SQL y almacena el resultado en la variable '$resultado'
    $resultado = $mysql->query($sql);

    // Verifica si hay filas en el resultado de la consulta
    if ($resultado->num_rows > 0) {
        // Recorre cada fila del resultado de la consulta
        while ($fila = $resultado->fetch_assoc()) {
            // Imprime un contenedor div para cada producto
            echo "<div class='producto'>";
            // Imprime el nombre del producto 
            echo "<h2>" . $fila["nombre"] . "</h2>";
            // Imprime la fecha de lanzamiento del producto 
            echo "<p>Fecha de Lanzamiento: " . $fila["fecha_lanzamiento"] . "</p>";
            // Imprime la empresa desarrolladora del producto 
            echo "<p>Empresa desarrolladora: " . $fila["empresa"] . "</p>";
            // Imprime el precio del producto 
            echo "<p>Precio: " . $fila["precio"] . "€</p>";
            // Imprime la dirección y la ciudad de la tienda donde se encuentra el producto
            echo "<p>Ubicación: " . $fila["direccion"] . ", " . $fila["ciudad"] . "</p>";
            // Imprime la cantidad del producto en la tienda
            echo "<p>Cantidad: " . $fila["cantidad"] . "</p>";
            // Imprime el estado del producto
            echo "<p>Estado: " . $fila["estado"] . "</p>";
            // Imprime un formulario que envía los datos a 'carrito.php' mediante el método POST
            echo "<form action='carrito.php' method='post'>";
            // Imprime la imagen del producto 
            echo "<img class='imagen_juego' src='../imagenes_productos/" . $fila["imagen"] . "' alt='" . $fila["nombre"] . "'>";
            // Imprime un campo oculto que contiene el ID del producto
            echo "<input type='hidden' name='producto_id' value='" . $fila["id"] . "'>";
            // Imprime un campo oculto que especifica el tipo de producto como 'videojuego'
            echo "<input type='hidden' name='tipo_producto' value='videojuego'>";
            // Imprime un botón para agregar el producto al carrito
            echo "<button type='submit' name='agregar' class='videojuegos' style='width: 47px; height: 45px;'>
                <img src='../imagenes_pagina/cesta.png' width='40' height='38' alt='Agregar al carrito'>
            </button>";
            // Cierra el formulario
            echo "</form>";
            // Cierra el contenedor div del producto
            echo "</div>";
        }
    }
    // Cierra la conexión a la base de datos
    $mysql->close();
    ?>
</body>
</html>
