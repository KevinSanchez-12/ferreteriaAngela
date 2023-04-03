<!DOCTYPE html>
<html lang="es">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<?php
    include_once 'components/head.php';
    include 'bd.php';
    $cajeros = "SELECT * FROM cajeros";
    $sedes = "SELECT * FROM sedes";
    $ventas = "SELECT COUNT(*) FROM ventas";
    $resultadoc = mysqli_query($conexion, $ventas);
    $row = mysqli_fetch_array($resultadoc);
    $nComprobante = $row[0]+1;
?>
<body>
<?php include_once 'components/menu.php';?>
<section class="max-container">
    <h1>Registrar Venta</h1>
    <form autocomplete="off">
        <div class="controles">
            <div class="input-group">
                <span class="input-group-text">DNI</span>
                <input id="dni" onkeypress="return soloNumeros(event), validarCampos()" type="text" class="form-control" placeholder="Escriba aquí">
                <button style="align-items:center" class="btn btn btn-success" type="button" id="buscar">Buscar</button>
            </div>
            <div class="input-group">
                <span class="input-group-text">Nombres</span>
                <input id="nombres" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Apellidos</span>
                <input id="apellidos" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Correo</span>
                <input id="correo" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Celular</span>
                <input id="celular" onkeypress="return soloNumeros(event)" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">N° de comprobante</span>
                <input disabled value="<?php echo $nComprobante?>" id="nComprobante" onkeypress="return soloNumeros(event)" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Fecha de emisión</span>
                <input onchange="validarCampos()" id="fechaEmision" type="date" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Hora de emisión</span>
                <input onchange="validarCampos()" id="horaEmision" type="time" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Cajero(a)</span>
                <select onchange="validarCampos()" id="vendedor" class="form-control">
                    <option selected disabled value="">Seleccione</option>
                <?php $resultado= mysqli_query($conexion, $cajeros);
                    while($row=mysqli_fetch_assoc($resultado)){ ?>
                    <option value="<?php echo $row["nombre"];?>"><?php echo $row["nombre"];?></option>
                <?php }?>
                </select>
            </div>
            <div class="input-group">
                <span class="input-group-text">Sede</span>
                <select onchange="validarCampos()" id="sede" class="form-control">
                    <option selected disabled value="">Seleccione</option>
                <?php $resultado= mysqli_query($conexion, $sedes);
                    while($row=mysqli_fetch_assoc($resultado)){ ?>
                    <option value="<?php echo $row["nombre"];?>"><?php echo $row["nombre"];?></option>
                <?php }?>
                </select>
            </div>
        </div>
        <hr>
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
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="productos">
                </tbody>
            </table>
        </div>
        <button onclick="agregarProducto()" type="button" class="btn btn-success">Agregar producto</button>
        <hr>
        <div class="detalles-comprobante">
            <div class="input-group">
                <span class="input-group-text">Bolsas</span>
                <input disabled id="bolsas" value="0" type="text" class="form-control">
                <button onclick="aumentarBolsa()" class="btn btn-success" type="button">+</button>
                <button onclick="disminuirBolsa()" class="btn btn-danger" type="button">-</button>
            </div>
            <div class="input-group">
                <span class="input-group-text">Tipo de comprobante</span>
                <select onchange="validarComprobante(), validarCampos()" class="form-control" id="tipoComprobante">
                    <option disabled selected value="">Seleccione</option>
                    <option value="Boleta">Boleta</option>
                    <option value="Factura">Factura</option>
                </select>
            </div>
            <div class="input-group ruc">
                <span class="input-group-text">RUC</span>
                <input id="ruc" onkeypress="return soloNumeros(event);" type="text" class="form-control" placeholder="Escriba aquí">
                <button style="align-items:center" class="btn btn btn-success" type="button" id="buscarRUC">Buscar</button>
            </div>
            <div class="input-group ruc">
                <span class="input-group-text">Razón social</span>
                <input id="razonSocial" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group ruc">
                <span class="input-group-text">Dirección fiscal</span>
                <input id="direccionFiscal" type="text" class="form-control" placeholder="Escriba aquí">
            </div>
            <div class="input-group">
                <span class="input-group-text">Medio de pago</span>
                <select onchange="validarMedioPago(), validarCampos()" class="form-control" id="medioPago">
                    <option disabled selected value="">Seleccione</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                </select>
            </div>
            <div style="display:none" class="input-group efectivo">
                <span class="input-group-text">Pago con</span>
                <input onkeyup="return calcularVuelto()" id="pagocon" value="S/0.00" type="text" class="form-control">
            </div>
            <div style="display:none" class="input-group efectivo">
                <span class="input-group-text">Vuelto</span>
                <input disabled id="vuelto" value="S/0.00" type="text" class="form-control">
            </div>
            <div class="input-group">
                <span class="input-group-text">Subtotal</span>
                <input disabled id="subtotal" type="text" class="form-control" value="S/0.00">
            </div>
            <div class="input-group">
                <span class="input-group-text">Código</span>
                <input id="codigo" type="text" class="form-control" placeholder="Escriba aquí">
                <button onclick="validarCodigoDescuento()" style="align-items:center" class="btn btn btn-success" type="button">Validar</button>
            </div>
            <div class="input-group">
                <span class="input-group-text">I.G.V</span>
                <input disabled id="igv" type="text" class="form-control" value="S/0.00">
            </div>
            <div class="input-group">
                <span class="input-group-text">Total a pagar</span>
                <input disabled id="total" type="text" class="form-control" value="S/0.00">
            </div>
        </div>
        <br>
        <button disabled onclick="registrarVenta()" id="boton" type="button" class="btn btn-success btn-opcion">Registrar venta</button>
    </form>
    <div onclick="actualizarTablaProductos()" class="buscador" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <i class="fa fa-search"></i>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Mis productos</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body productos-lista">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Buscar producto</span>
                    <input type="text" class="form-control me-2 light-table-filter" placeholder="Escriba aquí" data-table="table_id">
                </div>
                <div class="box-table" id="box-table">
                    <table class="table table_id" id="tabla">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="productosModal">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</section>
    <script>
        $("#buscar").click(function(){
        var dni=$("#dni").val();
        $.ajax({           
        type:"POST",
        url: "consulta-dni.php",
        data: 'dni='+dni,
        dataType: 'json',
        success: function(data) {
            if(data.error != null){
                alertify.error("DNI no encontrado");
            }
            else{
                $("#nombres").val(data.nombres.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase()));
                $("#apellidos").val(data.apellidoPaterno.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase()) + " " + data.apellidoMaterno.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase()));
            }
        }, error: function(data) {
        }
        });
        })
        $("#buscarRUC").click(function(){
        var ruc=$("#ruc").val();
        $.ajax({           
        type:"POST",
        url: "consulta-RUC.php",
        data: 'ruc='+ruc,
        dataType: 'json',
        success: function(data) {
            if(data.error != null){
                alertify.error("RUC no encontrado");
            }
            else{
                $("#razonSocial").val(data.nombre.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase()));
                $("#direccionFiscal").val(data.direccion.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase()) + " - " + data.distrito.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase()));
            }
        }, error: function(data) {
        }
        });
        })
    </script>
    <script src="assets/js/script.js?1.2"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="assets/js/buscador.js?1.4"></script>
</body>
</html>