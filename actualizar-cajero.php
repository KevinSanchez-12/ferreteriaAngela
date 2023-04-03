<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "UPDATE cajeros SET nombre = '$_POST[nombre]' WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Cajero actualizado con éxito',
    ];
    echo json_encode($datos);
?>