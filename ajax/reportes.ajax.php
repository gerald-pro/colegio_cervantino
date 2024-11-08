<?php

require_once('../extensiones/tcpdf/tcpdf.php');
require_once('../controladores/ReporteControlador.php');
require_once('../modelos/Pago.php');
require_once('../modelos/Curso.php');
require_once('../modelos/Usuario.php');
require_once('../modelos/Estudiante.php');
require_once('../modelos/Apoderado.php');

class AjaxReportes
{
    public $idEstudiante;
    public $idApoderado;
    public $idCurso;

    public function ajaxGenerarReportePagosEstudiante()
    {
        $pagos = Pago::listarPorEstudiante($this->idEstudiante);
        $estudiante = Estudiante::buscarPorId($this->idEstudiante);

        if ($pagos && $estudiante) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre de la Empresa');
            $pdf->SetTitle('Reporte de pagos');
            $pdf->SetSubject('Pagos');
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

            $pdf->AddPage();

            $logoPath = '../vistas/imagenes/logo-cervantino.png'; // Ruta de la imagen del logo
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 10, 7, 25, 27, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Ajusta la posición y el tamaño según sea necesario
            } else {
                error_log('El archivo de logo no se encuentra en la ruta especificada: ' . $logoPath);
            }

            $fecha = date('Y/m/d');
            $nombreEstudiante = $estudiante["nombre"];
            $apellidoEstudiante = $estudiante["apellidos"];
            $apoderado = Apoderado::buscarPorId($estudiante["id_apoderado"]);
            $nombreApoderado = $apoderado["nombre"];
            $apellidoApoderado = $apoderado["apellido"];

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetY(10);
            $pdf->Cell(0, 27, 'REPORTE DE PAGOS POR ESTUDIANTE', 0, 1, 'C');

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
                "Estudiante: $nombreEstudiante $apellidoEstudiante\n" .
                    "Apoderado: $nombreApoderado $apellidoApoderado\n",
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
                "Lugar y fecha: Santa Cruz, $fecha \n",
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
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetFont('', 'B', 10);

            $pdf->Cell(28, 7, 'Fecha', 1, 0, 'C', 1);
            $pdf->Cell(20, 7, 'Curso', 1, 0, 'C', 1);
            $pdf->Cell(45, 7, 'Usuario', 1, 0, 'C', 1);
            $pdf->Cell(45, 7, 'Apoderado', 1, 0, 'C', 1);
            $pdf->Cell(25, 7, 'Monto', 1, 0, 'C', 1);
            $pdf->Ln();

            // Contenido de la tabla
            foreach ($pagos as $pago) {
                $fecha = date('d/m/Y', strtotime($pago["fecha"]));
                $monto = number_format($pago["monto"], 2);
                $curso = Curso::listar('id', $pago["id_curso"]);
                $usuario = Usuario::listar('id', $pago["id_usuario"]);

                $apoderadoPago = Apoderado::buscarPorId($pago["id_apoderado"]);
                $nombreApoderadoPago = $apoderadoPago["nombre"];
                $apellidoApoderadoPago = $apoderadoPago["apellido"];


                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(28, 8, $fecha, 1);
                $pdf->Cell(20, 8, $curso['curso'] . $curso['paralelo'], 1);
                $pdf->Cell(45, 8, $usuario['usuario'], 1);
                $pdf->Cell(45, 8, "$nombreApoderadoPago $apellidoApoderadoPago", 1);
                $pdf->Cell(25, 8, $monto, 1);
                $pdf->Ln();
            }

