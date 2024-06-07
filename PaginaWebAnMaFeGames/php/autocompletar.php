<?php
include 'conecta.php';

if(isset($_POST['term'])) {
    $term = $_POST['term'];
    
    $sql = "SELECT nombre FROM productos WHERE nombre LIKE '%" . $term . "%'";
    $resultado = $mysql->query($sql);

    $data = array();
    while ($fila = $resultado->fetch_assoc()) {
        $data[] = $fila['nombre'];
    }

    echo json_encode($data);
}
?>