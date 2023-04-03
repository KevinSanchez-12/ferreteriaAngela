<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="max-container container-fluid">
    <a href="registrar-venta"><img class="logoMenu" src="assets/img/logo.png"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="registrar-venta">Registrar venta</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="historial-venta">Historial de ventas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="estadistica">Estadísticas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="reporte-venta">Reporte de ventas</a>
        </li>
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Administrador
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="productos">Mis productos</a></li>
            <li><a class="dropdown-item" href="codigos-descuento">Códigos de descuento</a></li>
            <li><a class="dropdown-item" href="sedes">Sedes</a></li>
            <li><a class="dropdown-item" href="cajeros">Cajeros(as)</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="perfil">Editar perfil</a></li>
          </ul>
      </div>
        <li class="nav-item closeSesion">
          <a class="nav-link" onclick="eliminarLocalStorage()">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script>
  function eliminarLocalStorage() {
      localStorage.removeItem("token");
      location.href = "index";
  }
</script>