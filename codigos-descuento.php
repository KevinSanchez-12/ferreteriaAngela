<!DOCTYPE html>
<html lang="es">
<?php 
    include_once 'components/head.php';
    include 'bd.php';
    $iniciar = ($_GET['pagina']-1)*10;
    $codigos = 'SELECT * FROM codigosdescuento ORDER BY id DESC LIMIT '.$iniciar.',10';
    $totalcodigos = 'SELECT * FROM codigosdescuento';
    if(!$_GET){
        header('Location: codigos-descuento?pagina=1');
    }
?>
<body>
<?php include_once 'components/menu.php';?>
<section class="max-container">
    <h1>Códigos de Descuento</h1>
    <form>
        <br>
        <div class="box-table" id="box-table" style="">
            <table class="table" id="tabla">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Descuento</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="codigos">
                    <?php
                        $resultado = mysqli_query($conexion, $codigos);
                        $resultadob = mysqli_query($conexion, $totalcodigos);
                        $articulosxpagina = 10;
                        $articulodb = mysqli_num_rows($resultadob);
                        $paginas = ceil($articulodb/$articulosxpagina);
                        while ($row = mysqli_fetch_array($resultado)) { ?>
                            <tr>
                                <td><?php echo $row['codigo']?></td>
                                <td><?php echo $row['descuento']?>%</td>
                                <td><a onclick="abrirModalEditarCodigo(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-pencil"></i></a></td>
                                <td><a onclick="abrirModalEliminarCodigo(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEliminar"><i class="fa fa-close"></i></a></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <nav id="navegador" style="display:none" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : ''?>"><a class="page-link" href="codigos-descuento?pagina=<?php echo $_GET['pagina']-1?>">Anterior</a></li>
                    <?php
                        for ($i = 1; $i<=$paginas; $i++) { ?>
                            <li class="page-item <?php echo $_GET['pagina']==$i ? 'active' : '' ?>"><a class="page-link" href="codigos-descuento?pagina=<?php echo $i?>"><?php echo $i?></a></li>
                        <?php }
                    ?>
                    <li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled' : ''?>"><a class="page-link" href="codigos-descuento?pagina=<?php echo $_GET['pagina']+1?>">Siguiente</a></li>
                </ul>
            </nav>
        </div>
        <button id="boton" type="button" class="btn btn-success btn-opcion" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar código</button>
        <div style="margin-bottom:-3px" id="mensaje" class="alert alert-danger" role="alert">
            No tiene códigos de descuento
        </div>
        <?php if (mysqli_num_rows($resultado) == 0) {
            echo '<script>document.getElementById("mensaje").style.display = "block";</script>';
            echo '<script>document.getElementById("navegador").style.display = "none";</script>';
        } else {
            echo '<script>document.getElementById("mensaje").style.display = "none";</script>';
            echo '<script>document.getElementById("navegador").style.display = "block";</script>';
        } ?>
    </form>
    <div class="modal fade" id="modalEliminar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Advertencia</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar el código <b><span id="nombreCodigoModalEliminar"></span></b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button id="btn-eliminarCodigo" type="button" class="btn btn-danger">Eliminar</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Editar código</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Código</span>
                    <input id="codigoCodigo" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Descuento</span>
                    <input id="descuentoCodigo" type="text" class="form-control">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button id="btn-actualizar" type="button" class="btn btn-success">Actualizar</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAgregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Agregar código</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Código</span>
                    <input id="codigoCodigoAgregar" placeholder="Escriba aquí" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Descuento</span>
                    <input id="descuentoCodigoAgregar" value="0" type="text" class="form-control">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button id="btn-agregar-codigo" onclick="agregarCodigoModal()" type="button" class="btn btn-success">Agregar</button>
            </div>
            </div>
        </div>
    </div>
</section>
    <script src="assets/js/script.js"></script>
</body>
</html>