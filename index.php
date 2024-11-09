<?php
require_once "controladores/PlantillaControlador.php";
require_once "controladores/ApoderadoControlador.php";
require_once "controladores/CursoControlador.php";
require_once "controladores/DetalleCuotasControlador.php";
require_once "controladores/PagoControlador.php";
require_once "controladores/UsuarioControlador.php";
require_once "controladores/Estudiantecontrolador.php";
require_once "controladores/GestionAcademicaControlador.php";

require_once "modelos/Apoderado.php";
require_once "modelos/Curso.php";
require_once "modelos/Detallecuota.php";
require_once "modelos/Pago.php";
require_once "modelos/Usuario.php";
require_once "modelos/Estudiante.php";
require_once "modelos/GestionAcademica.php";

date_default_timezone_set('America/La_Paz');

$plantilla=new PlantillaControlador();
$plantilla->ctrPlantilla();

