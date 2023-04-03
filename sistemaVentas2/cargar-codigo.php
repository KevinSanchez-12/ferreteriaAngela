<?php
    include 'bd.php';
    $codigo = $_POST['codigo'];
    $descuento = $_POST['descuento'];
    $sql = "INSERT INTO codigosdescuento (codigo, descuento) VALUES ('$codigo', '$descuento')";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Código agregado con éxito',
    ];
    echo json_encode($datos);
?>