<?php

class EstudianteControlador {
    /*=============================================
    REGISTRO DE ESTUDIANTE
    =============================================*/
    static public function crear(){
        if(isset($_POST["nuevoNombre"])){
            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
               preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoApellido"]) &&


               preg_match('/^[0-9]+$/', $_POST["nuevoTelefono"]) &&
  

               preg_match('/^[0-9]+$/', $_POST["nuevoIdCurso"]) &&
               preg_match('/^[0-9]+$/', $_POST["nuevoIdApoderado"]) &&
           
               preg_match('/^[0-9]+$/', $_POST["nuevoTelefono"])){

                $datos = array(
                               "nombre" => $_POST["nuevoNombre"],
                               "apellidos" => $_POST["nuevoApellido"],
                               "direccion" => $_POST["nuevaDireccion"],
                               "fechanac" => $_POST["nuevaFechaNac"],
                               "correo" => $_POST["nuevoCorreo"],
                               "telefono" => $_POST["nuevoTelefono"],
                               "id_curso" => $_POST['nuevoIdCurso'],
                               "id_apoderado" => $_POST['nuevoIdApoderado']
                               );

                $respuesta = Estudiante::crear($datos);

                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                          type: "success",
                          title: "El estudiante ha sido registrado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {

                                    window.location = "estudiantes";

                                    }
                                })

                    </script>';
                }   
            }else{
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

    static public function editar(){
        if(isset($_POST["editarNombre"])){
            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
               preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarApellido"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDireccion"]) &&
               preg_match('/^[0-9]+$/', $_POST["editarTelefono"])){

                $datos = array("nombre" => $_POST["editarNombre"],
                               "apellidos" => $_POST["editarApellido"],
                               "direccion" => $_POST["editarDireccion"],
                               "fechanac" => $_POST["editarFechaNac"],
                               "correo" => $_POST["editarCorreo"],
                               "telefono" => $_POST["editarTelefono"],
                               "id_curso" => $_POST["editarIdCurso"],
                               "id_apoderado" => $_POST["editarIdApoderado"],
                               "id" => $_POST["idEstudiante"]);

                $respuesta = Estudiante::editar('estudiante', $datos);

                if($respuesta == "ok"){
                    echo'<script>
                    swal({
                          type: "success",
                          title: "El estudiante ha sido editado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "estudiantes";
                                    }
                                })
                    </script>';

                }
            }else{
                echo'<script>
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
    static public function eliminar(){
        if(isset($_GET["id"])){
            $datos = $_GET["id"];
            $respuesta = Estudiante::eliminar('estudiante', $datos);

            if($respuesta == "ok"){
                echo'<script>
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
