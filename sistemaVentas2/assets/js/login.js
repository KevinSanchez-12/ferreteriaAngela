function login(correoA, passwordA) {
    var correoB = document.getElementById("correo").value;
    var passwordB = document.getElementById("password").value;
    if(correoB == "" && passwordB == ""){
        alertify.error("Ingrese sus credenciales");
    }else if(correoA != correoB || passwordA != passwordB){
        alertify.error("Credenciales incorrectas");
    }else if(correoA == correoB && passwordA == passwordB){
        window.location.href = "registrar-venta";
        crearToken();
    }
}
function crearToken() {
    var token = Math.floor(Math.random() * 1000000000);
    localStorage.setItem("token", token);
}
function obtenerLocalStorage() {
    var token = localStorage.getItem("token");
    return token;
}
function verContrasena () {
    var tipo = document.getElementById("password");
    var icono = document.getElementById("eye");
    if (tipo.type == "password") {
        tipo.type = "text";
        icono.className = "input-group-text fa fa-eye-slash";
    } else {
        tipo.type = "password";
        icono.className = "input-group-text fa fa-eye";
    }
}
function validarCamposParaLogueo() {
    var correo = document.getElementById("correo").value;
    var password = document.getElementById("password").value;
    var boton = document.getElementById("boton");
    if (correo == "" || password == "") {
        boton.disabled = true;
    }else{
        boton.disabled = false;
    }
}