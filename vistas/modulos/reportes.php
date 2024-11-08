<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Reportes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Reportes</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="card-body">
          <form id="formReportePagosEstudiante">
            <div class="form-group">
              <label for="estudiante">Reporte de pagos por estudiante</label>
              <div class="input-group">
                <select class="form-control" id="estudiante" name="estudiante">
                  <option value="">-- Seleccionar estudiante--</option>
                  <?php
                  $estudiantes = Estudiante::todos();
                  foreach ($estudiantes as $key => $value) {
                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellidos"] . '</option>';
                  }
                  ?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-solid fa-download"></i> Generar Reporte</button>
                </div>
              </div>
            </div>
          </form>

          <hr>

          <form id="formReportePagosApoderado">
            <div class="form-group">
              <label for="apoderado">Reporte de pagos por apoderado</label>
              <div class="input-group">
                <select class="form-control" id="apoderado" name="apoderado">
                  <option value="">-- Seleccionar apoderado--</option>
                  <?php
                  $apoderados = Apoderado::todos();
                  foreach ($apoderados as $key => $value) {
                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellido"] . '</option>';
                  }
                  ?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-solid fa-download"></i> Generar Reporte</button>
                </div>
              </div>
            </div>
          </form>

          <hr>

          <form id="formReporteEstudiantesCurso">
            <div class="form-group">
              <label for="apoderado">Reporte de estudiantes por curso</label>
              <div class="input-group">
                <select class="form-control" id="curso" name="curso">
                  <option value="">-- Seleccionar curso--</option>
                  <?php
                  $cursos = Curso::listar();
                  foreach ($cursos as $key => $value) {
                    echo '<option value="' . $value["id"] . '">' . $value["curso"] . ' ' . $value["paralelo"] . '</option>';
                  }
                  ?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-solid fa-download"></i> Generar Reporte</button>
                </div>
              </div>
            </div>
          </form>

          <hr>

          <label for="apoderado">Reporte de cursos con mayor numero de estudiantes</label>
          <button type="button" class="btn btn-primary" onclick="generarCursosConMasEstudiantesPDF()">Descargar PDF</button>

          <hr>

          <label for="apoderado">Reporte de estudiantes por fecha de registro</label>

          <form id="formReporteRegistro" method="post">
            <div class="form-row align-items-center">
              <div class="col">
                <input type="date" class="form-control" id="fechaInicioRegistro" name="fechaInicioRegistro" required placeholder="Fecha Inicio">
              </div>
              <div class="col">
                <input type="date" class="form-control" id="fechaFinRegistro" name="fechaFinRegistro" required placeholder="Fecha Fin">
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-success" onclick="generarEstudiantesPorFechaPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
              </div>
            </div>
          </form>

          <hr>

          <label for="apoderado">Reporte de actividad de pagos por fecha</label>

          <form id="formReportePeriodo" method="post">
            <div class="form-row align-items-center">
              <div class="col">
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required placeholder="Fecha Inicio">
              </div>
              <div class="col">
                <input type="date" class="form-control" id="fechaFin" name="fechaFin" required placeholder="Fecha Fin">
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-success" onclick="generarPagosPorPeriodoPDF()"><i class="fa fa-download" aria-hidden="true"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </section>
</div>