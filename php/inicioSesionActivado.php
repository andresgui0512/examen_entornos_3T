<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/juegos2.css">
    <title>Videojuegos</title>
    <script src="../js/logicaCerrarSesion.js"></script>
</head>
<body>
    <h1>
        <img src="../imagenes_pagina/cuartoLogo.png" alt="logo">
    </h1>
    <?php
    // Inicia la sesión PHP
    session_start();
    // Con un bucle if verifica si no está establecida la variable de sesión 'correo_electronico'
    if (!isset($_SESSION['correo_electronico'])) {
        // Redirige al usuario a la página de inicio
        header("Location: ../index.php");
        exit;
    }
    // Obtiene el nombre de usuario 
    $nombre = $_SESSION['nombre'];
    ?>
    <div class="productos">
        <form action="buscar.php" method="post">
            <input type="text" name="buscar" placeholder="Buscar...">
            <a href="buscar.php">
                <img src="../imagenes_pagina/buscar.png" width="20" height="auto">
            </a>
        </form>
        <a href="iniciarSesion.php" class="iniciar">
            <img src="../imagenes_pagina/iniciarSesion.png" class="sesion">
        </a>
        <a href="carrito.php" class="carrito">
            <img src="../imagenes_pagina/cesta2.png" class="cesta">
        </a>
        <a href="formulario.php" class="Form">
            <img src="../imagenes_pagina/formulario.png" class="form">
        </a>
        <a href="devolucion.php" class="Devolucion">
            <img src="../imagenes_pagina/devolucion2.png" class="devolucion">
        </a>
    </div>
    <h2>Bienvenido/a <?= $nombre ?></h2>
    <a href="cerrarSesion.php" class="Cerrar"> 
        <img src="../imagenes_pagina/cerrarSesion2.png" class="Sesion">
    </a>
    <div class="videojuegos">
            <form action="videojuegos2.php" method="post">
                <button type="submit" class="videojuegos">Videojuegos</button>
            </form>
        </div>
        <div class="consolas">
            <form action="consolas2.php" method="post">
                <button type="submit" class="consolas">Consolas</button>
            </form>
        </div>
    <hr>
    <h2>Contáctenos</h2>
    <p>Ponte en contacto con nosotros para obtener más información.</p>
    <p>Teléfono: 123-456-789</p>
    <p>Email: info@anmafe_games.com</p>
    <footer>
        <div>
            Síguenos en redes sociales:
            <a href="#"><img src="../imagenes_pagina/facebook.png" alt="Facebook" width="30" height="30" style="margin-right: 10px;"></a>
        </div>
        <p>© 2024 Todos los derechos reservados. Nombre de tu empresa.</p>
    </footer>
</body>
</html>
