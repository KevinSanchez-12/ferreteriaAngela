<?php
    include 'bd.php';
    $administrador = 'SELECT * FROM administrador';
    $resultado = mysqli_query($conexion, $administrador);
    while ($row = mysqli_fetch_assoc($resultado)) {
        $correo = $row['correo'];
        $password = $row['password'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css?1.6">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Sistema de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/70656af24f.js" crossorigin="anonymous"></script>
    <link href="assets/alertifyjs/css/alertify.css" rel="stylesheet" type="text/css"/>
    <link href="assets/alertifyjs/css/themes/default.css" rel="stylesheet" type="text/css"/>
    <script src="assets/alertifyjs/alertify.js"></script>
</head>
<body>
    <section class="login">
        <img class="logo" src="assets/img/logo.png">
        <img class="fondo" src="assets/img/banner-login.png">
        <div class="form">
            <div class="content">
                <h1>Iniciar Sesión</h1>
                <div class="input-group mb-3">
                    <span class="input-group-text">Correo</span>
                    <input onkeyup="return validarCamposParaLogueo()" id="correo" name="correo" type="text" class="form-control" placeholder="Escriba aquí">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Contraseña</span>
                    <input onkeyup="return validarCamposParaLogueo()" id="password" name="password" type="password" class="form-control" placeholder="Escriba aquí">
                    <i id="eye" style="cursor:pointer; margin:auto; padding:10px" onclick="verContrasena()" class='input-group-text fa fa-eye'></i>
                </div>
                <button id="boton" disabled onclick="login('<?php echo $correo; ?>','<?php echo $password; ?>')" type="button" class="btn btn-success">Ingresar</button>
            </div>
        </div>
    </section>
    <script src="assets/js/login.js?1.2"></script>
</body>
</html>