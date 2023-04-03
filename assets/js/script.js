validarToken();
traerProductos();
traerCodigos();
function validarToken(){
    var token = localStorage.getItem("token");
    if(token == null){
        window.location.href = "index";
    }
}
function traerProductos(){
    productosNuevos = $.ajax({
        type: "GET",
        url: "traer-productos.php",
        dataType: 'json',
        async: false,
        success: function (response) {
            return response;
        }
    })
}
function traerCodigos(){
    codigosNuevos = $.ajax({
        type: "GET",
        url: "traer-codigos.php",
        dataType: 'json',
        async: false,
        success: function (response) {
            return response;
        }
    })
}
var arrayProductos = productosNuevos.responseJSON;
var arrayCodigos = codigosNuevos.responseJSON;
function validarComprobante() {
    var comprobante = document.getElementById('tipoComprobante');
    var comprobanteValue = comprobante.value;
    var ruc = document.getElementsByClassName('ruc');
    if (comprobanteValue == "Boleta") {
        ruc[0].style.display = "none";
        ruc[1].style.display = "none";
        ruc[2].style.display = "none";
        document.getElementById('ruc').value = "";
        document.getElementById('razonSocial').value = "";
        document.getElementById('direccionFiscal').value = "";
    }else {
        ruc[0].style.display = "flex";
        ruc[1].style.display = "flex";
        ruc[2].style.display = "flex";
    }
}
function validarMedioPago(){
    var medioPago = document.getElementById('medioPago').value;
    var efectivo = document.getElementsByClassName('efectivo');
    if(medioPago == "Efectivo"){
        efectivo[0].style.display = "flex";
        efectivo[1].style.display = "flex";
    }else{
        efectivo[0].style.display = "none";
        efectivo[1].style.display = "none";
        document.getElementById('pagocon').value = "S/ 0.00";
        document.getElementById('vuelto').value = "S/ 0.00";
    }
}
function soloNumeros(e){
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
}
function soloLetras(e){
    var key = window.Event ? e.which : e.keyCode
    return (key >= 65 && key <= 90) || (key >= 97 && key <= 122)
}
var productos = [];
function agregarProducto(){
    if(productos.length > 0){
        if(!validarCamposVacios(productos)){
            return;
        }
    }
    productos.push(
        {
            id: productos.length+1,
            codigo: "",
            nombre: "",
            precio: 0,
            cantidad: 1,
            total: 0
        }
    )
    for(i=0; i<productos.length; i++){
        if(productos[i].id == productos.length){
            document.getElementById('productos').insertRow(-1).innerHTML = '<td>'+productos[i].id+'</td><td><div style="max-width:350px !important; margin:auto" class="input-group"><span class="input-group-text">Código</span><input value="'+productos[i].codigo+'" id="codigoProducto'+productos[i].id+'" style="max-width:200px !important" type="text" class="form-control" placeholder="Escriba aquí"><button onclick="buscarProducto('+productos[i].id+')" style="align-items:center" class="btn btn btn-success" type="button" id="buscar'+productos[i].id+'">Buscar</button></div></td><td><span id="nombreProducto'+productos[i].id+'"></span></td><td><span id="precioProducto'+productos[i].id+'"></span></td><td><div style="max-width:200px !important; margin:auto" class="input-group"><input disabled id="numero'+productos[i].id+'" type="text" class="form-control" value="1"><button onclick="aumentarCantidad('+productos[i].id+')" style="align-items:center" class="btn btn btn-success" type="button">+</button><button onclick="disminuirCantidad('+productos[i].id+')" style="align-items:center" class="btn btn btn-danger" type="button">-</button></div></td><td><span id="totalProducto'+productos[i].id+'"></span></td><td><i onclick="eliminarProductov(this, '+productos[i].id+')" class="fa fa-close"></i></td>';
            validarCampos();
        }
    }
}
function buscarProducto(i) {
    if(document.getElementById('codigoProducto'+i).value == ""){
        alertify.error("Ingrese un código");
        return;
    }else{
        for(const producto of arrayProductos){
            if(producto.codigo == document.getElementById('codigoProducto'+i).value && producto.stock > 0){
                var codigoX = producto.codigo;
                var nombreX = producto.nombre;
                var precioX = producto.precio;
                document.getElementById('nombreProducto'+i).innerHTML = nombreX;
                document.getElementById('precioProducto'+i).innerHTML = "S/"+(parseFloat(precioX)).toFixed(2);
                document.getElementById('totalProducto'+i).innerHTML = "S/"+(parseFloat(precioX)).toFixed(2);
                document.getElementById('buscar'+i).disabled = true;
                document.getElementById('codigoProducto'+i).disabled = true;
                productos.forEach((producto) => {
                    if(producto.id == i){
                        producto.codigo = codigoX;
                        producto.nombre = nombreX;
                        producto.precio = precioX;
                        producto.total = precioX;
                        producto.cantidad = 1;
                    }
                    calcularSubTotal();
                })
                return;
            }else if(producto.codigo == document.getElementById('codigoProducto'+i).value && producto.stock == 0){
                alertify.error("No hay stock suficiente de " + producto.nombre);
                return;
            }
        }
        alertify.error("No se encontró el producto");
    }
}
function aumentarCantidad(i) {
    productos.forEach((producto) => {
        if(producto.id == i){
            arrayProductos.forEach((productob) => {
                if(productob.codigo == producto.codigo){
                    if(productob.stock > producto.cantidad){
                        var cantidad = document.getElementById('numero'+i).value;
                        cantidad++;
                        document.getElementById('numero'+i).value = cantidad;
                        document.getElementById('totalProducto'+i).innerHTML = "S/"+(parseFloat(producto.precio) * cantidad).toFixed(2);
                        producto.total = (producto.precio * cantidad).toFixed(2);
                        producto.cantidad = cantidad;
                    }else{
                        alertify.error("No hay stock suficiente, solo hay "+productob.stock+" unidades de " + productob.nombre);
                    }
                }
            })
        }
    })
    calcularSubTotal();
}
function disminuirCantidad(i) {
    productos.forEach((producto) => {
        if(producto.id == i){
            var cantidad = document.getElementById('numero'+i).value;
            if(cantidad > 1){
                cantidad--;
                document.getElementById('numero'+i).value = cantidad;
                document.getElementById('totalProducto'+i).innerHTML = "S/"+(parseFloat(producto.precio) * cantidad).toFixed(2);
                producto.total = (producto.precio * cantidad).toFixed(2);
                producto.cantidad = cantidad;
            }
        }
    })
    calcularSubTotal();
}
function validarCamposVacios(productos){
    for (const producto of productos) {
        if(producto.nombre == ""){
            return false;
        }
    }
    return true;
}
function upto(el, tagName){
    tagName = tagName.toLowerCase();
    while (el && el.parentNode){
        el = el.parentNode;
        if (el.tagName && el.tagName.toLowerCase() == tagName){
            return el;
        }
    }
    return null;
}
function eliminarProductov(el, i){
    productos.forEach((producto) => {
        if(producto.id == i){
            var index = productos.indexOf(producto);
            productos.splice(index, 1);
            var tr = upto(el, 'tr');
            if (tr){
                var tbody = tr.parentNode;
                tbody.removeChild(tr);
            }
        }
    })
    calcularSubTotal();
    validarCampos();
}
function calcularSubTotal(){
    var subtotal = 0;
    var igv = 0;
    var total = 0;
    productos.forEach((producto) => {
        subtotal += parseFloat(producto.total);
        igv = subtotal * 0.18;
        total = subtotal + igv;
    })
    document.getElementById('subtotal').value = "S/"+subtotal.toFixed(2);
    document.getElementById('igv').value = "S/"+igv.toFixed(2);
    document.getElementById('total').value = "S/"+total.toFixed(2);
}
function calcularVuelto(){
    var vuelto = 0;
    var pagocon = document.getElementById('pagocon').value;
    var total = document.getElementById('total').value;
    pagocon = pagocon.replace("S/", "");
    total = total.replace("S/", "");
    vuelto = parseFloat(pagocon) - parseFloat(total);
    document.getElementById('vuelto').value = "S/"+vuelto.toFixed(2);
}
var contador = 0;
function validarCodigoDescuento(){
    var codigo = document.getElementById('codigo').value;
    var descuento = 0;
    var total = 0;
    if(codigo == ""){
        alertify.error("Ingrese un código");
        return;
    }
    arrayCodigos.forEach((descuento) => {
        if(descuento.codigo == codigo){
            if(contador == 0){
                contador++;
                document.getElementById('codigo').disabled = true;
                descuento = descuento.descuento;
                total = document.getElementById('total').value;
                total = total.replace("S/", "");
                total = parseFloat(total) - (parseFloat(total) * parseFloat(descuento) / 100);
                document.getElementById('total').value = "S/"+total.toFixed(2);
                alertify.success("Código de descuento aplicado");
            }else{
                alertify.error("Ya se aplicó un código de descuento");
            }
        }
    })
}
function validarCampos() {
    var boton = document.getElementById('boton');
    var dni = document.getElementById('dni').value;
    var nombres = document.getElementById('nombres').value;
    var apellidos = document.getElementById('apellidos').value;
    var fechaEmision = document.getElementById('fechaEmision').value;
    var horaEmision = document.getElementById('horaEmision').value;
    var vendedor = document.getElementById('vendedor').value;
    var sede = document.getElementById('sede').value;
    var tipoComprobante = document.getElementById('tipoComprobante').value;
    var medioPago = document.getElementById('medioPago').value;
    if(productos.length > 0 && dni != "" && nombres != "" && apellidos != "" && fechaEmision != "" && horaEmision != "" && vendedor != "" && sede != "" && tipoComprobante != "" && medioPago != ""){
        boton.disabled = false;
    }else{
        boton.disabled = true;
    }
}
function registrarVenta(){
    var dni = document.getElementById('dni').value;
    var nombres = document.getElementById('nombres').value;
    var apellidos = document.getElementById('apellidos').value;
    var correo = document.getElementById('correo').value;
    var celular = document.getElementById('celular').value;
    var nComprobante = document.getElementById('nComprobante').value;
    var fechaEmision = document.getElementById('fechaEmision').value;
    var horaEmision = document.getElementById('horaEmision').value;
    var vendedor = document.getElementById('vendedor').value;
    var sede = document.getElementById('sede').value;
    var bolsas = document.getElementById('bolsas').value;
    var tipoComprobante = document.getElementById('tipoComprobante').value;
    var ruc = document.getElementById('ruc').value;
    var razonSocial = document.getElementById('razonSocial').value;
    var direccionFiscal = document.getElementById('direccionFiscal').value;
    var medioPago = document.getElementById('medioPago').value;
    var pagocon = document.getElementById('pagocon').value;
    var vuelto = document.getElementById('vuelto').value;
    var subtotal = document.getElementById('subtotal').value;
    var codigoDescuento = document.getElementById('codigo').value;
    var igv = document.getElementById('igv').value;
    var total = document.getElementById('total').value;
    var datos = {
        dni: dni,
        nombres: nombres,
        apellidos: apellidos,
        correo: correo,
        celular: celular,
        nComprobante: nComprobante,
        fechaEmision: fechaEmision,
        horaEmision: horaEmision,
        vendedor: vendedor,
        sede: sede,
        bolsas: bolsas,
        tipoComprobante: tipoComprobante,
        ruc: ruc,
        razonSocial: razonSocial,
        direccionFiscal: direccionFiscal,
        medioPago: medioPago,
        pagocon: pagocon,
        vuelto: vuelto,
        subtotal: subtotal.replace("S/", ""),
        codigoDescuento: codigoDescuento,
        igv: igv.replace("S/", ""),
        total: total.replace("S/", ""),
        productos: productos
    }
    $.ajax({
        type: "POST",
        url: "registrarVenta.php",
        dataType: 'json',
        data: {
            datos: datos
        }, error: function () {
            vaciarCampos();
            traerProductos();
            arrayProductos = productosNuevos.responseJSON;
            document.getElementById('nComprobante').value = parseInt(nComprobante)+1;
            alertify.success("Venta registrada");
        }
    })
}
function vaciarCampos(){
    document.getElementById('dni').value = "";
    document.getElementById('nombres').value = "";
    document.getElementById('apellidos').value = "";
    document.getElementById('correo').value = "";
    document.getElementById('celular').value = "";
    document.getElementById('nComprobante').value = "";
    document.getElementById('fechaEmision').value = "";
    document.getElementById('horaEmision').value = "";
    document.getElementById('vendedor').value = "";
    document.getElementById('sede').value = "";
    document.getElementById('bolsas').value = 0;
    document.getElementById('tipoComprobante').value = "";
    document.getElementById('ruc').value = "";
    document.getElementById('razonSocial').value = "";
    document.getElementById('direccionFiscal').value = "";
    document.getElementById('medioPago').value = "";
    document.getElementById('pagocon').value = "S/0.00";
    document.getElementById('vuelto').value = "S/0.00";
    document.getElementById('subtotal').value = "S/0.00";
    document.getElementById('codigo').value = "";
    document.getElementById('igv').value = "S/0.00";
    document.getElementById('total').value = "S/0.00";
    document.getElementById('codigo').disabled = false;
    contador = 0;
    document.getElementById('productos').innerHTML = "";
    productos = [];
    document.getElementsByClassName('ruc')[0].style.display = "none";
    document.getElementsByClassName('ruc')[1].style.display = "none";
    document.getElementsByClassName('ruc')[2].style.display = "none";
    document.getElementsByClassName('efectivo')[0].style.display = "none";
    document.getElementsByClassName('efectivo')[1].style.display = "none";
    document.getElementById('boton').disabled = true;
}
function verDetalle(i){
    $.ajax({
        type: "POST",
        url: "detalle-venta.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('dni').value = data.dni;
            document.getElementById('nombres').value = data.nombres;
            document.getElementById('apellidos').value = data.apellidos;
            document.getElementById('correo').value = data.correo;
            document.getElementById('celular').value = data.celular;
            document.getElementById('nComprobante').value = data.nComprobante;
            document.getElementById('fechaEmision').value = data.fechaEmision.split("-").reverse().join("-");
            document.getElementById('horaEmision').value = data.horaEmision;
            document.getElementById('vendedor').value = data.vendedor;
            document.getElementById('sede').value = data.sede;
            document.getElementById('bolsas').value = data.bolsas;
            document.getElementById('tipoComprobante').value = data.tipoComprobante;
            document.getElementById('ruc').value = data.ruc;
            document.getElementById('razonSocial').value = data.razonSocial;
            document.getElementById('direccionFiscal').value = data.direccionFiscal;
            if(document.getElementById('ruc').value != ""){
                document.getElementsByClassName('ruc')[0].style.display = "flex";
                document.getElementsByClassName('ruc')[1].style.display = "flex";
                document.getElementsByClassName('ruc')[2].style.display = "flex";
            }else{
                document.getElementsByClassName('ruc')[0].style.display = "none";
                document.getElementsByClassName('ruc')[1].style.display = "none";
                document.getElementsByClassName('ruc')[2].style.display = "none";
            }
            document.getElementById('medioPago').value = data.medioPago;
            if(document.getElementById('medioPago').value == "Efectivo"){
                document.getElementsByClassName('efectivo')[0].style.display = "flex";
                document.getElementsByClassName('efectivo')[1].style.display = "flex";
            }else{
                document.getElementsByClassName('efectivo')[0].style.display = "none";
                document.getElementsByClassName('efectivo')[1].style.display = "none";
            }
            
            document.getElementById('pagocon').value = data.pagocon;
            document.getElementById('vuelto').value = data.vuelto;
            document.getElementById('subtotal').value = "S/"+data.subtotal;
            document.getElementById('codigoDescuento').value = data.codigo;
            document.getElementById('igv').value = "S/"+data.igv;
            document.getElementById('total').value = "S/"+data.total;
            var productos = data.productos;
            for(i=0; i<productos.length; i++){
                document.getElementById('productosTabla').insertRow(-1).innerHTML = '<td>'+productos[i].idProducto+'</td><td>'+productos[i].codigo+'</td><td><span>'+productos[i].nombre+'</span></td><td><span>S/'+productos[i].precio+'</span></td><td>'+productos[i].cantidad+'</td><td><span>S/'+productos[i].total+'</span></td>';
            }
        }
    ); 
}
function cerrarDetalle(){
    $('#dni').empty();
    $('#nombres').empty();
    $('#apellidos').empty();
    $('#correo').empty();
    $('#celular').empty();
    $('#nComprobante').empty();
    $('#fechaEmision').empty();
    $('#horaEmision').empty();
    $('#vendedor').empty();
    $('#sede').empty();
    $('#tipoComprobante').empty();
    $('#ruc').empty();
    $('#razonSocial').empty();
    $('#direccionFiscal').empty();
    $('#medioPago').empty();
    $('#subtotal').empty();
    $('#codigoDescuento').empty();
    $('#igv').empty();
    $('#total').empty();
    $('#productosTabla').empty();
}
function obtenerReporte(){
    var fechaDesde = document.getElementById('fechaDesde').value;
    var fechaHasta = document.getElementById('fechaHasta').value;
    if(fechaDesde == "" || fechaHasta == ""){
        alertify.error("Ingrese las fechas");
    }else{
        $.ajax({
            type: "POST",
            url: "exportarExcel.php",
            dataType: 'json',
            data: {
                fechaDesde: fechaDesde,
                fechaHasta: fechaHasta
            }
        }).done(
            function (data) {
                document.getElementById('resultados').innerHTML = "";
                if(data.ventas.length > 0){
                    document.getElementById('btn-excel').style.display = "flex";
                    document.getElementById('box-table').style.display = "flex";
                    document.getElementById('mensaje').style.display = "none";
                    for(i=0; i<data.ventas.length; i++){
                        var productosCantidad = [];
                        for(j=0; j<data.productos.length; j++){
                            if(data.ventas[i].id == data.productos[j].idVenta){
                                productosCantidad.push(data.productos[j]);
                            }
                        }
                        document.getElementById('resultados').insertRow(-1).innerHTML = '<td>'+data.ventas[i].nComprobante+'</td><td>'+data.ventas[i].fechaEmision+" "+data.ventas[i].horaEmision+'</td><td>'+data.ventas[i].tipoComprobante+'</td><td>'+data.ventas[i].sede+'</td><td>'+data.ventas[i].nombres+" "+data.ventas[i].apellidos+'</td><td>'+data.ventas[i].medioPago+'</td><td>'+data.ventas[i].vendedor+'</td><td>'+data.ventas[i].bolsas+'</td><td>'+data.ventas[i].codigo+'</td><td>'+productosCantidad.length+'</td><td>'+data.ventas[i].pagocon+'</td><td>'+data.ventas[i].vuelto+'</td><td>S/'+data.ventas[i].subtotal+'</td><td>S/'+data.ventas[i].igv+'</td><td>S/'+data.ventas[i].total+'</td>';
                    }
                }else{
                    document.getElementById('btn-excel').style.display = "none";
                    document.getElementById('box-table').style.display = "none";
                    document.getElementById('mensaje').style.display = "flex";
                }
            }
        )
        }
}
function exportarExcel(){
    var tabla = document.getElementById("tabla");
    var fecha = new Date();
    var dia = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
    var mes = fecha.getMonth() < 10 ? '0' + fecha.getMonth() : fecha.getMonth();
    var anio = fecha.getFullYear();
    var filename = 'Reporte'+ ' ' + dia + '-' + mes + '-' + anio + '.xls';
    var html = tabla.outerHTML;
    var blob = new Blob(['\ufeff', html], {
        type: 'application/vnd.ms-excel',
    })

    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    a.click();
}
function aumentarBolsa(){
    var cantidad = document.getElementById('bolsas').value;
    cantidad++;
    var total = document.getElementById('total').value;
    total = total.replace("S/", "");
    total = parseFloat(total);
    total = total + 0.20;
    document.getElementById('total').value = "S/"+total.toFixed(2);
    document.getElementById('bolsas').value = cantidad;
}
function disminuirBolsa(){
    var cantidad = document.getElementById('bolsas').value;
    if(cantidad > 0){
        cantidad--;
        var total = document.getElementById('total').value;
        total = total.replace("S/", "");
        total = parseFloat(total);
        total = total - 0.20;
        document.getElementById('total').value = "S/"+total.toFixed(2);
        document.getElementById('bolsas').value = cantidad;
    }
}
function abrirModalEditarProducto(i){
    $.ajax({
        type: "POST",
        url: "detalle-producto.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('codigoProducto').value = data.codigo;
            document.getElementById('nombreProducto').value = data.nombre;
            document.getElementById('stockProducto').value = data.stock;
            document.getElementById('precioProducto').value = "S/"+parseFloat(data.precio).toFixed(2);
            document.getElementById('btn-actualizar').onclick = function(){actualizarProducto(data.id)};
        }
    )
}
function abrirModalEliminarProducto(i){
    $.ajax({
        type: "POST",
        url: "detalle-producto.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreProductoModalEliminar').innerHTML = data.nombre;
            document.getElementById('btn-eliminar').onclick = function(){eliminarProducto(data.id)};
        }
    )
}
function eliminarProducto(i){
    $.ajax({
        type: "POST",
        url: "eliminar-producto.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('btn-eliminar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function actualizarProducto(i){
    var codigo = document.getElementById('codigoProducto').value;
    var nombre = document.getElementById('nombreProducto').value;
    var stock = document.getElementById('stockProducto').value;
     if(codigo == '' || nombre == '' || stock == 0){
        alertify.error('Complete todos los campos');
        return;
    }
    $.ajax({
        type: "POST",
        url: "actualizar-producto.php",
        dataType: 'json',
        data: {
            id: i,
            codigo: document.getElementById('codigoProducto').value,
            nombre: document.getElementById('nombreProducto').value,
            stock : document.getElementById('stockProducto').value,
            precio: document.getElementById('precioProducto').value.replace("S/", "")
        }
    }).done(
        function (data) {
            document.getElementById('btn-actualizar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function agregarProductoModal(){
    var productosTemporal = arrayProductos;
    var codigo = document.getElementById('codigoProductoAgregar').value;
    var nombre = document.getElementById('nombreProductoAgregar').value;
    var stock = document.getElementById('stockProductoAgregar').value;
     if(codigo == '' || nombre == '' || stock == 0){
        alertify.error('Complete todos los campos');
        return;
    }
    for(var i = 0; i < productosTemporal.length; i++){
        if(productosTemporal[i].codigo == codigo){
            alertify.error('El producto ya existe');
            return;
        }
    }
    $.ajax({
        type: "POST",
        url: "cargar-producto.php",
        dataType: 'json',
        data: {
            codigo: document.getElementById('codigoProductoAgregar').value,
            nombre: document.getElementById('nombreProductoAgregar').value,
            stock : document.getElementById('stockProductoAgregar').value,
            precio: document.getElementById('precioProductoAgregar').value.replace("S/", "")
        }
    }).done(
        function (data) {
            document.getElementById('btn-agregar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function actualizarTablaProductos(){
    $.ajax({
        type: "GET",
        url: "traer-productos.php",
        dataType: 'json'  
    }).done(
        function (data) {
            var tabla = document.getElementById('productosModal');
            var html = '';
            for(var i = 0; i < data.length; i++){
                html += '<tr>';
                html += '<td>'+data[i].codigo+'</td>';
                html += '<td>'+data[i].nombre+'</td>';
                if(data[i].stock <= 5){
                    html += '<td><span style="display:flex; width:50px; margin:auto; font-size:1rem" class="badge text-bg-danger">'+data[i].stock+'</span></td>';
                }else{
                    html += '<td><span style="display:flex; width:50px; margin:auto; font-size:1rem" class="badge text-bg-success">'+data[i].stock+'</span></td>';
                }
                html += '<td>S/'+data[i].precio+'</td>';
                html += '</tr>';
            }
            tabla.innerHTML = html;
        }
    )
}
function aumentarStockModal(){
    var cantidad = document.getElementById('stockProducto').value;
    cantidad++;
    document.getElementById('stockProducto').value = cantidad;
}
function disminuirStockModal(){
    var cantidad = document.getElementById('stockProducto').value;
    if(cantidad > 0){
        cantidad--;
        document.getElementById('stockProducto').value = cantidad;
    }
}
function aumentarProductoModal(){
    var cantidad = document.getElementById('stockProductoAgregar').value;
    cantidad++;
    document.getElementById('stockProductoAgregar').value = cantidad;
}
function disminuirProductoModal(){
    var cantidad = document.getElementById('stockProductoAgregar').value;
    if(cantidad > 0){
        cantidad--;
        document.getElementById('stockProductoAgregar').value = cantidad;
    }
}
function abrirModalEditarCodigo(i){
    $.ajax({
        type: "POST",
        url: "detalle-codigo.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('codigoCodigo').value = data.codigo;
            document.getElementById('descuentoCodigo').value = data.descuento;
            document.getElementById('btn-actualizar').onclick = function(){actualizarCodigo(data.id)};
        }
    )
}
function actualizarCodigo(i) {
    $.ajax({
        type: "POST",
        url: "actualizar-codigo.php",
        dataType: 'json',
        data: {
            id: i,
            codigo: document.getElementById('codigoCodigo').value,
            descuento: document.getElementById('descuentoCodigo').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-actualizar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEliminarCodigo(i){
    $.ajax({
        type: "POST",
        url: "detalle-codigo.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreCodigoModalEliminar').innerHTML = data.codigo;
            document.getElementById('btn-eliminarCodigo').onclick = function(){eliminarCodigo(data.id)};
        }
    )
}
function eliminarCodigo(i){
    $.ajax({
        type: "POST",
        url: "eliminar-codigo.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('btn-eliminarCodigo').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function agregarCodigoModal(){
    $.ajax({
        type: "POST",
        url: "cargar-codigo.php",
        dataType: 'json',
        data: {
            codigo: document.getElementById('codigoCodigoAgregar').value,
            descuento: document.getElementById('descuentoCodigoAgregar').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-agregar-codigo').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEditarSede(i){
    $.ajax({
        type: "POST",
        url: "detalle-sede.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreSede').value = data.nombre;
            document.getElementById('btn-actualizar').onclick = function(){actualizarSede(data.id)};
        }
    )
}
function actualizarSede(i){
    $.ajax({
        type: "POST",
        url: "actualizar-sede.php",
        dataType: 'json',
        data: {
            id: i,
            nombre: document.getElementById('nombreSede').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-actualizar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEliminarSede(i){
    $.ajax({
        type: "POST",
        url: "detalle-sede.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreSedeModalEliminar').innerHTML = data.nombre;
            document.getElementById('btn-eliminar').onclick = function(){eliminarSede(data.id)};
        }
    )
}
function eliminarSede(i){
    $.ajax({
        type: "POST",
        url: "eliminar-sede.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('btn-eliminar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function agregarSedeModal(){
    $.ajax({
        type: "POST",
        url: "cargar-sede.php",
        dataType: 'json',
        data: {
            nombre: document.getElementById('nombreSedeAgregar').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-agregar-sede').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEditarCajero(i){
    $.ajax({
        type: "POST",
        url: "detalle-cajero.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreCajero').value = data.nombre;
            document.getElementById('btn-actualizar').onclick = function(){actualizarCajero(data.id)};
        }
    )
}
function actualizarCajero(i){
    $.ajax({
        type: "POST",
        url: "actualizar-cajero.php",
        dataType: 'json',
        data: {
            id: i,
            nombre: document.getElementById('nombreCajero').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-actualizar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEliminarCajero(i){
    $.ajax({
        type: "POST",
        url: "detalle-cajero.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreCajeroModalEliminar').innerHTML = data.nombre;
            document.getElementById('btn-eliminar').onclick = function(){eliminarCajero(data.id)};
        }
    )
}
function eliminarCajero(i){
    $.ajax({
        type: "POST",
        url: "eliminar-cajero.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('btn-eliminar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function agregarCajeroModal(){
    $.ajax({
        type: "POST",
        url: "cargar-cajero.php",
        dataType: 'json',
        data: {
            nombre: document.getElementById('nombreCajeroAgregar').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-agregar-cajero').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEditarMozo(i){
    $.ajax({
        type: "POST",
        url: "detalle-mozo.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreMozo').value = data.nombre;
            document.getElementById('btn-actualizar').onclick = function(){actualizarMozo(data.id)};
        }
    )
}
function actualizarMozo(i){
    $.ajax({
        type: "POST",
        url: "actualizar-mozo.php",
        dataType: 'json',
        data: {
            id: i,
            nombre: document.getElementById('nombreMozo').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-actualizar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEliminarMozo(i){
    $.ajax({
        type: "POST",
        url: "detalle-mozo.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('nombreMozoModalEliminar').innerHTML = data.nombre;
            document.getElementById('btn-eliminar').onclick = function(){eliminarMozo(data.id)};
        }
    )
}
function eliminarMozo(i){
    $.ajax({
        type: "POST",
        url: "eliminar-mozo.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('btn-eliminar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function agregarMozoModal(){
    $.ajax({
        type: "POST",
        url: "cargar-mozo.php",
        dataType: 'json',
        data: {
            nombre: document.getElementById('nombreMozoAgregar').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-agregar-mozo').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function abrirModalEditarPerfil(i){
    $.ajax({
        type: "POST",
        url: "detalle-perfil.php",
        dataType: 'json',
        data: {
            id: i
        }
    }).done(
        function (data) {
            document.getElementById('correoPerfil').value = data.correo;
            document.getElementById('passwordPerfil').value = data.password;
            document.getElementById('btn-actualizar').onclick = function(){actualizarPerfil(data.id)};
        }
    )
}
function actualizarPerfil(i) {
    $.ajax({
        type: "POST",
        url: "actualizar-perfil.php",
        dataType: 'json',
        data: {
            id: i,
            correo: document.getElementById('correoPerfil').value,
            password: document.getElementById('passwordPerfil').value
        }
    }).done(
        function (data) {
            document.getElementById('btn-actualizar').disabled = true;
            alertify.success(data.message);
            setTimeout(function(){location.reload()}, 1000);
        }
    )
}
function copiarCodigo(string){
    console.log(string);
    /* navigator.clipboard.writeText(codigo);
    alertify.success('Código copiado'); */
}