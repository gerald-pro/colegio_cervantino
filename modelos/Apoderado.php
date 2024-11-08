<?php

require_once "conexion.php";

class Apoderado
{
    static public function todos() {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM apoderado");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*=============================================
    MOSTRAR APODERADOS
    =============================================*/
    static public function listar($offset = 0, $cantidad = 5) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM apoderado LIMIT :cantidad OFFSET :offset");
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    static public function buscar($busqueda, $offset = 0, $cantidad = 5) {
        $busqueda = "%$busqueda%";  // Para hacer búsquedas con comodines
    
        $stmt = Conexion::conectar()->prepare(
            "SELECT * FROM apoderado 
             WHERE nombre LIKE :busqueda 
             OR apellido LIKE :busqueda 
             OR telefono LIKE :busqueda 
             LIMIT :cantidad OFFSET :offset"
        );
    
        $stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
        $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll();
    }

    static public function buscarPorId($id) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM apoderado WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    static public function contar($busqueda = "") {
        if (!empty($busqueda)) {
            $busqueda = "%$busqueda%";
            $stmt = Conexion::conectar()->prepare(
                "SELECT COUNT(*) as total FROM apoderado 
                 WHERE nombre LIKE :busqueda 
                 OR apellido LIKE :busqueda 
                 OR telefono LIKE :busqueda"
            );
            $stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM apoderado");
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }

    /*=============================================
    REGISTRO DE APODERADO
    =============================================*/
    static public function crear($datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO apoderado (nombre, apellido, direccion, telefono, id_usuario) VALUES (:nombre, :apellido, :direccion, :telefono, :id_usuario)");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    EDITAR APODERADO
    =============================================*/
    static public function editar($datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE apoderado SET nombre = :nombre, apellido = :apellido, Direccion = :direccion, telefono = :telefono, id_usuario = :id_usuario WHERE id = :id");
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }

    /*=============================================
    BORRAR APODERADO
    =============================================*/
    static public function eliminar($datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM apoderado WHERE id = :id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}
