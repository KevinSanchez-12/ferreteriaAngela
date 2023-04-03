<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "DELETE FROM productos WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Producto eliminado con éxito',
    ];
    echo json_encode($datos);
?>