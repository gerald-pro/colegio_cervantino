$('#nuevoIdEstudiante').on('change', function () {
    var id = this.value;
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/estudiantes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta)
            $("#nuevoIdApoderado").val(respuesta["id_apoderado"]).change();
            $("#nuevoIdCurso").val(respuesta["id_curso"]).change();

            var totalCuotasPagadas = respuesta["total_cuotas_pagadas"];
            var cuotasRestantes = 10 - totalCuotasPagadas;

            if (totalCuotasPagadas) {
                $('#labelDetalleCuotas').text(`Nro de cuotas (Pagadas: ${totalCuotasPagadas})`);
            } else {
                $('#labelDetalleCuotas').text(`Nro de cuotas`);
            }
            

            $("#nuevoIdDetalleCuotas option").each(function () {
                var n_cuotas = parseInt($(this).text());
                if (n_cuotas > cuotasRestantes) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });

            $("#nuevoIdDetalleCuotas").find('option:visible:first').prop('selected', true).change();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

$('#nuevoMonto').on('change', function () {
    var nuevoMonto = this.value;
    let montoDetalle = $("#nuevoDetalleMonto").val();
    if (montoDetalle) {
        $("#nuevoRemanente").val(nuevoMonto - montoDetalle);
    }
});


$('#nuevoIdDetalleCuotas').on('change', function () {
    var id = this.value;
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/detalleCuotas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta)
            $("#nuevoDetalleMonto").val(respuesta["monto"]);
            let montoPagar = $("#nuevoMonto").val();
            $("#nuevoRemanente").val(montoPagar - respuesta["monto"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

/*=============================================
MOSTRAR PAGO
=============================================*/
$(".tablas").on("click", ".btnVerPago", function () {
    var id = $(this).attr("id");

    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/pagos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta)
            $("#verFecha").val(respuesta["fecha"]);
            $("#verHora").val(respuesta["hora"]);
            $("#verMonto").val(respuesta["monto"]);
            $("#verNCuotas").val(respuesta["n_cuotas"]);
            $("#verIdEstudiante").val(respuesta["id_estudiante"]);
            $("#verIdApoderado").val(respuesta["id_apoderado"]);
            $("#verIdCurso").val(respuesta["id_curso"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

/*=============================================
DESCARGAR FACTURA
=============================================*/
$(".tablas").on("click", ".btnDescargarFactura", function () {
    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("facturaId", id);
console.log(id);
    $.ajax({
        url: "ajax/pagos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob' // Importante para la descarga del archivo
        },
        success: function (respuesta) {
            // Crear un enlace temporal para descargar el archivo
            var url = window.URL.createObjectURL(new Blob([respuesta]));
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Factura_' + id + '.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});
