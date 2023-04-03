<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "DELETE FROM sedes WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Sede eliminada con éxito',
    ];
    echo json_encode($datos);
?>