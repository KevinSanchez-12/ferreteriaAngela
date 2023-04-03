<?php
    include 'bd.php';
    $id = $_POST['id'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $sql = "UPDATE administrador SET correo = '$correo', password = '$password' WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $datos = [
        'success' => true,
        'message' => 'Perfil actualizado con éxito',
    ];
    echo json_encode($datos);
?>