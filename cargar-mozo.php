<?php
    include 'bd.php';
    $nombre = $_POST['nombre'];
    $sql = "INSERT INTO mozos (nombre) VALUES ('$nombre')";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Mozo agregado con éxito',
    ];
    echo json_encode($datos);
?>