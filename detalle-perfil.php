<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM administrador WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $correo = $row['correo'];
    $password = $row['password'];
    $datos = [
        'id' => $id,
        'correo' => $correo,
        'password' => $password,
    ];
    echo json_encode($datos);
?>