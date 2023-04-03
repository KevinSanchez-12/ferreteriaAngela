<?php
    include 'bd.php';
    $fechaDesde = $_POST['fechaDesde'];
    $fechaHasta = $_POST['fechaHasta'];
    $sql = "SELECT * FROM ventas WHERE fechaEmision BETWEEN '$fechaDesde' AND '$fechaHasta'";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    foreach ($resultado as $venta) {
        $ventas[] = $venta;
        $sqlb = "SELECT * FROM detalleventas WHERE idVenta = '$venta[id]'";
        $resultadob = mysqli_query($conexion, $sqlb);
        $rowb = mysqli_fetch_assoc($resultadob);
        foreach ($resultadob as $detalle) {
            $detalles[] = $detalle;
        }
    }
    $datos = [
        'ventas' => $ventas,
        'productos' => $detalles
    ];
    echo json_encode($datos);
?>