<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/juegos.css">
    <title>Videojuegos</title>
</head>

<body>
    <h1>
        <img src="imagenes_pagina/cuartoLogo.png" alt="logo">
        <title>Ofertas Especiales para Usted. Compre ya!!!</title>
    </h1>

    <div class="productos">
        <form action="buscar.php" method="post">
            <input type="text" name="buscar" placeholder="Buscar...">
            <a href="buscar.php">
                <img src="imagenes_pagina/buscar.png" width="20" height="auto">
            </a>
        </form>
        

        <div class="videojuegos">
            <form action="php/videojuegos.php" method="post">
                <button type="submit" class="videojuegos">Videojuegos</button>
            </form>
        </div>
        <div class="consolas">
            <form action="php/consolas.php" method="post">
                <button type="submit" class="consolas">Consolas</button>
            </form>
        </div>

        <a href="php/iniciarSesion.php" class="iniciar">
            <img src="imagenes_pagina/iniciarSesion.png" class="sesion">
        </a>
        <a href="php/carrito.php" class="carrito">
            <img src="imagenes_pagina/cesta.png" class="cesta">
        </a>
        <a href="php/chat.php" class="Chat">
            <img src="imagenes_pagina/chat.png" class="chat">
        </a>
        <a href="php/formulario.php" class="Form">
            <img src="imagenes_pagina/formulario.png" class="form">
        </a>
    </div>

    <h2>Últimas Novedades</h2>
    <p>Aquí puedes añadir información sobre las últimas novedades en videojuegos o consolas.</p>

    <hr>

    <h2>Contáctenos</h2>
    <p>Ponte en contacto con nosotros para obtener más información.</p>
    <p>Teléfono: 123-456-789</p>
    <p>Email: info@anmafe_games.com</p>

    <footer>
        <div>
            Síguenos en redes sociales:
            <a href="#"><img src="imagenes_pagina/facebook.png" alt="Facebook" width="30" height="30" style="margin-right: 10px;"></a>
            <!--<a href="#"><img src="imagenes_pagina/twitter.png" alt="Twitter" width="30" height="30" style="margin-right: 10px;"></a>
            <a href="#"><img src="imagenes_pagina/instagram.png" alt="Instagram" width="30" height="30" style="margin-right: 10px;"></a>
-->     </div>
        <div>
            © 2024 Todos los derechos reservados. Nombre de tu empresa.
        </div>
    </footer>
</body>
</html>
