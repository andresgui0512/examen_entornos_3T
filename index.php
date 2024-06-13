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
    </h1>
    <div class="productos">
        <form action="buscar.php" method="post">
            <input type="text" name="buscar" placeholder="Buscar...">
            <button type="submit">
                <img src="imagenes_pagina/buscar.png" width="20" height="auto">
            </button>
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
    </div>
    <hr>
    <h2>Contáctenos</h2>
    <p>Ponte en contacto con nosotros para obtener más información.</p>
    <p>Teléfono: 123-456-789</p>
    <p>Email: info@anmafe_games.com</p>
    <footer>
        <div>
            Síguenos en redes sociales:
            <a href="#"><img src="imagenes_pagina/facebook.png" alt="Facebook" width="30" height="30" style="margin-right: 10px;"></a>
        </div>
        <p>© 2024 Todos los derechos reservados. Nombre de tu empresa.</p>
    </footer>
</body>
</html>
