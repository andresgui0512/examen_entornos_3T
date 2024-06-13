<html>
<head>
    <title>Resultados</title>
</head>
<body>
<?php
include('conecta.php');

// Obtener el término de búsqueda del formulario
$termino_busqueda = $_POST['buscar'];
echo "<h1>Resultados de la búsqueda: " . $termino_busqueda . "</h1>";

// Consulta SQL para buscar registros que coincidan con el término de búsqueda
$sql = "SELECT * FROM productos WHERE nombre LIKE '%$termino_busqueda%'";
$resultado = $mysql->query($sql);

// Mostrar los resultados de la búsqueda
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Mostrar los resultados aquí
        echo "<p>" . $fila['nombre'] . "</p>";
        echo "<p>Fecha de Lanzamiento: " . $fila["fecha_lanzamiento"] . "</p>";
        echo "<p>Empresa desarrolladora: " . $fila["empresa"] . "</p>";
        echo "<p>Precio: " . $fila["precio"] . "€</p>";
        echo "<form action='carrito.php' method='post'>";
        echo "<img  class='imagen_juego' src='../imagenes_productos/" . $fila["imagen"] . "'>";
        echo "<input type='hidden' name='producto_id' value='" . $fila["id"] . "'>";
        echo "<input type='hidden' name='tipo_producto' value='videojuego'>";
        echo "<button type='submit' name='agregar' class='videojuegos' style='width: 47px; height: 45px;'>
            <img src='../imagenes_pagina/cesta.png' width='40' height='38'>
        </button>";
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
$mysql->close();
?>
</body>
</html>