            $pdf->Output('Reporte_Pagos_Estudiante_' . $this->idEstudiante . '.pdf', 'I');
        } else {
            echo json_encode(["error" => "No se encontraron pagos para este estudiante."]);
        }
    }

    public function ajaxGenerarReportePagosApoderado()
    {
        $pagos = Pago::listarPorApoderado($this->idApoderado);
        $apoderado = Apoderado::buscarPorId($this->idApoderado);
        $nombreApoderado = $apoderado["nombre"];
        $apellidoApoderado = $apoderado["apellido"];


        if ($apoderado) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre de la Empresa');
            $pdf->SetTitle('Reporte de pagos');
            $pdf->SetSubject('Pagos');
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

            $pdf->AddPage();

            $logoPath = '../vistas/imagenes/logo-cervantino.png'; // Ruta de la imagen del logo
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 10, 7, 25, 27, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Ajusta la posición y el tamaño según sea necesario
            } else {
                error_log('El archivo de logo no se encuentra en la ruta especificada: ' . $logoPath);
            }

            $fecha = date('Y/m/d');

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetY(10);
            $pdf->Cell(0, 27, 'REPORTE DE PAGOS POR APODERADO', 0, 1, 'C');

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
                "Apoderado: $nombreApoderado $apellidoApoderado\n",
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
                "Lugar y fecha: Santa Cruz, $fecha \n",
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
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetFont('', 'B', 10);

            $pdf->Cell(28, 7, 'Fecha', 1, 0, 'C', 1);
            $pdf->Cell(20, 7, 'Curso', 1, 0, 'C', 1);
            $pdf->Cell(45, 7, 'Usuario', 1, 0, 'C', 1);
            $pdf->Cell(45, 7, 'Estudiante', 1, 0, 'C', 1);
            $pdf->Cell(25, 7, 'Monto', 1, 0, 'C', 1);
            $pdf->Ln();

            // Contenido de la tabla
            foreach ($pagos as $pago) {
                $fecha = date('d/m/Y', strtotime($pago["fecha"]));
                $monto = number_format($pago["monto"], 2);
                $curso = Curso::listar('id', $pago["id_curso"]);
                $usuario = Usuario::listar('id', $pago["id_usuario"]);

                $estudiante = Estudiante::buscarPorId($pago["id_estudiante"]);
                $nombreEstudiante = $estudiante["nombre"];
                $apellidoEstudiante = $estudiante["apellidos"];


                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(28, 8, $fecha, 1);
                $pdf->Cell(20, 8, $curso['curso'] . $curso['paralelo'], 1);
                $pdf->Cell(45, 8, $usuario['usuario'], border: 1);
                $pdf->Cell(45, 8, "$nombreEstudiante $apellidoEstudiante", 1);
                $pdf->Cell(25, 8, $monto, 1);
                $pdf->Ln();
            }

            $pdf->Output('Reporte_Pagos_Estudiante_' . $this->idEstudiante . '.pdf', 'I');
        } else {
            echo json_encode(["error" => "No se encontraron pagos para este estudiante."]);
        }
    }

    public function ajaxGenerarReporteEstudiantesCurso()
    {
        $estudiantes = Estudiante::listarPorCurso($this->idCurso);
        $curso = Curso::listar('id', $this->idCurso);
        $numCurso = $curso["curso"];
        $paraleloCurso = $curso["paralelo"];

        if ($curso) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nombre de la Empresa');
            $pdf->SetTitle('Reporte de pagos');
            $pdf->SetSubject('Pagos');
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

            $pdf->AddPage();

            $logoPath = '../vistas/imagenes/logo-cervantino.png'; // Ruta de la imagen del logo
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, 10, 7, 25, 27, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Ajusta la posición y el tamaño según sea necesario
            } else {
                error_log('El archivo de logo no se encuentra en la ruta especificada: ' . $logoPath);
            }

            $fecha = date('Y/m/d');

            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->SetY(10);
            $pdf->Cell(0, 27, 'REPORTE DE ESTUDIANTES POR CURSO', 0, 1, 'C');

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
                "Curso: $numCurso $paraleloCurso\n",
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
                "Lugar y fecha: Santa Cruz, $fecha \n",
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
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetFont('', 'B', 10);

            $pdf->Cell(45, 7, 'Nombre', 1, 0, 'C', 1);
            $pdf->Cell(33, 7, 'Fecha Nacimiento', 1, 0, 'C', 1);
            $pdf->Cell(27, 7, ' Fecha registro', 1, 0, 'C', 1);
            $pdf->Cell(35, 7, 'Correo', 1, 0, 'C', 1);
            $pdf->Cell(41, 7, 'Apoderado', 1, 0, 'C', 1);
            $pdf->Ln();

            // Contenido de la tabla
            foreach ($estudiantes as $estudiante) {
                $fechaRegistro = date('d/m/Y', strtotime($estudiante["fecharegistro"]));
                $fechanac = date('d/m/Y', strtotime($estudiante["fechanac"]));
                
                $nombreEstudiante = $estudiante['nombre'];
                $apellidoEstudiante = $estudiante['apellidos'];
                $correo = $estudiante['correo'];
                $apoderado = Apoderado::buscarPorId($estudiante["id_apoderado"]);
                $nombreApoderado = $apoderado["nombre"];
                $apellidoApoderado = $apoderado["apellido"];

                $pdf->SetFont('helvetica', 'R', 10);
                $pdf->Cell(45, 8, "$nombreEstudiante $apellidoEstudiante", 1);
                $pdf->Cell(33, 8, $fechanac, 1);
                $pdf->Cell(27, 8, $fechaRegistro, 1);
                $pdf->Cell(35, 8, $correo, 1);
                $pdf->Cell(41, 8, "$nombreApoderado $apellidoApoderado", border: 1);

                $pdf->Ln();
            }

            $pdf->Output('Reporte_Estudiantes' . $numCurso . $paraleloCurso . '.pdf', 'I');
        } else {
            echo json_encode(["error" => "No se encontraron estudiantes"]);
        }
    }
}

if (isset($_POST["idEstudiante"])) {
    $reporte = new AjaxReportes();
    $reporte->idEstudiante = $_POST["idEstudiante"];
    $reporte->ajaxGenerarReportePagosEstudiante();
}

if (isset($_POST["idApoderado"])) {
    $reporte = new AjaxReportes();
    $reporte->idApoderado = $_POST["idApoderado"];
    $reporte->ajaxGenerarReportePagosApoderado();
}

if (isset($_POST["idCurso"])) {
    $reporte = new AjaxReportes();
    $reporte->idCurso = $_POST["idCurso"];
    $reporte->ajaxGenerarReporteEstudiantesCurso();
}

if (isset($_POST["cursosMasEstudiantes"])) {
    $pdfContent = ReporteControlador::cursosConMasEstudiantesPDF();
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["fechaInicioRegistro"]) && isset($_POST["fechaFinRegistro"])) {
    $fechaInicio = $_POST["fechaInicioRegistro"];
    $fechaFin = $_POST["fechaFinRegistro"];

    $pdfContent = ReporteControlador::estudiantesPorFechaRegistroPDF($fechaInicio, $fechaFin);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}

if (isset($_POST["fechaInicioPago"]) && isset($_POST["fechaFinPago"])) {
    $fechaInicio = $_POST["fechaInicioPago"];
    $fechaFin = $_POST["fechaFinPago"];

    $pdfContent = ReporteControlador::pagosPorPeriodoPDF($fechaInicio, $fechaFin);
    if ($pdfContent !== false) {
        header('Content-Type: application/pdf');
        echo $pdfContent;
    } else {
        echo "Error al generar el PDF";
    }
    exit;
}
