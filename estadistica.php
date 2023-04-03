<!DOCTYPE html>
<html lang="en">
<?php 
    include_once 'components/head.php';
    include 'bd.php';
    $sql = "SELECT COUNT(*) FROM ventas";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $ventas = $row[0];
    $sql = "SELECT *, SUM(cantidad) AS cantidad FROM detalleVentas";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $detalleVentas = $row['cantidad'];
    $sql = "SELECT COUNT(*) FROM cajeros";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $cajeros = $row[0];
    $sql = "SELECT COUNT(*) FROM ventas WHERE tipoComprobante = 'Boleta'";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $boletas = $row[0];
    $sql = "SELECT COUNT(*) FROM ventas WHERE tipoComprobante = 'Factura'";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $facturas = $row[0];
    $sql = "SELECT COUNT(*) FROM sedes";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $sedes = $row[0];
    $sql = "SELECT COUNT(*) FROM codigosdescuento";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $codigos = $row[0];
    $sql = "SELECT COUNT(*) FROM productos";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $productos = $row[0];
    $sql = "SELECT COUNT(*) FROM productos WHERE stock > 0";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_array($result);
    $productosDisponibles = $row[0];
    $sql = "SELECT *, SUM(cantidad) AS cantidad FROM detalleVentas GROUP BY idProducto ORDER BY cantidad DESC LIMIT 5";
    $result = mysqli_query($conexion, $sql);
    $productosMasVendidos = array();
    $nombresMasVendidos = array();
    while($row = mysqli_fetch_array($result)){
        array_push($productosMasVendidos, $row['cantidad']. "-" . $row['nombre']);
    }
    $sql = "SELECT * FROM detalleVentas GROUP BY idProducto ORDER BY cantidad DESC LIMIT 5";
    $result = mysqli_query($conexion, $sql);
    $nombresProductos = array();
    while($row = mysqli_fetch_array($result)){
        array_push($nombresProductos, $row['nombre']);
    }
    foreach($productosMasVendidos as $producto){
         $nombres[] = explode("-", $producto)[1];
         $cantidad[] = explode("-", $producto)[0];
    }
    $sql = "SELECT * FROM productos WHERE stock < 5 ORDER BY stock ASC LIMIT 5";
    $result = mysqli_query($conexion, $sql);
    $productosMenosStock = array();
    $nombresMenosStock = array();
    while($row = mysqli_fetch_array($result)){
        array_push($productosMenosStock, $row['stock']. "-" . $row['nombre']);
    }
    foreach($productosMenosStock as $producto){
         $nombresStock[] = explode("-", $producto)[1];
         $cantidadStock[] = explode("-", $producto)[0];
    }
?>
<body>
    <?php include_once 'components/menu.php';?>
    <section class="max-container">
        <h1>Estadísticas</h1>
        <div class="estadistica">
            <div class="column-a">
                <div class="item">
                    <h2>Ventas realizadas</h2>
                    <span><?php echo $ventas?></span>
                </div>
                <div class="item">
                    <h2>Productos vendidos</h2>
                    <span><?php echo $detalleVentas?></span>
                </div>
                <div class="item">
                    <h2>Productos registrados</h2>
                    <span><?php echo $productos?></span>
                </div>
                <div class="item">
                    <h2>Sedes</h2>
                    <span><?php echo $sedes?></span>
                </div>
            </div>
            <div class="column-b">
                <div class="item">
                    <h2>Productos más vendidos</h2>
                    <div>
                        <canvas class="diagrama" id="myChart"></canvas>
                    </div>
                </div>
                <div class="item">
                    <h2>Productos con menos stock</h2>
                    <div>
                        <canvas class="diagrama" id="myChartCircular"></canvas>
                    </div>
                </div>
            </div>
            <div class="column-c">
                <div class="item">
                    <h2>Cajeros activos</h2>
                    <span><?php echo $cajeros?></span>
                </div>
                <div class="item">
                    <h2>Códigos promocionales</h2>
                    <span><?php echo $codigos?></span>
                </div>
                <div class="item">
                    <h2>Productos con stock</h2>
                    <span><?php echo $productosDisponibles?></span>
                </div>
                <div class="item">
                    <h2>Boletas/Facturas</h2>
                    <span><?php echo $boletas?>/<?php echo $facturas?></span>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: <?php echo json_encode($nombres);?>,
            datasets: [{
                label: 'Cantidad',
                data: <?php echo json_encode($cantidad);?>,
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
        const ctxCircular = document.getElementById('myChartCircular');
        new Chart(ctxCircular, {
            type: 'doughnut',
            data: {
            labels: <?php echo json_encode($nombresStock);?>,
            datasets: [{
                label: 'Cantidad',
                data: <?php echo json_encode($cantidadStock);?>,
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    </script>
</body>
</html>