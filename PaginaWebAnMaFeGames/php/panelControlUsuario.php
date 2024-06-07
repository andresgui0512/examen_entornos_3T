<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/juegos.css">
    <script src="../js/logicaCerrarSesion.js"></script>
    <title>Videojuegos</title>
</head>

<body>

    <?php

        
        include("conecta.php");

        $perfil = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $correo = $_POST["correo_electronico"];
            


            $sql = "SELECT nombre FROM clientes WHERE correo_electronico = '$correo'";
            $result= $conn->query($sql);

            if($result->num_rows>0){
                
                $row=$result->fetch_assoc();
                $perfil = $row["nombre"];
                
                
            }else{
                echo "No se encontraron registros enh la tabla biblioteca";
            }
        
            
        }
    ?>


    
    <div>

        <div class="iniciar">
            <img src="../imagenes_pagina/iniciarSesion.png" id="sesion" onclick="cerrarSesion()">
        
        </div>  
        
        <div id="dropdown" style="display:none;">
            <p>¡Hola,<?=$perfil?></p>
            <button onclick="location.href='cerrarSesion.php'">Cerrar Sesion</button>
        </div>

        <a href="php/carrito.php" class="carrito">
            <img src="../imagenes_pagina/cesta.png" class="cesta">
        </a>
        <a href="php/chat.php" class="Chat">
            <img src="../imagenes_pagina/chat.png" class="chat">
        </a>
        <a href="php/formulario.php" class="Form">
            <img src="../imagenes_pagina/formulario.png" class="form">
        </a>
    </div>

    <h2>Bienvenido <?=$perfil?></h2>
    <p>Aquí puedes añadir información sobre las últimas novedades en videojuegos o consolas.</p>

    <hr>

    <h2>Contáctenos</h2>
    <p>Ponte en contacto con nosotros para obtener más información.</p>
    <p>Teléfono: 123-456-789</p>
    <p>Email: info@anmafe_games.com</p>

    <footer>
        <div>
            Síguenos en redes sociales:
            <a href="#"><img src="../imagenes_pagina/facebook.png" alt="Facebook" width="30" height="30" style="margin-right: 10px;"></a>
            <a href="#"><img src="../imagenes_pagina/twitter.png" alt="Twitter" width="30" height="30" style="margin-right: 10px;"></a>
            <a href="#"><img src="../imagenes_pagina/instagram.png" alt="Instagram" width="30" height="30" style="margin-right: 10px;"></a>
        </div>
        <div>
            © 2024 Todos los derechos reservados. Nombre de tu empresa.
        </div>
    </footer>
</body>
</html>