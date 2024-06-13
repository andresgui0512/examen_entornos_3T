<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cesta.css">
    <title>Carrito</title>
</head>
<body>
    <?php
    // Inicia la sesión
    session_start();
    include 'conecta.php';

    // Mediante un bucle if verifica si se ha enviado un formulario por el método POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Con un bucle if verifica si se ha enviado el formulario de agregar al carrito
        if (isset($_POST["agregar"])) {
            // Agrega el producto al carrito
            agregarAlCarrito($_POST["producto_id"], $_POST["tipo_producto"]);
            // Redirige de vuelta al carrito
            header("Location: carrito.php");
            // Detiene la ejecución del script
            exit(); 
        // Si se ha enviado el formulario para quitar un producto del carrito...
        } elseif (isset($_POST["quitar"])) {
            // ...quita el producto del carrito
            quitarDelCarrito($_POST["quitar"]);
            // Redirige de vuelta al carrito
            header("Location: carrito.php");
            // Detiene la ejecución del script
            exit(); 
        }
    }

    // Función para agregar un producto al carrito
    function agregarAlCarrito($producto_id, $tipo_producto) {
        // Con un bucle if se verifica que si no existe la sesión 'carrito'...
        if (!isset($_SESSION['carrito'])) {
            // ...se cree
            $_SESSION['carrito'] = [];
        }
        // Marca 'encontrado' en false
        $encontrado = false;
        // Recorre cada elemento del carrito
        foreach ($_SESSION['carrito'] as &$item) {
            // Mediante un bucle if verifica si el producto ya está en el carrito
            if ($item['id'] == $producto_id && $item['tipo'] == $tipo_producto) {
                // Si el producto ya está en el carrito, aumenta la cantidad
                $item['cantidad'] += 1;
                // Marca 'encontrado' en true
                $encontrado = true;
                // Sale del bucle
                break;
            }
        }

        // Con un bucle if se verifica que si el producto no está en el carrito...
        if (!$encontrado) {
            // ...lo agrega
            $_SESSION['carrito'][] = array("id" => $producto_id, "tipo" => $tipo_producto, "cantidad" => 1);
        }
        
    }

    // Función para quitar un producto del carrito
    function quitarDelCarrito($indice) {
        // Con un bucle if verifica si el índice del producto está presente en el carrito
        if (isset($_SESSION['carrito'][$indice])) {
            // Elimina el producto del carrito
            unset($_SESSION['carrito'][$indice]);
            // Reordena los índices del array para evitar espacios vacíos
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);  
        }
    }
    
    // Con un bucle if verifica si el carrito no está vacío
    if (!empty($_SESSION['carrito'])) {
        // Imprime el contenedor del carrito
        echo "<div class='container'>";
        // Título del carrito
        echo "<h1>Carrito de Compras</h1>";
        // Recorre cada producto en el carrito
        foreach ($_SESSION['carrito'] as $indice => $producto) {
            // Consulta SQL para obtener los detalles del producto
            $sql = "SELECT * FROM productos WHERE id = " . $producto["id"];
            // Ejecuta la consulta
            $resultado = $mysql->query($sql);
            // Con un bucle if verifica si hay resultados en la consulta
            if ($resultado->num_rows > 0) {
                // Obtiene la primera fila de resultados
                $fila = $resultado->fetch_assoc();
                // Imprime el contenedor del producto
                echo "<div class='producto'>";
                // Imprime el nombre del producto
                echo "<h2>" . $fila["nombre"] . "</h2>";
                // Imprime los detalles del producto
                echo "<div class='caracteristicas'>";
                // Imprime el precio del producto
                echo "<p>Precio: " . $fila["precio"] . "€</p>";
                // Imprime la cantidad del producto en el carrito
                echo "<p>Cantidad: " . $producto["cantidad"] . "</p>";
                // Botón para quitar el producto del carrito
                echo "<form action='carrito.php' method='post' style='display:inline;'>";
                echo "<button type='submit' name='quitar' value='$indice'>Quitar</button>";
                echo "</form>";
                // Cierra el contenedor de caracteristicas
                echo "</div>";
                // Cierra el contenedor del producto
                echo "</div>";
            }
        }
        // Formulario para generar la factura
        echo "<form action='factura.php' method='post'>"; 
        // Campo oculto para indicar que se va a generar la factura
        echo "<input type='hidden' name='generar_factura' value='true'>"; 
        // Botón para enviar el formulario
        echo "<div class='checkout'><button type='submit' name='factura'>Realizar compra</button></div>"; 
        // Cierra el formulario
        echo "</form>"; 
        // Cierra el contenedor principal del carrito
        echo "</div>"; 

    } else {
        // Contenedor principal del carrito
        echo "<div class='container'>"; 
        // Muestra el mensaje de carrito vacío
        echo "<h1 class='empty-cart'>Cesta de Compras Vacía</h1>"; 
        // Cierra el contenedor principal del carrito
        echo "</div>"; 

    }
    // Cierra la conexión a la base de datos
    $mysql->close();
    ?>
</body>
</html>
