<?php

require_once "conexion.php";

class GestionAcademica
{
    /*=============================================
OBTENER TODAS LAS GESTIONES ACADÉMICAS
=============================================*/
    static public function todos()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM gestion_academica");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*=============================================
LISTAR GESTIONES ACADÉMICAS CON LIMIT Y OFFSET
=============================================*/
    static public function listar()
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM gestion_academica");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*=============================================
BUSCAR GESTIÓN ACADÉMICA POR ID
=============================================*/
    static public function buscarPorId($id)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM gestion_academica WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    static public function crear($datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO gestion_academica (anio, fecha_inicio_registro, fecha_cierre_registro) VALUES (:anio, :fecha_inicio_registro, :fecha_cierre_registro)");

        $stmt->bindParam(":anio", $datos["anio"], PDO::PARAM_INT);
        $stmt->bindParam(":fecha_inicio_registro", $datos["fecha_inicio_registro"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cierre_registro", $datos["fecha_cierre_registro"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            $error = $stmt->errorInfo();
            return $error[2];
        }

        $stmt = null;
    }

    public static function editar($datos)
    {
        // Conectar con la base de datos y preparar la consulta de actualización
        $stmt = Conexion::conectar()->prepare(
            "UPDATE gestion_academica 
             SET anio = :anio, fecha_inicio_registro = :fecha_inicio_registro, fecha_cierre_registro = :fecha_cierre_registro 
             WHERE id = :id"
        );

        // Vincular parámetros
        $stmt->bindParam(":anio", $datos["anio"], PDO::PARAM_INT);
        $stmt->bindParam(":fecha_inicio_registro", $datos["fecha_inicio_registro"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_cierre_registro", $datos["fecha_cierre_registro"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        // Ejecutar y verificar la actualización
        if ($stmt->execute()) {
            return "ok";
        } else {
            $error = $stmt->errorInfo();
            return $error[2];
        }

        // Cerrar la conexión
        $stmt = null;
    }

    /*=============================================
ELIMINAR GESTIÓN ACADÉMICA POR ID
=============================================*/
    static public function eliminar($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM gestion_academica WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    static public function obtenerGestionActual() {
        $anioActual = date("Y");
        $stmt = Conexion::conectar()->prepare("SELECT * FROM gestion_academica WHERE anio = :anioActual");
        $stmt->bindParam(":anioActual", $anioActual, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}
