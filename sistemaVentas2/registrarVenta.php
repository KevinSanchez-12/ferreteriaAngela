<?php
    $datos = $_POST['datos'];
    $dni = $_POST['datos']['dni'];
    $nombres = $_POST['datos']['nombres'];
    $apellidos = $_POST['datos']['apellidos'];
    $correo = $_POST['datos']['correo'];
    $celular = $_POST['datos']['celular'];
    $nComprobante = $_POST['datos']['nComprobante'];
    $fechaEmision = $_POST['datos']['fechaEmision'];
    $horaEmision = $_POST['datos']['horaEmision'];
    $vendedor = $_POST['datos']['vendedor'];
    $sede = $_POST['datos']['sede'];
    $bolsas = $_POST['datos']['bolsas'];
    $tipoComprobante = $_POST['datos']['tipoComprobante'];
    $ruc = $_POST['datos']['ruc'];
    $razonSocial = $_POST['datos']['razonSocial'];
    $direccionFiscal = $_POST['datos']['direccionFiscal'];
    $medioPago = $_POST['datos']['medioPago'];
    $pagocon = $_POST['datos']['pagocon'];
    $vuelto = $_POST['datos']['vuelto'];
    $subtotal = $_POST['datos']['subtotal'];
    $codigoDescuento = $_POST['datos']['codigoDescuento'];
    $igv = $_POST['datos']['igv'];
    $total = $_POST['datos']['total'];
    $productos = $_POST['datos']['productos'];
    include 'bd.php';
    $sql = "INSERT INTO ventas (dni, nombres, apellidos, correo, celular, nComprobante, fechaEmision, horaEmision, vendedor, sede, bolsas, tipoComprobante, ruc, razonSocial, direccionFiscal, medioPago, pagocon, vuelto, subtotal, codigo, igv, total) VALUES ('$dni', '$nombres', '$apellidos', '$correo', '$celular', '$nComprobante', '$fechaEmision', '$horaEmision', '$vendedor', '$sede', '$bolsas', '$tipoComprobante', '$ruc', '$razonSocial', '$direccionFiscal', '$medioPago', '$pagocon', '$vuelto', '$subtotal', '$codigoDescuento', '$igv', '$total')";
    $resultado = mysqli_query($conexion, $sql);
    $sql = "SELECT * FROM ventas ORDER BY id DESC LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_object($resultado);
    $idVenta = $row->id;
    foreach ($productos as $producto) {
        $idProducto = $producto['id'];
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];
        $codigo = $producto['codigo'];
        $nombre = $producto['nombre'];
        $total = $producto['total'];
        $sqlb = "INSERT INTO detalleventas (idVenta, idProducto, codigo, nombre, precio, cantidad, total) 
        VALUES ('$idVenta', '$idProducto', '$codigo', '$nombre', '$precio', '$cantidad', '$total')";
        $resultadob = mysqli_query($conexion, $sqlb);
        $sqlc = "UPDATE productos SET stock = stock - '$cantidad' WHERE codigo = '$codigo'";
        $resultadoc = mysqli_query($conexion, $sqlc);
    }
?>