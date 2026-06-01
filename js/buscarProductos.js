
// evitar que el dormulario de ingreso de pedido haga submit
$(function () {
    $('#formBusquedaProductos').submit(function (e) {
        e.preventDefault();
    });
});

$(buscar_datos());

function buscar_datos(consulta="") {
    $.ajax({
        url: '../php/controlador.php',
        type: 'POST',
        dataType: 'html',
        data: { buscar_producto: consulta },
    })
    .done(function(respuesta) {
        // console.log('success');
        $('#resultadosBusqueda').html(respuesta);
    })
    .fail(function() {
        // console.log('error');
    });
}

$(document).on('keyup', '#busquedaProductos', function() {
    var valor = $(this).val();
    if (valor != "") {
        buscar_datos(valor);
    } else {
        buscar_datos();
    }
});