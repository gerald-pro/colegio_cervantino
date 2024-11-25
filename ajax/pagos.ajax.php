<?php

require_once "../controladores/PagoControlador.php";
require_once "../modelos/Pago.php";
require_once "../modelos/Estudiante.php";
require_once "../modelos/Apoderado.php";
require_once "../modelos/Curso.php";
require_once('../extensiones/tcpdf/tcpdf.php');

class AjaxPagos
{
    public $id;

    public function ajaxEditarPago()
    {
        $item = "id";
        $valor = $this->id;

        $respuesta = Pago::buscarPorId($valor);
        if ($respuesta) {
            $fecha = date_create($respuesta['fecha']);
            $hora = date_create($respuesta['hora']);
            $respuesta['fecha'] = date_format($fecha, "Y-m-d");
            $respuesta['hora'] = date_format($fecha, "H:i");
            echo json_encode($respuesta);
        } else {
            echo json_encode(["error" => "Pago no encontrado"]);
        }
    }
    public function ajaxDescargarFactura()
    {
        $pago = Pago::buscarPorId($this->id);

        if ($pago) {
            // Crear una nueva instancia de TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Configuración del documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre de la Empresa');
            $pdf->SetTitle('Recibo de pago');
            $pdf->SetSubject('Factura');
            $pdf->SetKeywords('TCPDF, PDF, factura, pago');

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            // Añadir una página
            $pdf->AddPage();

            $logoPath = '../vistas/imagenes/logo-cervantino.png'; // Ruta de la imagen del logo
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 10, 7, 25, 27, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Ajusta la posición y el tamaño según sea necesario
            } else {
                error_log('El archivo de logo no se encuentra en la ruta especificada: ' . $logoPath);
            }

            $fecha = date('Y/m/d', strtotime($pago["fecha"]));
            $hora = date('H:i:s', strtotime($pago["fecha"])); // Extraer solo la hora
            $monto = number_format($pago["monto"], 2);

            // Obtener la información del estudiante, apoderado y curso
            $estudiante = Estudiante::buscarPorId($pago["id_estudiante"]);
            $apoderado = Apoderado::buscarPorId($pago["id_apoderado"]);
            $curso = Curso::listar("id", $pago["id_curso"]);
            $idPago = $pago["id"];
            $nombreEstudiante = $estudiante["nombre"];
            $apellidoEstudiante = $estudiante["apellidos"];
            $fechadenacimientoEstudiante = $estudiante["fechanac"];
            $fechaderegistrotoEstudiante = $estudiante["fecharegistro"];
            $nombreCurso = $curso["curso"];
            $paraleloCurso = $curso["paralelo"];
            $nombreApoderado = $apoderado["nombre"];
            $apellidoApoderado = $apoderado["apellido"];
            $direccionApoderado = $apoderado["direccion"];
            $telefonoApoderado = $apoderado["telefono"];
            $nCuotasPagos = $pago["n_cuotas"];

            // Encabezado de la factura


            //$pdf->Cell(0, 30, 'FACTURA', 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetY(10);
            $pdf->Cell(0, 27, 'RECIBO DE PAGO', 0, 1, 'C');

            $pdf->SetFont('helvetica', '', 10);
            $pdf->MultiCell(
                90,
                22,
                    "Direccion: Av. Che Guevara, Plan 3000\n" .
                    "Telefono: 70480742\n" .
                    "Santa Cruz - Bolivia",
                0,
                'L',
                0,
                0,
                '',
                '',
                true,
            );

            $pdf->MultiCell(
                90,
                22,
                "Actividad:\n" .
                    "Enseñanza preescolar, primaria y secundaria.",
                0,
                'L',
                0,
                1,
                '',
                '',
                true
            );

            $pdf->MultiCell(
                90,
                '',
                "Lugar y fecha: Santa Cruz, $fecha\n" .
                    "Señor(a): $nombreApoderado $apellidoApoderado\n",
                0,
                'L',
                0,
                0,
                '',
                '',
                true,
            );

            $pdf->MultiCell(
                90,
                '',
                "NIT: 14495779\n",
                0,
                'L',
                0,
                0,
                '',
                '',
                true,
            );

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetY(72);
            $pdf->Cell('', 10, 'DETALLE', 0, 1, 'C');

            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetFont('', 'B', 10);

            $pdf->Cell(90, 7, "Estudiante: $nombreEstudiante  $apellidoEstudiante", 0, 0, 'L', 1);
            $pdf->Cell(20, 7, '', 0, 0, 'C', 1);
            $pdf->Cell(30, 7, '', 0, 0, 'C', 1);
            $pdf->Cell(30, 7, "Curso: $nombreCurso$paraleloCurso", 0, 0, 'C', 1);
            $pdf->Ln();

            $pdf->Cell(90, 7, 'Concepto', 1, 0, 'C', 1);
            $pdf->Cell(20, 7, 'Nº Cuotas', 1, 0, 'C', 1);
            $pdf->Cell(30, 7, 'Mensualidad', 1, 0, 'C', 1);
            $pdf->Cell(30, 7, 'Subtotal', 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->Cell(90, 7, 'Mensualidad', 1, 0, 'C', 0);
            $pdf->Cell(20, 7, $nCuotasPagos, 1, 0, 'C', 0);
            $pdf->Cell(30, 7, $monto, 1, 0, 'C', 0);
            $pdf->Cell(30, 7, $monto, 1, 0, 'C', 0);
            $pdf->Ln();

            $pdf->Cell(90, 7, '', 0, 0, 'C', 0);
            $pdf->Cell(20, 7, '', 0, 0, 'C', 0);
            $pdf->Cell(30, 7, 'Total', 0, 0, 'C', 0);
            $pdf->Cell(30, 7, $monto, 1, 0, 'C', 0);

            // Información de contacto de la empresa al final de la página
            $pdf->SetY(-55); // Posición a 30mm desde el final
            $pdf->SetFont('helvetica', 'I', 10);
           

            // Salida del archivo PDF
            $pdf->Output('Factura_' . $this->id . '.pdf', 'I');
        } else {
            echo json_encode(["error" => "Pago no encontrado"]);
        }
    }
}

/*=============================================
DESCARGAR FACTURA
=============================================*/
if (isset($_POST["facturaId"])) {

    $pago = new AjaxPagos();
    $pago->id = $_POST["facturaId"];
    $pago->ajaxDescargarFactura();
}

if (isset($_POST["id"])) {

    $pago = new AjaxPagos();
    $pago->id = $_POST["id"];
    $pago->ajaxEditarPago();
}
