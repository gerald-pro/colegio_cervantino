<?php
class PagoControlador
{
	/*=============================================
    REGISTRO DE PAGO
    =============================================*/
	static public function crear()
	{
		if (isset($_POST["nuevoMonto"])) {
			if (
				preg_match('/^[0-9]+$/', $_POST["nuevoMonto"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoIdEstudiante"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoIdApoderado"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoIdCurso"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoIdDetalleCuotas"])
			) {

				$detalleCuota = DetalleCuota::listar("id", $_POST["nuevoIdDetalleCuotas"]);
				$datos = array(
					"monto" => $detalleCuota["monto"],
					"n_cuotas" => $detalleCuota["n_cuotas"],
					"id_estudiante" => $_POST['nuevoIdEstudiante'],
					"id_apoderado" => $_POST['nuevoIdApoderado'],
					"id_curso" => $_POST['nuevoIdCurso'],
					"id_detalle_cuotas" => $_POST['nuevoIdDetalleCuotas'],
				);

				$respuesta = Pago::crear($datos);

				if ($respuesta == "ok") {
					echo '<script>
                    swal({
                          type: "success",
                          title: "El pago ha sido registrado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "pagos";
                                    }
                                })

                    </script>';
				}
			} else {
				echo '<script>

                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {
                            window.location = "pagos";
                            }
                    
                  </script>';
			}
		}
	}

	/*=============================================
    MOSTRAR PAGOS
    =============================================*/
	static public function listar($busqueda = "", $pagina = 1, $cantidad = 5)
	{
		$inicio = ($pagina - 1) * $cantidad;
		// Llama a Pago::listar y pasa la búsqueda, el límite y el offset
		$respuesta = Pago::listar($busqueda, $cantidad, $inicio);
		return $respuesta;
	}

	static public function contarPagos($busqueda = "")
	{
		return Pago::contarPagos($busqueda);
	}

	/*=============================================
    EDITAR PAGO
    =============================================*/

	static public function editar()
	{
		if (isset($_POST["editarMonto"])) {
			if (
				preg_match('/^[0-9]+$/', $_POST["editarMonto"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarNCuotas"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarIdEstudiante"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarIdApoderado"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarIdCurso"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarIdDetalleCuotas"])
			) {

				$datos = array(
					"monto" => $_POST["editarMonto"],
					"n_cuotas" => $_POST["editarNCuotas"],
					"id_estudiante" => $_POST["editarIdEstudiante"],
					"id_apoderado" => $_POST["editarIdApoderado"],
					"id_curso" => $_POST["editarIdCurso"],
					"id_detalle_cuotas" => $_POST["editarIdDetalleCuotas"],
					"id" => $_POST["idPago"]
				);

				$respuesta = Pago::editar($datos);

				if ($respuesta == "ok") {
					echo '<script>
                    swal({
                          type: "success",
                          title: "El pago ha sido editado correctamente",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                                    if (result.value) {
                                    window.location = "pagos";
                                    }
                                })
                    </script>';
				}
			} else {
				echo '<script>
                    swal({
                          type: "error",
                          title: "¡Los campos no pueden ir vacíos y deben contener los formatos correctos!",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                            if (result.value) {
                            window.location = "pagos";
                            }
                        })

                  </script>';
			}
		}
	}

	/*=============================================
    ELIMINAR PAGO
    =============================================*/
	static public function eliminar()
	{
		if (isset($_GET["id"])) {
			$datos = $_GET["id"];
			$respuesta = Pago::eliminar($datos);

			if ($respuesta == "ok") {
				echo '<script>
                swal({
                      type: "success",
                      title: "El pago ha sido borrado correctamente",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                                if (result.value) {

                                window.location = "pagos";
                                }
                            })
                </script>';
			}
		}
	}
}
