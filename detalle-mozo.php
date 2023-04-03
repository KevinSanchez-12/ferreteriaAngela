<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM mozos WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $nombre = $row['nombre'];
    $datos = [
        'id' => $id,
        'nombre' => $nombre,
    ];
    echo json_encode($datos);
?>