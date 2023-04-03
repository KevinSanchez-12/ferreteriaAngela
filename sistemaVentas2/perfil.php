<!DOCTYPE html>
<html lang="es">
<?php 
    include_once 'components/head.php';
    include 'bd.php';
    $administrador = 'SELECT * FROM administrador';
?>
<body>
<?php include_once 'components/menu.php';?>
<section class="max-container">
    <h1>Editar perfil</h1>
    <form>
        <br>
        <div class="box-table" id="box-table">
            <table class="table" id="tabla">
                <thead>
                    <tr>
                        <th scope="col">Correo</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody id="productos">
                    <?php
                        $resultado = mysqli_query($conexion, $administrador);
                        while ($row = mysqli_fetch_array($resultado)) { ?>
                            <tr>
                                <td><?php echo $row['correo']?></td>
                                <td><?php echo $row['password']?></td>
                                <td><a onclick="abrirModalEditarPerfil(<?php echo $row['id']?>)" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="staticBackdropLabel"><b>Editar perfil</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text">Correo</span>
                    <input id="correoPerfil" type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Contraseña</span>
                    <input id="passwordPerfil" type="text" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ligth" data-bs-dismiss="modal">Cancelar</button>
                <button id="btn-actualizar" type="button" class="btn btn-success">Actualizar</button>
            </div>
            </div>
        </div>
    </div>
</section>
    <script src="assets/js/script.js?1.4"></script>
</body>
</html>