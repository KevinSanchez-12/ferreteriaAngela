<!DOCTYPE html>
<html lang="es">
<?php 
    include_once 'components/head.php';
    include 'bd.php';
?>
<body>
<?php include_once 'components/menu.php';?>
<section class="max-container">
    <h1>Reporte de Ventas</h1>
    <form>
        <br>
        <div class="controles-reporte">
            <div class="input-group">
                <span class="input-group-text">Fecha desde</span>
                <input id="fechaDesde" type="date" class="form-control">
            </div>
            <div class="input-group">
                <span class="input-group-text">Fecha hasta</span>
                <input id="fechaHasta" type="date" class="form-control">
            </div>
        </div>
        <button onclick="obtenerReporte()" id="button-a" type="button" class="btn btn-success btn-opcion">Buscar y generar</button>
        <span style="margin-top:20px; margin-bottom:20px" id="btn-excel" onclick="exportarExcel()" class="badge text-bg-warning">Exportar a Excel <img src="assets/img/excel.png" class="logoExcel"></span>
        <div class="box-table" id="box-table" style="display:none; overflow: auto">
            <table class="table" id="tabla">
                <thead>
                    <tr>
                        <th scope="col">Codigo de comprobante</th>
                        <th scope="col">Fecha y hora de emision</th>
                        <th scope="col">Tipo de comprobante</th>
                        <th scope="col">Sede</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Medio de pago</th>
                        <th scope="col">Cajero(a)</th>
                        <th scope="col">Bolsas</th>
                        <th scope="col">Codigo descuento</th>
                        <th scope="col">Productos</th>
                        <th scope="col">Pago con</th>
                        <th scope="col">Vuelto</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">IGV(18%)</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody id="resultados">
                </tbody>
            </table>
        </div>
        <div id="mensaje" class="alert alert-danger" style="margin-top:20px; display:none" role="alert">
            No hay resultados
        </div>
    </form>
</section>
    <script src="assets/js/script.js?2.1"></script>
    <script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</body>
</html>