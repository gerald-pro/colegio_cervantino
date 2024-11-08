<?php

require_once('../extensiones/tcpdf/tcpdf.php');
require_once('../modelos/Curso.php');

class ReporteControlador
{
    static public function cursosConMasEstudiantesPDF()
    {
        $cursos = Curso::listarConMasEstudiantes(); // Método en el modelo Curso

        $pdf = new TCPDF();

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
        $pdf->Cell(0, 27, "REPORTE DE NUM DE ESTUDIANTES POR CURSO", 0, 1, 'C');

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

        $pdf->SetY(55);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(60, 8, 'Curso', 1, '', "C");
        $pdf->Cell(60, 8, 'Paralelo', 1, '', "C");
        $pdf->Cell(60, 8, 'Cantidad de Estudiantes', 1, '', "C");
        $pdf->Ln();

        if ($cursos) {
            foreach ($cursos as $curso) {
                $pdf->Cell(60, 8, $curso['curso'], 1);
                $pdf->Cell(60, 8, $curso['paralelo'], 1, '', 'C');
                $pdf->Cell(60, 8, $curso['cantidad_estudiantes'], 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron cursos con estudiantes.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function estudiantesPorFechaRegistroPDF($fechaInicio, $fechaFin)
    {
        $estudiantes = Estudiante::listarPorFechaRegistro($fechaInicio, $fechaFin); // Método en el modelo Estudiante


        $pdf = new TCPDF();
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

        $fecha = new DateTime("now", new DateTimeZone('America/La_Paz'));

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetY(10);
        $pdf->Cell(0, 27, "REPORTE DE ESTUDIANTES POR FECHA DE REGISTRO", 0, 1, 'C');

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
            '',
            "Lugar y fecha: Santa Cruz, ". $fecha->format('d-m-Y H:i:s') ." \n",
            0,
            'L',
            0,
            0,
            '',
            '',
            true,
        );

        $pdf->SetY(y: 58);
        $pdf->Cell(0, 6, 'Período: ' . date("d/m/Y", strtotime($fechaInicio)) . ' - ' . date("d/m/Y", strtotime($fechaFin)), 0, 1);



        $pdf->SetFont('helvetica', '', 12);

        $pdf->SetY(y: 68);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(50, 8, 'Nombre', 1, '', "C");
        $pdf->Cell(60, 8, 'Correo', 1, '', "C");
        $pdf->Cell(28, 8, 'Teléfono', 1, '', "C");
        $pdf->Cell(38, 8, 'Fecha de Registro', 1, '', "C");


        $pdf->Ln();
        if ($estudiantes) {
            foreach ($estudiantes as $estudiante) {
                $fechaRegistro = date("d/m/Y", strtotime($estudiante['fecharegistro']));

                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(60, 8, $estudiante['correo'], 1);
                $pdf->Cell(28, 8, $estudiante['telefono'], 1);
                $pdf->Cell(38, 8, $fechaRegistro, 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes para el período seleccionado.', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }

    static public function pagosPorPeriodoPDF($fechaInicio, $fechaFin)
    {
        $pagos = Pago::listarPorPeriodo($fechaInicio, $fechaFin); // Método en el modelo Pago

        $pdf = new TCPDF();
        

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

        $fecha = new DateTime("now", new DateTimeZone('America/La_Paz'));

        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetY(10);
        $pdf->Cell(0, 27, "REPORTE DE PAGOS POR PERIODO", 0, 1, 'C');

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
            '',
            "Lugar y fecha: Santa Cruz, ". $fecha->format('d-m-Y H:i:s') ." \n",
            0,
            'L',
            0,
            0,
            '',
            '',
            true,
        );

        $pdf->SetY(y: 62);

        $pdf->Cell(0, 6, 'Período: ' . date("d/m/Y", strtotime($fechaInicio)) . ' - ' . date("d/m/Y", strtotime($fechaFin)), 0, 1);

        $pdf->SetY(72);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(40, 8, 'Fecha', 1, '', "C");
        $pdf->Cell(50, 8, 'Estudiante', 1, '', "C");
        $pdf->Cell(50, 8, 'Apoderado', 1, '', "C");
        $pdf->Cell(25, 8, 'Monto (Bs)', 1, '', "C");
        $pdf->Ln();

        if ($pagos) {
            foreach ($pagos as $pago) {
                $fechaPago = date("d/m/Y H:i", strtotime($pago['fecha']));
                $estudiante = Estudiante::buscarPorId( $pago['id_estudiante']);
                $apoderado = Apoderado::buscarPorId($pago['id_apoderado']);

                $pdf->Cell(40, 8, $fechaPago, 1);
                $pdf->Cell(50, 8, $estudiante['nombre'] . ' ' . $estudiante['apellidos'], 1);
                $pdf->Cell(50, 8, $apoderado['nombre'] . ' ' . $apoderado['apellido'], 1);
                $pdf->Cell(25, 8, $pago['monto'], 1, '', 'R');
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(175, 8, 'No se encontraron estudiantes para este apoderado', 0, 0, "C");
        }

        return $pdf->Output('', 'S');
    }
}
