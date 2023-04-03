<!DOCTYPE html>
<html lang="es">
<?php 
    include_once 'components/head.php';
    include 'bd.php';
    $iniciar = ($_GET['pagina']-1)*5;
    $productos = 'SELECT * FROM cajeros ORDER BY id DESC  LIMIT '.$iniciar.',5';
    $totalproductos = 'SELECT * FROM cajeros';
    if(!$_GET){
        header('Location: cajeros?pagina=1');
    }
?>
<body>
<?php include_once 'components/menu.php';?>
<section class="max-container">
    <h1>Cajeros</h1>
    <form>
        <br>
        <div class="box-table" id="box-table">
            <table class="table" id="tabla">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="productos">
                    <?php
                        $resultado = mysqli_query($conexion, $productos);
                        $resultadob = mysqli_query($conexion, $totalproductos);
                        $articulosxpagina = 5;
                        $articulodb = mysqli_num_rows($resultadob);
                        $paginas = ceil($articulodb/$articulosxpagina);
                        while ($row = mysqli_fetch_array($resultado)) { ?>
                            <tr>
                                <td><?php echo $row['nombre']?></td>
                                <td><a onclick="abrirModalEditarCajero(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-pencil"></i></a></td>
                                <td><a onclick="abrirModalEliminarCajero(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEliminar"><i class="fa fa-close"></i></a></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <nav id="navegador" style="display:none" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : ''?>"><a class="page-link" href="cajeros?pagina=<?php echo $_GET['pagina']-1?>">Anterior</a></li>
                    <?php
                        for ($i = 1; $i<=$paginas; $i++) { ?>
                            <li class="page-item <?php echo $_GET['pagina']==$i ? 'active' : '' ?>"><a class="page-link" href="productos?pagina=<?php echo $i?>"><?php echo $i?></a></li>
                        <?php }
                    ?>
                    <li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled' : ''?>"><a class="page-link" href="cajeros?pagina=<?php echo $_GET['pagina']+1?>">Siguiente</a></li>
                </ul>
            </nav>
        </div>
        <button id="boton" type="button" class="btn btn-success btn-opcion" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar cajero(a)</button>
        <div style="margin-bottom:-3px" id="mensaje" class="alert alert-danger" role="alert">
            No tiene cajeros (as)
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
                ¿Está seguro que desea eliminar al cajero(a) <b><span id="nombreCajeroModalEliminar"></span></b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button id="btn-eliminar" type="button" class="btn btn-danger">Eliminar</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Editar cajero(a)</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Nombre</span>
                    <input id="nombreCajero" type="text" class="form-control">
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
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Agregar cajero(a)</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Nombre</span>
                    <input id="nombreCajeroAgregar" placeholder="Escriba aquí" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button id="btn-agregar-cajero" onclick="agregarCajeroModal()" type="button" class="btn btn-success">Agregar</button>
            </div>
            </div>
        </div>
    </div>
</section>
    <script src="assets/js/script.js?1.4"></script>
</body>
</html>