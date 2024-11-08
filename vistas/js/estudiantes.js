/*=============================================
MOSTRAR ESTUDIANTE
=============================================*/
$(".tablas").on("click", ".btnVerEstudiante", function(){
    var id = $(this).attr("id");
    console.log(id)
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
        success: function(respuesta){
            $("#verNombre").val(respuesta["nombre"]);
            $("#verApellido").val(respuesta["apellidos"]);
            $("#verCorreo").val(respuesta["correo"]);
            $("#verDireccion").val(respuesta["direccion"]);
            $("#verTelefono").val(respuesta["telefono"]);
            $("#verFechaNac").val(respuesta["fechanac"]);
            $("#verfechaAct").val(respuesta["fechaact"]);
            $("#verFechaReg").val(respuesta["fecharegistro"]);
            $("#verIdCurso").val(respuesta["id_curso"]);
            $("#verApoderado").val(respuesta["id_apoderado"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

/*=============================================
EDITAR ESTUDIANTE
=============================================*/
$(".tablas").on("click", ".btnEditarEstudiante", function(){
    var id = $(this).attr("id");
    console.log(id)
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
        success: function(respuesta){
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarApellido").val(respuesta["apellidos"]);
            $("#editarCorreo").val(respuesta["correo"]);
            $("#editarDireccion").val(respuesta["direccion"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            $("#editarFechaNac").val(respuesta["fechanac"]);
            $("#editarIdCurso").val(respuesta["id_curso"]);
            $("#editarIdApoderado").val(respuesta["id_apoderado"]);
            $("#idEstudiante").val(respuesta["id"]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
            console.error("Respuesta del servidor: ", jqXHR.responseText);
        }
    });
});

/*=============================================
ELIMINAR ESTUDIANTE
=============================================*/
$(".tablas").on("click", ".btnEliminarEstudiante", function(){
    var id = $(this).attr("id");
    swal({
        title: '¿Está seguro de borrar al estudiante?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar estudiante!'
    }).then(function(result){
        if(result.value){
            window.location = "index.php?rutas=estudiantes&id=" + id;
        }
    });
});
