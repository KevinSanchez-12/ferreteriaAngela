<?php
    include 'bd.php';
    $sql = "SELECT * FROM codigosdescuento";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $datos[] = $row;
    }
    echo json_encode($datos);
?>