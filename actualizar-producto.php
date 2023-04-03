<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "UPDATE productos SET codigo = '$_POST[codigo]', nombre = '$_POST[nombre]', stock = '$_POST[stock]', precio = '$_POST[precio]' WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Producto actualizado con éxito',
    ];
    echo json_encode($datos);
?>