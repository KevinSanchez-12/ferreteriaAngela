<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "DELETE FROM codigosdescuento WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Código eliminado con éxito',
    ];
    echo json_encode($datos);
?>