<?php
    include 'bd.php';
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $sql = "INSERT INTO productos (codigo, nombre, stock, precio) VALUES ('$codigo', '$nombre', '$stock' , '$precio')";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Producto agregado con éxito',
    ];
    echo json_encode($datos);
?>