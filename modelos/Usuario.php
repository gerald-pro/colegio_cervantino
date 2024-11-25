<?php

require_once "conexion.php";

class Usuario
{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function listar($item = null, $valor = null)
	{

		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE $item = :$item");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuario");
			$stmt->execute();
			return $stmt->fetchAll();
		}
	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($datos)
	{
		$stmt = Conexion::conectar()->prepare("SELECT id FROM usuario WHERE usuario = :usuario");
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return "El nombre de usuario ya existe";
		}

		$stmt = Conexion::conectar()->prepare("SELECT id FROM usuario WHERE correo = :correo");
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			return "El el correo electrónico ya está registrado";
		}

		$stmt = Conexion::conectar()->prepare("INSERT INTO usuario (usuario, correo, password, fecha) VALUES (:usuario, :correo, :password, :fecha)");
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($datos)
	{
		$stmt = Conexion::conectar()->prepare("SELECT id FROM usuario WHERE (usuario = :usuario) AND id != :id");
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
			return "El nombre de usuario ya existe";
		}

		$stmt = Conexion::conectar()->prepare("SELECT id FROM usuario WHERE (correo = :correo) AND id != :id");
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->execute();

		if ($stmt->rowCount() > 0) {
			return "El el correo electrónico ya está registrado";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE usuario SET usuario = :usuario, correo = :correo, fecha = :fecha WHERE usuario = :usuario");
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			$error = $stmt->errorInfo()[2];
			return $error;
		}
	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	}
}
