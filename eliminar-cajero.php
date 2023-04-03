<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "DELETE FROM cajeros WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Cajero eliminado con éxito',
    ];
    echo json_encode($datos);
?>