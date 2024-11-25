<?php

require_once "../controladores/EstudianteControlador.php";
require_once "../modelos/Estudiante.php";
require_once "../modelos/Pago.php";

class AjaxEstudiante{

    /*=============================================
    EDITAR ESTUDIANTE
    =============================================*/

    public $id;

    public function ajaxEditarEstudiante(){
        $item = "id";
        $valor = $this->id;

        $respuesta = Estudiante::buscarPorId($valor);
        if ($respuesta) {
            $totalCuotasPagadas = Pago::totalCuotasPagadas($this->id);
            $respuesta['total_cuotas_pagadas'] = $totalCuotasPagadas;
            echo json_encode($respuesta);
        } else {
            echo json_encode(["error" => "Estudiante no encontrado"]);
        }
    }
}

/*=============================================
EDITAR ESTUDIANTE
=============================================*/
if(isset($_POST["id"])){
    $estudiante = new AjaxEstudiante();
    $estudiante -> id = $_POST["id"];
    $estudiante -> ajaxEditarEstudiante();
}
