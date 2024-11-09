<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión Académica</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión Académica</li>
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
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAgregarGestion">Registrar Gestión</button>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div><!-- /.card-header -->

            <div class="card-body">
                <table class="table table-bordered table-hover dataTable dtr-inline tablas" aria-describedby="example2_info">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Año</th>
                            <th>Fecha de Inicio de Registro</th>
                            <th>Fecha de Cierre de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;

                        $gestiones = GestionAcademicaControlador::listar($item, $valor);

                        foreach ($gestiones as $key => $value) {
                            echo ' <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $value["anio"] . '</td>
                            <td>' . $value["fecha_inicio_registro"] . '</td>
                            <td>' . $value["fecha_cierre_registro"] . '</td>
                            <td>
                            <div class="btn-group">
                            <button class="btn btn-warning btnEditarGestion" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarGestion"><i class="fa fa-solid fa-pen" style="color: white;"></i></button>
                            <button class="btn btn-danger btnEliminarGestion" id="' . $value["id"] . '" gestion="' . $value["anio"] . '"><i class="fa fa-trash" style="color: white;"></i></button>
                            </div> 
                            </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal para agregar gestión -->
<div class="modal fade" id="modalAgregarGestion">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Gestión Académica</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" min="2000" max="3000" class="form-control" id="NuevoAnio" name="NuevoAnio" placeholder="Ingrese el año de la gestión" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha de Inicio de Registro</label>
                        <input type="date" class="form-control" id="FechaInicioRegistro" name="FechaInicioRegistro" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha de Cierre de Registro</label>
                        <input type="date" class="form-control" id="FechaCierreRegistro" name="FechaCierreRegistro" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>

                <?php
                $crearGestion = new GestionAcademicaControlador();
                $crearGestion->crear();
                ?>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal para editar gestión -->
<div class="modal fade" id="modalEditarGestion">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Gestión Académica</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" class="form-control" id="EditarAnio" name="EditarAnio" min="2000" max="3000">
                        <input type="hidden" name="idGestion" id="idGestion" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha de Inicio de Registro</label>
                        <input type="date" class="form-control" id="EditarFechaInicioRegistro" name="EditarFechaInicioRegistro" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha de Cierre de Registro</label>
                        <input type="date" class="form-control" id="EditarFechaCierreRegistro" name="EditarFechaCierreRegistro" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>

                <?php
                $editarGestion = new GestionAcademicaControlador();
                $editarGestion->editar();
                ?>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$borrarGestion = new GestionAcademicaControlador();
$borrarGestion->eliminar();
?>