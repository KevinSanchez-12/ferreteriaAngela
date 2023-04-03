<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "UPDATE codigosdescuento SET codigo = '$_POST[codigo]', descuento = '$_POST[descuento]' WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Código actualizado con éxito',
    ];
    echo json_encode($datos);
?>