<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM codigosdescuento WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $codigo = $row['codigo'];
    $descuento = $row['descuento'];
    $datos = [
        'id' => $id,
        'codigo' => $codigo,
        'descuento' => $descuento,
    ];
    echo json_encode($datos);
?>