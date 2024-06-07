<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/chat.css">
    <script src="../js/chat.js"></script>
    <title>Chat</title>
</head>
<body>
    <form id="sendMessageForm" onsubmit="return false;">
        <input type="text" id="mensaje" name = "mensaje" placeholder="Escribe un mensaje...">
        <button onclick="sendMessage()">Enviar</button>
    </form>
    <div id="chatContainer"></div>
    </body>
</html>
<?php
include 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje = $_POST["mensaje"];
   
    $sql = "INSERT INTO ma VALUES (null, '$mensaje')";

    if ($mysql->query($sql) === TRUE) {
        echo "Registro insertado correctamente";
    } else {
        echo "Error al insertar el registro. " . $mysql->error;
    }
}
?>