<?php
    include 'bd.php';
    $nombre = $_POST['nombre'];
    $sql = "INSERT INTO sedes (nombre) VALUES ('$_POST[nombre]')";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Sede agregada con éxito',
    ];
    echo json_encode($datos);
?>