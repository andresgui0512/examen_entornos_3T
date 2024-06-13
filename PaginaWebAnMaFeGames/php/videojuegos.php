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
            <img src="../imagenes_pagina/cesta.png" class="cesta" alt="Carrito">
        </a>
    </div>
    <div>
        <a href="../html/iniciarSesion.html" class="iniciar">
            <img src="../imagenes_pagina/iniciarSesion.jpg" class="sesion" alt="Iniciar Sesión">
        </a>
    </div>
    <?php
    include 'conecta.php';

    $sql = "SELECT * FROM productos WHERE consola_id IS NOT NULL";
    $resultado = $mysql->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='producto'>";
            echo "<h2>" . $fila["nombre"] . "</h2>";
            echo "<p>Fecha de Lanzamiento: " . $fila["fecha_lanzamiento"] . "</p>";
            echo "<p>Empresa desarrolladora: " . $fila["empresa"] . "</p>";
            echo "<p>Precio: " . $fila["precio"] . "€</p>";
            echo "<form action='carrito.php' method='post'>";
            echo "<img class='imagen_juego' src='../imagenes_productos/" . $fila["imagen"] . "' alt='" . $fila["nombre"] . "'>";
            echo "<input type='hidden' name='producto_id' value='" . $fila["id"] . "'>";
            echo "<input type='hidden' name='tipo_producto' value='videojuego'>";
            echo "<button type='submit' name='agregar' class='videojuegos' style='width: 47px; height: 45px;'>
                <img src='../imagenes_pagina/cesta.png' width='40' height='38' alt='Agregar al carrito'>
            </button>";
            echo "</form>";
            echo "</div>";
        }
    }

    $mysql->close();
    ?>
</body>
</html>
