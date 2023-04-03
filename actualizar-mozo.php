<?php
    include 'bd.php';
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $sql = "UPDATE mozos SET nombre = '$nombre' WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Mozo actualizado con éxito',
    ];
    echo json_encode($datos);
?>