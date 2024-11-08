<?php

require_once "conexion.php";

class Estudiante
{

    /*=============================================
    REGISTRO DE ESTUDIANTE
    =============================================*/

    static public function crear($datos)
    {
        $current_date = date('Y/m/d');
        $stmt = Conexion::conectar()->prepare("INSERT INTO estudiante (nombre, apellidos, direccion, fechanac, correo, telefono, fecharegistro, id_curso, id_apoderado) 
                                                VALUES (:nombre, :apellidos, :direccion, :fechanac, :correo, :telefono, :fecharegistro, :id_curso, :id_apoderado)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":fecharegistro", $current_date, PDO::PARAM_STR);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    EDITAR ESTUDIANTE
    =============================================*/

    static public function editar($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, 
                                                fechanac = :fechanac, fechaact = :fechaact ,correo = :correo, telefono = :telefono, id_curso = :id_curso, id_apoderado = :id_apoderado 
                                                WHERE id = :id");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":fechanac", $datos["fechanac"], PDO::PARAM_STR);
        $stmt->bindParam(":fechaact", $datos["fechaact"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_curso", $datos["id_curso"], PDO::PARAM_INT);
        $stmt->bindParam(":id_apoderado", $datos["id_apoderado"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    static public function listarPorFechaRegistro($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT * FROM estudiante
            WHERE fecharegistro BETWEEN :fechaInicio AND :fechaFin 
            ORDER BY fecharegistro ASC
        ");
        $stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*=============================================
    ELIMINAR ESTUDIANTE
    =============================================*/

    static public function eliminar($tabla, $id)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    MOSTRAR ESTUDIANTES
    =============================================*/

    static public function listar($busqueda = "", $inicio = 0, $cantidad = 10)
    {
        $conexion = Conexion::conectar();

        if ($busqueda !== "") {
            $stmt = $conexion->prepare(
                "SELECT * FROM estudiante WHERE nombre LIKE :busqueda OR apellidos LIKE :busqueda LIMIT :inicio, :cantidad"
            );
            $busqueda = "%" . $busqueda . "%";
            $stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
        } else {
            $stmt = $conexion->prepare("SELECT * FROM estudiante LIMIT :inicio, :cantidad");
        }

        $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function todos()
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM estudiante");

        $stmt->execute();
        return $stmt->fetchAll();
    }


    static public function buscarPorId($valor)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiante WHERE id = $valor");
        $stmt->execute();
        return $stmt->fetch();
    }

    static public function listarPorCurso($idCurso)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM estudiante WHERE id_curso = $idCurso");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function contarEstudiantes($busqueda = "")
    {
        $conexion = Conexion::conectar();

        if ($busqueda !== "") {
            $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM estudiante WHERE nombre LIKE :busqueda OR apellidos LIKE :busqueda");
            $busqueda = "%" . $busqueda . "%";
            $stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
        } else {
            $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM estudiante");
        }

        $stmt->execute();
        return $stmt->fetch()["total"];
    }
}
