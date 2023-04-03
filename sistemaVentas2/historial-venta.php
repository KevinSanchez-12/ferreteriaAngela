<!DOCTYPE html>
<html lang="es">
<?php
include_once 'components/head.php';
include 'bd.php';
$iniciar = ($_GET['pagina']-1)*5;
$ventas = 'SELECT * FROM ventas ORDER by fechaEmision DESC, horaEmision DESC LIMIT '.$iniciar.',5';
$totalventas = 'SELECT * FROM ventas';
$indice = 0;;
if(!$_GET){
    header('Location: historial-venta?pagina=1');
}
?>
<body>
<?php include_once 'components/menu.php'; ?>
<section class="max-container">
    <h1>Historial de Ventas</h1>
    <form>
        <br>
        <div class="box-table">
            <table class="table" id="tabla">
                <thead>
                    <tr>
                    <th scope="col">Código de comprobante</th>
                    <th scope="col">Fecha y hora de emisión</th>
                    <th scope="col">Tipo de comprobante</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Medio de pago</th>
                    <th scope="col">Total</th>
                    <th scope="col">Ver detalle</th>
                    <th scope="col">Descargar comprobante</th>
                    <th scope="col">Imprimir comprobante</th>
                    </tr>
                </thead>
                <tbody id="productos">
                    <?php
                    $resultado = mysqli_query($conexion, $ventas);
                    $resultadob = mysqli_query($conexion, $totalventas);
                    $articulosxpagina = 5;
                    $articulodb = mysqli_num_rows($resultadob);
                    $paginas = ceil($articulodb / $articulosxpagina);
                    while ($row = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?php echo $row['nComprobante']; ?></td>
                            <td><?php echo date(
                                'd-m-Y',
                                strtotime($row['fechaEmision'])
                            ) .
                                ' ' .
                                $row['horaEmision']; ?></td>
                            <td><?php echo $row['tipoComprobante']; ?></td>
                            <td><?php echo $row['nombres'] .
                                ' ' .
                                $row['apellidos']; ?></td>
                            <td><?php echo $row['medioPago']; ?></td>
                            <td>S/<?php echo $row['total']; ?></td>
                            <td><i data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="verDetalle(<?php echo $row[
                                'id'
                            ]; ?>)" class="fa fa-eye"></i></td>
                            <td><a download="Ticket" href="ticket?id=<?php echo $row['id']?>"><i class="fa fa-download"></i></a></td>
                            <td><i class="fa fa-print"></i></td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            <nav id="navegador" style="display:none" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : ''?>"><a class="page-link" href="historial-venta?pagina=<?php echo $_GET['pagina']-1?>">Anterior</a></li>
                    <?php
                        for ($i = 1; $i<=$paginas; $i++) { ?>
                            <li class="page-item <?php echo $_GET['pagina']==$i ? 'active' : '' ?>"><a class="page-link" href="historial-venta?pagina=<?php echo $i?>"><?php echo $i?></a></li>
                        <?php }
                    ?>
                    <li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled' : ''?>"><a class="page-link" href="historial-venta?pagina=<?php echo $_GET['pagina']+1?>">Siguiente</a></li>
                </ul>
            </nav>
        </div>
        <div id="mensaje" class="alert alert-danger" role="alert">
            No hay registros
        </div>
        <?php if (mysqli_num_rows($resultado) == 0) {
            echo '<script>document.getElementById("mensaje").style.display = "block";</script>';
            echo '<script>document.getElementById("navegador").style.display = "none";</script>';
        } else {
            echo '<script>document.getElementById("mensaje").style.display = "none";</script>';
            echo '<script>document.getElementById("navegador").style.display = "block";</script>';
        } ?>
    </form>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Detalle de venta</b></h2>
                <button onclick="cerrarDetalle()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Datos del cliente</b></p>
                <div class="controles"> 
                    <div class="input-group">
                        <span class="input-group-text">DNI</span>
                        <input disabled id="dni" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Nombres</span>
                        <input disabled id="nombres" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Apellidos</span>
                        <input disabled id="apellidos" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Correo</span>
                        <input disabled id="correo" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Celular</span>
                        <input disabled id="celular" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">N° de comprobante</span>
                        <input disabled id="nComprobante" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Fecha de emisión</span>
                        <input disabled id="fechaEmision" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Hora de emisión</span>
                        <input disabled id="horaEmision" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Cajero(a)</span>
                        <input disabled id="vendedor" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Sede</span>
                        <input disabled id="sede" type="text" class="form-control">
                    </div>
                </div>
                <p style="margin-top:15px"><b>Productos</b></p>
                <div class="box-table">
                    <table class="table" id="tabla">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Código</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody id="productosTabla">
                        </tbody>
                    </table>
                </div>
                <p style="margin-top:15px"><b>Datos del comprobante</b></p>
                <div class="detalles-comprobante">
                    <div class="input-group">
                        <span class="input-group-text">Bolsas</span>
                        <input disabled id="bolsas" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Tipo de comprobante</span>
                        <input disabled id="tipoComprobante" type="text" class="form-control">
                    </div>
                    <div class="input-group ruc">
                        <span class="input-group-text">RUC</span>
                        <input disabled id="ruc" type="text" class="form-control">
                    </div>
                    <div class="input-group ruc">
                        <span class="input-group-text">Razón social</span>
                        <input disabled id="razonSocial" type="text" class="form-control">
                    </div>
                    <div class="input-group ruc">
                        <span class="input-group-text">Dirección fiscal</span>
                        <input disabled id="direccionFiscal" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Medio de pago</span>
                        <input disabled id="medioPago" type="text" class="form-control">
                    </div>
                    <div class="input-group efectivo">
                        <span class="input-group-text">Pago con</span>
                        <input disabled id="pagocon" type="text" class="form-control">
                    </div>
                    <div class="input-group efectivo">
                        <span class="input-group-text">Vuelto</span>
                        <input disabled id="vuelto" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Subtotal</span>
                        <input disabled id="subtotal" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Código de descuento</span>
                        <input disabled id="codigoDescuento" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">I.G.V</span>
                        <input disabled id="igv" type="text" class="form-control">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Total a pagar</span>
                        <input disabled id="total" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarDetalle()" type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
</section>
    <script src="assets/js/script.js?1.6"></script>
</body>
</html>