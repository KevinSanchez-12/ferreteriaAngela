<?php
    include 'bd.php';
    $nombre = $_POST['nombre'];
    $sql = "INSERT INTO cajeros (nombre) VALUES ('$nombre')";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Cajero agregado con éxito',
    ];
    echo json_encode($datos);
?>