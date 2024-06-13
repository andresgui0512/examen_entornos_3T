<html>
<head>
    <title>Resultados</title>
</head>
<body>
    <?php
    include('conecta.php');

    // Obtener el término de búsqueda del formulario
    $termino_busqueda = $_POST['buscar'];

    // Muestra el título de los resultados de la búsqueda
    echo "<h1>Resultados de la búsqueda: " . $termino_busqueda . "</h1>";

    // Consulta SQL para buscar registros que coincidan con el término de búsqueda
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$termino_busqueda%'";
    // Ejecuta la consulta SQL
    $resultado = $mysql->query($sql);

    // Con un bucle if verifica si hay resultados en la búsqueda
    if (mysqli_num_rows($resultado) > 0) {
        // Recorre cada fila de resultados
        while ($fila = mysqli_fetch_assoc($resultado)) {
            // Nombre del producto
            echo "<p>" . $fila['nombre'] . "</p>"; 
            // Fecha de lanzamiento
            echo "<p>Fecha de Lanzamiento: " . $fila["fecha_lanzamiento"] . "</p>"; 
            // Empresa desarrolladora
            echo "<p>Empresa desarrolladora: " . $fila["empresa"] . "</p>"; 
            // Precio
            echo "<p>Precio: " . $fila["precio"] . "€</p>"; 
            // Formulario para agregar al carrito
            echo "<form action='carrito.php' method='post'>"; 
            // Imagen del producto
            echo "<img class='imagen_juego' src='../imagenes_productos/" . $fila["imagen"] . "'>";
            // Campo oculto para el ID del producto 
            echo "<input type='hidden' name='producto_id' value='" . $fila["id"] . "'>"; 
            // Campo oculto para el tipo de producto
            echo "<input type='hidden' name='tipo_producto' value='videojuego'>"; 
            // Botón para agregar al carrito
            echo "<button type='submit' name='agregar' class='videojuegos' style='width: 47px; height: 45px;'>
                <img src='../imagenes_pagina/cesta.png' width='40' height='38'>
            </button>"; 
            // Cierra el formulario
            echo "</form>";
        }        
    } else {
        // Mensaje si no hay resultados
        echo "No se encontraron resultados."; 
    }

    // Cerrar la conexión
    $mysql->close();
    ?>
</body>
</html>
