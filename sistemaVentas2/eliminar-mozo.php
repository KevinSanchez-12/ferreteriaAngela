<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "DELETE FROM mozos WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Mozo eliminado con éxito',
    ];
    echo json_encode($datos);
?>