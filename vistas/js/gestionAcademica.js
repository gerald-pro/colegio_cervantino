$(".tablas").on("click", ".btnEditarGestion", function () {

    var id = $(this).attr("id");
    var datos = new FormData();
    datos.append("id", id);

    $.ajax({
        url: "ajax/gestionAcademica.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#idGestion").val(respuesta["id"]);
            $("#EditarAnio").val(respuesta["anio"]);
            $("#EditarFechaInicioRegistro").val(respuesta["fecha_inicio_registro"]);
            $("#EditarFechaCierreRegistro").val(respuesta["fecha_cierre_registro"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});


$(".tablas").on("click", ".btnEliminarGestion", function () {

    var id = $(this).attr("id");

    swal({
        title: '¿Está seguro de borrar la gestion?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar!'
    }).then(function (result) {
        if (result.value) {
            window.location = "index.php?rutas=gestiones&id=" + id;
        }
    })

})
