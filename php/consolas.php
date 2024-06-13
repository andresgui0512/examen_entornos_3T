<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/videojuegos.css">
    <title>Consolas</title>
</head>
<body>
    <div id="buscar">
        <form action="buscar.php" method="post">
            <input type="text" name="buscar" placeholder="Buscar...">
            <a href="buscar.php">
                <img src="../imagenes_pagina/buscar.png" width="20" height="auto">
            </a>
        </form>
    </div>
    <div>
        <a href="iniciarSesion.php" class="iniciar">
            <img src="../imagenes_pagina/iniciarSesion.png" class="sesion" alt="Iniciar Sesión">
        </a>
    </div>
    <?php
    include 'conecta.php';

    // Consulta para seleccionar productos que no son consolas
    $sql = "SELECT p.*, i.cantidad, t.direccion, t.ciudad
            FROM productos p
            JOIN inventario i ON p.id = i.producto_id
            JOIN tiendas t ON i.tienda_id = t.id
            WHERE p.consola_id IS NULL";
    // Ejecuta la consulta SQL y almacena el resultado en la variable '$resultado'
    $resultado = $mysql->query($sql);

    // Con un bucle if verificar si hay resultados
    if ($resultado->num_rows > 0) {
        // Recorre cada fila de resultados
        while ($fila = $resultado->fetch_assoc()) {
            // Imprime un contenedor div para cada producto
            echo "<div class='producto'>";
            // Nombre del producto
            echo "<h2>" . $fila["nombre"] . "</h2>"; 
            // Fecha de lanzamiento
            echo "<p>Fecha de lanzamiento: " . $fila["fecha_lanzamiento"] . "</p>"; 
            // Empresa desarrolladora
            echo "<p>Empresa desarrolladora: " . $fila["empresa"] . "</p>"; 
            // Precio del producto
            echo "<p>Precio: " . $fila["precio"] . "€</p>"; 
            // Cantidad del producto en la tienda
            echo "<p>Cantidad: " . $fila["cantidad"] . "</p>"; 
            // Dirección y ciudad de la tienda
            echo "<p>Ubicación: " . $fila["direccion"] . ", " . $fila["ciudad"] . "</p>"; 
            // Formulario para agregar al carrito
            echo "<form action='carrito.php' method='post'>"; 
            // Imagen del producto
            echo "<img  class='imagen_juego' src='../imagenes_productos/" . $fila["imagen"] . "'>"; 
            // Campo oculto para el ID del producto
            echo "<input type='hidden' name='producto_id' value='" . $fila["id"] . "'>";
            // Campo oculto para el tipo de producto
            echo "<input type='hidden' name='tipo_producto' value='consola'>";
            // Botón para agregar al carrito
            echo "<button type='submit' name='agregar' class='videojuegos' style='width: 47px; height: 45px;'>
                <img src='../imagenes_pagina/cesta.png' width='40' height='38'>
            </button>";
            // Cierra el formulario 
            echo "</form>";
            // Fin del div del producto
            echo "</div>"; 

        }
    }

    // Cierra la conexión a la base de datos
    $mysql->close();
    ?>
</body>
</html>
