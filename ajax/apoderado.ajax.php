<?php

require_once "../controladores/ApoderadoControlador.php";
require_once "../modelos/Apoderado.php";

class AjaxApoderado{

    /*=============================================
    EDITAR APODERADO
    =============================================*/

    public $id;

    public function ajaxEditarApoderado(){
        $valor = $this->id;
        $respuesta = Apoderado::buscarPorId($valor);

        echo json_encode($respuesta);

    }
}

/*=============================================
EDITAR APODERADO
=============================================*/
if(isset($_POST["id"])){

    $apoderado = new AjaxApoderado();
    $apoderado -> id = $_POST["id"];
    $apoderado -> ajaxEditarApoderado();
}
