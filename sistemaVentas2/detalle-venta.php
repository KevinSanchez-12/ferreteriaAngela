<?php
    include 'bd.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM ventas WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $sqlb = "SELECT * FROM detalleventas WHERE idVenta = $row[id]";
    $resultadob = mysqli_query($conexion, $sqlb);
    $rowb = mysqli_fetch_assoc($resultadob);
    foreach ($resultadob as $producto) {
        $productos[] = $producto;
    }
    $dni = $row['dni'];
    $nombres = $row['nombres'];
    $apellidos = $row['apellidos'];
    $correo = $row['correo'];
    $celular = $row['celular'];
    $nComprobante = $row['nComprobante'];
    $fechaEmision = $row['fechaEmision'];
    $horaEmision = $row['horaEmision'];
    $vendedor = $row['vendedor'];
    $sede = $row['sede'];
    $bolsas = $row['bolsas'];
    $tipoComprobante = $row['tipoComprobante'];
    $ruc = $row['ruc'];
    $razonSocial = $row['razonSocial'];
    $direccionFiscal = $row['direccionFiscal'];
    $medioPago = $row['medioPago'];
    $pagocon = $row['pagocon'];
    $vuelto = $row['vuelto'];
    $subtotal = $row['subtotal'];
    $codigo = $row['codigo'];
    $igv = $row['igv'];
    $total = $row['total'];
    $productos = $productos;
    $datos = [
        'dni' => $dni,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'correo' => $correo,
        'celular' => $celular,
        'nComprobante' => $nComprobante,
        'fechaEmision' => $fechaEmision,
        'horaEmision' => $horaEmision,
        'vendedor' => $vendedor,
        'sede' => $sede,
        'bolsas' => $bolsas,
        'tipoComprobante' => $tipoComprobante,
        'ruc' => $ruc,
        'razonSocial' => $razonSocial,
        'direccionFiscal' => $direccionFiscal,
        'medioPago' => $medioPago,
        'pagocon' => $pagocon,
        'vuelto' => $vuelto,
        'subtotal' => $subtotal,
        'codigo' => $codigo,
        'igv' => $igv,
        'total' => $total,
        'productos' => $productos
    ];
    echo json_encode($datos);
?>