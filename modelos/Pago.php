<?php

require_once "conexion.php";

class Pago
{
	static public function listar($busqueda = "", $limit = null, $offset = null)
	{
		$sql = "SELECT pagos.*, 
                   estudiante.nombre as estudiante_nombre, 
                   estudiante.apellidos as estudiante_apellidos, 
                   apoderado.nombre as apoderado_nombre, 
                   apoderado.apellido as apoderado_apellido, 
                   curso.curso as curso_nombre, 
                   usuario.usuario as usuario_nombre
            FROM pagos
            INNER JOIN estudiante ON pagos.id_estudiante = estudiante.id
            INNER JOIN apoderado ON pagos.id_apoderado = apoderado.id
            INNER JOIN curso ON pagos.id_curso = curso.id
            INNER JOIN usuario ON pagos.id_usuario = usuario.id";

		if (!empty($busqueda)) {
			$sql .= " WHERE estudiante.nombre LIKE :busqueda 
                  OR estudiante.apellidos LIKE :busqueda 
                  OR apoderado.nombre LIKE :busqueda 
                  OR apoderado.apellido LIKE :busqueda 
                  OR curso.curso LIKE :busqueda 
                  OR usuario.usuario LIKE :busqueda";
		}

		if ($limit !== null && $offset !== null) {
			$sql .= " LIMIT :limit OFFSET :offset";
		}

		$stmt = Conexion::conectar()->prepare($sql);

		if (!empty($busqueda)) {
			$busqueda = "%$busqueda%";
			$stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
		}

		if ($limit !== null && $offset !== null) {
			$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
			$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
		}

		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC); // Asegúrate de obtener un resultado como un array asociativo
	}

	static public function listarPorPeriodo($fechaInicio, $fechaFin)
	{
		$stmt = Conexion::conectar()->prepare("
            SELECT * FROM pagos
            WHERE fecha BETWEEN :fechaInicio AND :fechaFin 
            ORDER BY fecha ASC
        ");
		$stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
		if ($stmt->execute()) {
			return $stmt->fetchAll();
		} else {
			$error = $stmt->errorInfo();
			return [];
		};
	}

	static public function contarPagos($busqueda = "")
	{
		$sql = "SELECT COUNT(*) as total FROM pagos 
                INNER JOIN estudiante ON pagos.id_estudiante = estudiante.id
                INNER JOIN apoderado ON pagos.id_apoderado = apoderado.id
                INNER JOIN curso ON pagos.id_curso = curso.id
                INNER JOIN usuario ON pagos.id_usuario = usuario.id";

		if (!empty($busqueda)) {
			$sql .= " WHERE estudiante.nombre LIKE :busqueda 
                      OR estudiante.apellidos LIKE :busqueda 
                      OR apoderado.nombre LIKE :busqueda 
                      OR apoderado.apellido LIKE :busqueda 
                      OR curso.curso LIKE :busqueda 
                      OR usuario.usuario LIKE :busqueda";
		}

		$stmt = Conexion::conectar()->prepare($sql);

		if (!empty($busqueda)) {
			$busqueda = "%$busqueda%";
			$stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
		}

		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
	}

	static public function listarPorEstudiante($idEstudiante)
	{
		$sql = "SELECT pagos.*, 
                       estudiante.nombre as estudiante_nombre, 
                       estudiante.apellidos as estudiante_apellidos, 
                       apoderado.nombre as apoderado_nombre, 
                       apoderado.apellido as apoderado_apellido, 
                       curso.curso as curso_nombre, 
                       usuario.usuario as usuario_nombre
                FROM pagos
                INNER JOIN estudiante ON pagos.id_estudiante = estudiante.id
                INNER JOIN apoderado ON pagos.id_apoderado = apoderado.id
                INNER JOIN curso ON pagos.id_curso = curso.id
                INNER JOIN usuario ON pagos.id_usuario = usuario.id
                WHERE pagos.id_estudiante = :idEstudiante";

		if (!empty($busqueda)) {
			$sql .= " AND (estudiante.nombre LIKE :busqueda 
                      OR estudiante.apellidos LIKE :busqueda 
                      OR apoderado.nombre LIKE :busqueda 
                      OR apoderado.apellido LIKE :busqueda 
                      OR curso.curso LIKE :busqueda 
                      OR usuario.usuario LIKE :busqueda)";
		}


		$stmt = Conexion::conectar()->prepare($sql);

		// Vinculación de parámetros
		$stmt->bindParam(":idEstudiante", $idEstudiante, PDO::PARAM_INT);

		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function listarPorApoderado($idApoderado)
	{
		$sql = "SELECT pagos.*, 
                       estudiante.nombre as estudiante_nombre, 
                       estudiante.apellidos as estudiante_apellidos, 
                       apoderado.nombre as apoderado_nombre, 
                       apoderado.apellido as apoderado_apellido, 
                       curso.curso as curso_nombre, 
                       usuario.usuario as usuario_nombre
                FROM pagos
                INNER JOIN estudiante ON pagos.id_estudiante = estudiante.id
                INNER JOIN apoderado ON pagos.id_apoderado = apoderado.id
                INNER JOIN curso ON pagos.id_curso = curso.id
                INNER JOIN usuario ON pagos.id_usuario = usuario.id
                WHERE pagos.id_apoderado = :idApoderado";

		$stmt = Conexion::conectar()->prepare($sql);

		// Vinculación de parámetros
		$stmt->bindParam(":idApoderado", $idApoderado, PDO::PARAM_INT);

		$stmt->execute();
		return $stmt->fetchAll();
	}


	/*=============================================
    REGISTRO DE PAGO
    =============================================*/

	static public function crear($datos)
	{
		$fecha_actual = date('Y/m/d H:i:s');

		$stmt = Conexion::conectar()->prepare("INSERT INTO pagos (fecha, hora, monto, n_cuotas, id_estudiante, id_apoderado, id_curso, id_detalle_cuotas, id_usuario) VALUES (:fecha, :hora, :monto, :n_cuotas, :id_estudiante, :id_apoderado, :id_curso, :id_detalle_cuotas, :id_usuario)");
		$stmt->bindParam(":fecha", $fecha_actual, PDO::PARAM_STR);
		$stmt->bindParam(":hora", $fecha_actual, PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":n_cuotas", $datos["n_cuotas"], PDO::PARAM_STR);
		$stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
		$stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
		$stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
		$stmt->bindParam(":id_detalle_cuotas", $datos["id_detalle_cuotas"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
    EDITAR PAGO
    =============================================*/

	static public function editar($datos)
	{
		if (isset($datos["id"])) {
			$fecha_actual = date('Y/m/d H:i:s');

			$stmt = Conexion::conectar()->prepare("UPDATE pagos SET hora = :hora, monto = :monto, n_cuotas = :n_cuotas, id_estudiante = :id_estudiante, id_apoderado = :id_apoderado, id_curso = :id_curso, id_detalle_cuotas = :id_detalle_cuotas, id_usuario = :id_usuario WHERE id = :id");
			$stmt->bindParam(":hora", $fecha_actual, PDO::PARAM_STR);
			$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
			$stmt->bindParam(":n_cuotas", $datos["n_cuotas"], PDO::PARAM_STR);
			$stmt->bindParam(":id_estudiante", $datos["id_estudiante"], PDO::PARAM_INT);
			$stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
			$stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
			$stmt->bindParam(":id_detalle_cuotas", $datos["id_detalle_cuotas"], PDO::PARAM_INT);
			$stmt->bindParam(":id_usuario", $_SESSION["id"], PDO::PARAM_INT);
			$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

			if ($stmt->execute()) {
				return "ok";
			} else {
				return "error";
			}
		} else {
			return "error";
		}
	}

	static public function buscarPorId($valor)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM pagos WHERE id = $valor");
		$stmt->execute();
		return $stmt->fetch();
	}

	/*=============================================
    ACTUALIZAR PAGO
    =============================================*/

	static public function actualizar($item1, $valor1, $item2, $valor2)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE pagos SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
    BORRAR PAGO
    =============================================*/

	static public function eliminar($datos)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM pagos WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	static public function totalCuotasPagadas($id_estudiante)
	{
		$stmt = Conexion::conectar()->prepare("SELECT SUM(n_cuotas) as total_cuotas FROM pagos WHERE id_estudiante = :id_estudiante");
		$stmt->bindParam(":id_estudiante", $id_estudiante, PDO::PARAM_INT);
		$stmt->execute();

		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultado['total_cuotas'] ? $resultado['total_cuotas'] : 0;
	}
}
