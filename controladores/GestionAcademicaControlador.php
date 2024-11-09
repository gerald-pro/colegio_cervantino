<?php

class GestionAcademicaControlador
{
    /*=============================================
    REGISTRO DE GESTIÓN ACADÉMICA
    =============================================*/
    static public function crear()
    {
        if (isset($_POST["NuevoAnio"])) {
            if (
                preg_match('/^[0-9]{4}$/', $_POST["NuevoAnio"]) &&
                preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["FechaInicioRegistro"]) &&
                preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["FechaCierreRegistro"])
            ) {

                $datos = array(
                    "anio" => $_POST["NuevoAnio"],
                    "fecha_inicio_registro" => $_POST["FechaInicioRegistro"],
                    "fecha_cierre_registro" => $_POST["FechaCierreRegistro"]
                );
                $respuesta = GestionAcademica::crear($datos);

                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "La gestión académica ha sido registrada correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "gestiones";
                            }
                        })
                    </script>';
                } else {
                    echo '<script>
                        swal({
                            type: "error",
                            title: "' . $respuesta . '",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "gestiones";
                            }
                        })
                    </script>';
                }
            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡Los campos deben contener el año en formato numérico y fechas válidas!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "gestiones";
                        }
                    })
                </script>';
            }
        }
    }

    /*=============================================
    MOSTRAR GESTIÓN ACADÉMICA
    =============================================*/
    static public function listar()
    {
        return GestionAcademica::listar();
    }

    /*=============================================
    BUSCAR GESTIÓN ACADÉMICA POR ID
    =============================================*/
    static public function buscarPorId($id)
    {
        return GestionAcademica::buscarPorId($id);
    }

    /*=============================================
    EDITAR GESTIÓN ACADÉMICA
    =============================================*/
    static public function editar()
    {
        if (isset($_POST["EditarAnio"])) {
            if (
                preg_match('/^[0-9]{4}$/', $_POST["EditarAnio"]) &&
                preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["EditarFechaInicioRegistro"]) &&
                preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["EditarFechaCierreRegistro"])
            ) {

                $datos = array(
                    "anio" => $_POST["EditarAnio"],
                    "fecha_inicio_registro" => $_POST["EditarFechaInicioRegistro"],
                    "fecha_cierre_registro" => $_POST["EditarFechaCierreRegistro"],
                    "id" => $_POST["idGestion"]
                );

                $respuesta = GestionAcademica::editar($datos);

                if ($respuesta == "ok") {
                    echo '<script>
                        swal({
                            type: "success",
                            title: "La gestión académica ha sido editada correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "gestiones";
                            }
                        })
                    </script>';
                } else {
                    echo '<script>
                        swal({
                            type: "error",
                            title: "' . $respuesta . '",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "gestiones";
                            }
                        })
                    </script>';
                }
            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡Los campos deben contener el año en formato numérico y fechas válidas!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "gestiones";
                        }
                    })
                </script>';
            }
        }
    }

    /*=============================================
    ELIMINAR GESTIÓN ACADÉMICA
    =============================================*/
    static public function eliminar()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $respuesta = GestionAcademica::eliminar($id);

            if ($respuesta == "ok") {
                echo '<script>
                    swal({
                        type: "success",
                        title: "La gestión académica ha sido borrada correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            window.location = "gestiones";
                        }
                    })
                </script>';
            }
        }
    }
}
