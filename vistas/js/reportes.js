$("#formReportePagosEstudiante").on("submit", function (e) {
    e.preventDefault();

    var idEstudiante = $("#estudiante").val();
    if (idEstudiante === "") {
        alert("Por favor, seleccione un estudiante.");
        return;
    }

    var datos = new FormData();
    datos.append("idEstudiante", idEstudiante);

    $.ajax({
        url: "ajax/reportes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'  // Para manejar la descarga del archivo
        },
        success: function (respuesta) {
            console.log(respuesta);
            
            // Crear un enlace temporal para descargar el archivo
            var url = window.URL.createObjectURL(new Blob([respuesta]));
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Reporte_Pagos_Estudiante_' + idEstudiante + '.pdf';
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

$("#formReportePagosApoderado").on("submit", function (e) {
    e.preventDefault();

    var idApoderado = $("#apoderado").val();
    if (idApoderado === "") {
        alert("Por favor, seleccione un apoderado.");
        return;
    }

    var datos = new FormData();
    datos.append("idApoderado", idApoderado);

    $.ajax({
        url: "ajax/reportes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'  // Para manejar la descarga del archivo
        },
        success: function (respuesta) {
            // Crear un enlace temporal para descargar el archivo
            var url = window.URL.createObjectURL(new Blob([respuesta]));
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Reporte_Pagos_Apoderado_' + idApoderado + '.pdf';
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

$("#formReporteEstudiantesCurso").on("submit", function (e) {
    e.preventDefault();

    var idCurso = $("#curso").val();
    if (idCurso === "") {
        alert("Por favor, seleccione un curso.");
        return;
    }

    var datos = new FormData();
    datos.append("idCurso", idCurso);

    $.ajax({
        url: "ajax/reportes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (respuesta) {
            var url = window.URL.createObjectURL(new Blob([respuesta]));
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Reporte_Estudiantes_' + idCurso + '.pdf';
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

function generarCursosConMasEstudiantesPDF() {
    $.ajax({
        url: 'ajax/reportes.ajax.php',
        method: 'POST',
        data: { cursosMasEstudiantes: true },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'reporte_cursos_mas_estudiantes.pdf';
            link.click();
        },
        error: function (xhr, status, error) {
            console.error("Error al generar el PDF:", error);
        }
    });
}

function generarEstudiantesPorFechaPDF() {
    var fechaInicioRegistro = $('#fechaInicioRegistro').val();
    var fechaFinRegistro = $('#fechaFinRegistro').val();

    if (fechaInicioRegistro && fechaFinRegistro) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { fechaInicioRegistro: fechaInicioRegistro, fechaFinRegistro: fechaFinRegistro },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_estudiantes_registro.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert('Seleccione ambas fechas para generar el reporte.');
    }
}

function generarPagosPorPeriodoPDF() {
    var fechaInicio = $('#fechaInicio').val();
    var fechaFin = $('#fechaFin').val();

    if (fechaInicio && fechaFin) {
        $.ajax({
            url: 'ajax/reportes.ajax.php',
            method: 'POST',
            data: { fechaInicioPago: fechaInicio, fechaFinPago: fechaFin },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'reporte_pagos_periodo.pdf';
                link.click();
            },
            error: function (xhr, status, error) {
                console.error("Error al generar el PDF:", error);
            }
        });
    } else {
        alert('Seleccione ambas fechas para generar el reporte.');
    }
}