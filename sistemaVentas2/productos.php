<!DOCTYPE html>
<html lang="es">
<?php 
    include_once 'components/head.php';
    include 'bd.php';
    $iniciar = ($_GET['pagina']-1)*5;
    $productos = 'SELECT * FROM productos ORDER BY id DESC  LIMIT '.$iniciar.',5';
    $totalproductos = 'SELECT * FROM productos';
    if(!$_GET){
        header('Location: productos?pagina=1');
    }
?>
<body>
<?php include_once 'components/menu.php';?>
<section class="max-container">
    <h1>Mis productos</h1>
    <br>
    <form>
        <div class="box-table" id="box-table">
            <table class="table table_id" id="tabla">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Precio</th>
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
                                <td><?php echo $row['codigo']?></td>
                                <td><?php echo $row['nombre']?></td>
                                <?php
                                    if($row['stock'] <= 5) {
                                        echo '<td><span style="display:flex; width:50px; margin:auto; font-size:1rem" class="badge text-bg-danger">'.$row['stock'].'</span></td>';
                                    } else {
                                        echo '<td><span style="display:flex; width:50px; margin:auto; font-size:1rem" class="badge text-bg-success">'.$row['stock'].'</span></td>';
                                    }
                                ?>
                                <td>S/<?php echo $row['precio']?></td>
                                <td><a onclick="abrirModalEditarProducto(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-pencil"></i></a></td>
                                <td><a onclick="abrirModalEliminarProducto(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEliminar"><i class="fa fa-close"></i></a></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
            <nav id="navegador" style="display:none" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled' : ''?>"><a class="page-link" href="productos?pagina=<?php echo $_GET['pagina']-1?>">Anterior</a></li>
                    <?php
                        for ($i = 1; $i<=$paginas; $i++) { ?>
                            <li class="page-item <?php echo $_GET['pagina']==$i ? 'active' : '' ?>"><a class="page-link" href="productos?pagina=<?php echo $i?>"><?php echo $i?></a></li>
                        <?php }
                    ?>
                    <li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled' : ''?>"><a class="page-link" href="productos?pagina=<?php echo $_GET['pagina']+1?>">Siguiente</a></li>
                </ul>
            </nav>
        </div>
        <button id="boton" type="button" class="btn btn-success btn-opcion" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar producto</button>
        <div style="margin-bottom:-3px" id="mensaje" class="alert alert-danger" role="alert">
            No tiene productos
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
                ¿Está seguro que desea eliminar el producto <b><span id="nombreProductoModalEliminar"></span></b>?
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
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Editar producto</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Código</span>
                    <input id="codigoProducto" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Nombre</span>
                    <input id="nombreProducto" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Stock</span>
                    <input id="stockProducto" value="0" type="text" class="form-control">
                    <button onclick="aumentarStockModal()" style="display:flex" class="btn btn-success" type="button"><i style="margin:auto" class='bx bx-plus'></i></button>
                    <button onclick="disminuirStockModal()" style="display:flex" class="btn btn-danger" type="button"><i style="margin:auto" class='bx bx-minus'></i></button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Precio</span>
                    <input id="precioProducto" type="text" class="form-control">
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
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Agregar producto</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Código</span>
                    <input id="codigoProductoAgregar" placeholder="Escriba aquí" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Nombre</span>
                    <input id="nombreProductoAgregar" placeholder="Escriba aquí" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Stock</span>
                    <input id="stockProductoAgregar" value="0" type="text" class="form-control">
                    <button onclick="aumentarProductoModal()" style="display:flex" class="btn btn-success" type="button"><i style="margin:auto" class='bx bx-plus'></i></button>
                    <button onclick="disminuirProductoModal()" style="display:flex" class="btn btn-danger" type="button"><i style="margin:auto" class='bx bx-minus'></i></button>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Precio</span>
                    <span class="input-group-text">S/</span>
                    <input id="precioProductoAgregar" value="0.00" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="agregarProductoModal()" id="btn-agregar" type="button" class="btn btn-success">Agregar</button>
            </div>
            </div>
        </div>
    </div>
</section>
    <script src="assets/js/script.js?1.8"></script>
</body>
</html>