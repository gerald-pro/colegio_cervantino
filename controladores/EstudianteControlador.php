<?php

class EstudianteControlador
{
    /*=============================================
    REGISTRO DE ESTUDIANTE
    =============================================*/
    static public function crear()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (
                Validador::validarNombre($_POST["nuevoNombre"]) &&
                Validador::validarNombre($_POST["nuevoApellido"]) &&
                Validador::validarSoloNumeros($_POST["nuevoTelefono"]) &&
                Validador::validarNoVacio($_POST["nuevaDireccion"])
            ) {

                $gestionActual = GestionAcademica::obtenerGestionActual();

                // Verificar si existe una gestión actual y si permite el registro
                if (
                    $gestionActual &&
                    date("Y-m-d") >= $gestionActual["fecha_inicio_registro"] &&
                    date("Y-m-d") <= $gestionActual["fecha_cierre_registro"]
                ) {

                    $datos = array(
                        "nombre" => $_POST["nuevoNombre"],
                        "apellidos" => $_POST["nuevoApellido"],
                        "direccion" => $_POST["nuevaDireccion"],
                        "fechanac" => $_POST["nuevaFechaNac"],
                        "correo" => $_POST["nuevoCorreo"],
                        "telefono" => $_POST["nuevoTelefono"],
                        "id_curso" => $_POST['nuevoIdCurso'],
                        "id_apoderado" => $_POST['nuevoIdApoderado'],
                        "id_gestion_academica" => $gestionActual["id"],
                    );

                    $respuesta = Estudiante::crear($datos);

                    if ($respuesta == "ok") {
                        echo Mensaje::obtenerMensaje(
                            "success",
                            "El estudiante ha sido registrado correctamente",
                            null,
                            "estudiantes"
                        );
                    } else {
                        echo Mensaje::obtenerMensaje(
                            "error",
                            "Ocurrió un error",
                            $respuesta,
                            null
                        );
                    }
                } else {
                    $fechaCierre = $gestionActual ? $gestionActual["fecha_cierre_registro"] : "N/A";
                    echo '<script>
                        swal({
                            type: "error",
                            title: "¡La gestión académica actual no permite el registro de nuevos estudiantes!",
                            text: "La fecha límite para inscribir fue: ' . $fechaCierre . '",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                window.location = "estudiantes";
                            }
                        });
                    </script>';
                }
            } else {
                echo '<script>
                            swal({
                                type: "error",
                                title: "¡Los campos no pueden ir vacíos y deben contener solo letras (nombre, apellido y dirección) o números (teléfono)!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                                }).then(function(result){
                                    if (result.value) {
                                    window.location = "estudiantes";
                                    }
                            </script>';
            }
        }
    }

    /*=============================================
    MOSTRAR ESTUDIANTE
    =============================================*/
    static public function listar($busqueda = "", $pagina = 1, $cantidad = 10)
    {
        $inicio = ($pagina - 1) * $cantidad;
        return Estudiante::listar($busqueda, $inicio, $cantidad);
    }

    static public function contarEstudiantes($busqueda = "")
    {
        return Estudiante::contarEstudiantes($busqueda);
    }

    /*=============================================
    EDITAR ESTUDIANTE
    =============================================*/

    static public function editar()
    {
        if (isset($_POST["editarNombre"])) {
            if (
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarTelefono"])
            ) {
                $datos = array(
                    "nombre" => $_POST["editarNombre"],
                    "apellidos" => $_POST["editarApellido"],
                    "direccion" => $_POST["editarDireccion"],
                    "fechanac" => $_POST["editarFechaNac"],
                    "correo" => $_POST["editarCorreo"],
                    "telefono" => $_POST["editarTelefono"],
                    "id_curso" => $_POST["editarIdCurso"],
                    "id_apoderado" => $_POST["editarIdApoderado"],
                    "id" => $_POST["idEstudiante"]
                );

                $respuesta = Estudiante::editar('estudiante', $datos);

                if ($respuesta == "ok") {
                    echo Mensaje::obtenerMensaje(
                        "success",
                        "El estudiante ha sido editado correctamente",
                        null,
                        "estudiantes"
                    );
                } else {
                    echo Mensaje::obtenerMensaje(
                        "error",
                        "Ocurrió un error",
                        $respuesta,
                        null
                    );
                }
            } else {
                echo '<script>
                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener solo letras (nombre, apellido y dirección) o números (teléfono)!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {
                            window.location = "estudiantes";
                            }
                        })

                  </script>';
            }
        }
    }

    /*=============================================
    ELIMINAR ESTUDIANTE
    =============================================*/
    static public function eliminar()
    {
        if (isset($_GET["id"])) {
            $datos = $_GET["id"];
            $respuesta = Estudiante::eliminar('estudiante', $datos);

            if ($respuesta == "ok") {
                echo '<script>
                swal({
                      type: "success",
                      title: "El estudiante ha sido borrado correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                                if (result.value) {

                                window.location = "estudiantes";
                                }
                            })
                </script>';
            }
        }
    }
}
