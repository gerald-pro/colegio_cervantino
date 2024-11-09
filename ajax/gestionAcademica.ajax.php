<?php

require_once "../modelos/GestionAcademica.php";

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    $respuesta = GestionAcademica::buscarPorId($id);

    if ($respuesta) {
        echo json_encode($respuesta);
    } else {
        echo json_encode(["error" => "No se encontró la gestión académica."]);
    }
}