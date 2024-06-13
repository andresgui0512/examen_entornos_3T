<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/formulario.css">
    <title>Crear Cuenta</title>
</head>
<body>
    <form action="formulario.php" method="post">
        <h1>Formulario</h1>
        <p>Nombre<input type="text" name="nombre" id="nom"/></p>
        <p>Apellido<input type="text" name="apellido" id="ape"/></p>
        <p>Correo Electrónico<input type="text" name="correo" id="correo"/></p>
        <p>Tipo de Incidencia<input type="text" name="tipo" id="tipo"/></p>
        <p>Descripción detallada de la incidencia <input type="text" name="incidencia" id="incidencia" style="width: 200px; height: 100px;"/></p>
        <p>Prioridad<input type="text" name="prioridad" id="prioridad"/></p>

        <button type="submit" name="enviar" id="enviar">Enviar formulario</button>
        <a href="formulario.php"></a>
    </form>
</body>
</html>