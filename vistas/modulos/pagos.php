<!-- Content Wrapper. Contains page content -->
<style>
    /* Estilos para desactivar la apariencia del select */
    .readonly {
        pointer-events: none;
        touch-action: none;
        background-color: #e9ecef;
        color: #495057;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pagos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Pagos</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <button type="button" id="btnRegistrarPago" class="btn btn-danger" data-toggle="modal" data-target="#modalAgregar">Registrar Pago</button>

                <div class="card-tools">
                    <form method="GET" action="pagos">
                        <div class="input-group input-group-md my-auto" style="width: 300px;">
                            <input type="text" name="busqueda" class="form-control float-right" placeholder="Buscar" value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover dataTable dtr-inline tablas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Monto</th>
                            <th>Estudiante</th>
                            <th>Apoderado</th>
                            <th>Curso</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
                        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
                        $cantidad = 5;
                        $totalPagos = PagoControlador::contarPagos($busqueda);
                        $totalPaginas = ceil($totalPagos / $cantidad);

                        $pagos = PagoControlador::listar($busqueda, $pagina, $cantidad);
                        foreach ($pagos as $key => $value) {
                            $estudiante = Estudiante::buscarPorId($value["id_estudiante"]);
                            $apoderado = Apoderado::buscarPorId($value["id_apoderado"]);
                            $curso = Curso::listar('id', $value["id_curso"]);
                            $detalle_cuota = DetalleCuota::listar('id', $value["id_detalle_cuotas"]);
                            $usuario = Usuario::listar('id', $value["id_usuario"]);
                            $fecha = date_create($value["fecha"]);

                            $hora = date_format($fecha, "H:i:s");
                            $fechaFormateada = date_format($fecha, "d/m/Y");


                            echo '
                                <tr>
                                <td>' . (($pagina - 1) * $cantidad) + ($key + 1) . '</td>
                                <td class="text-uppercase">' . $fechaFormateada . '</td>
                                <td class="text-uppercase">' . $hora . '</td>
                                <td class="text-uppercase">' . $value["monto"] . '</td>
                                <td class="text-uppercase">' . $estudiante['nombre'] . ' ' . $estudiante['apellidos'] . '</td>
                                <td class="text-uppercase">' . $apoderado['nombre'] . ' ' . $apoderado['apellido'] . '</td>
                                <td class="text-uppercase">' . $curso['curso'] . $curso['paralelo'] .'</td>
                                <td class="text-uppercase">' . $usuario['usuario'] . '</td>
                                <td>
                                    <div class="btn-group">
                                    <button class="btn btn-info btnVerPago" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalMostrar"><i class="fa fa-solid fa-eye" style="color: ;"></i></button>
                                    <button class="btn btn-primary btnDescargarFactura" id="' . $value["id"] . '"><i class="fa fa-solid fa-download"></i> Recibo de pago</button>
                                    </div>
                                    
                                </td>
                                </tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="pagos?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                <a class="page-link" href="pagos?pagina=<?php echo $i; ?>&busqueda=<?php echo $busqueda; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina < $totalPaginas) : ?>
                            <li class="page-item">
                                <a class="page-link" href="pagos?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

        </div>
    </section>
</div>

<!-- Modal agregar -->
<div class="modal fade" id="modalAgregar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="nuevoIdEstudiante">Estudiante</label>
                                <select name="nuevoIdEstudiante" id="nuevoIdEstudiante" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                    $estudiantes = Estudiante::listar('', 0, 100);
                                    foreach ($estudiantes as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellidos"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="nuevoIdApoderado">Apoderado</label>
                                <select name="nuevoIdApoderado" id="nuevoIdApoderado" class="form-control readonly" required>
                                    <option value=""></option>
                                    <?php
                                    $apoderados = Apoderado::listar(0, 100);
                                    foreach ($apoderados as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellido"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="nuevoIdCurso">Curso</label>
                                <select name="nuevoIdCurso" id="nuevoIdCurso" class="form-control readonly" required>
                                    <option value=""></option>
                                    <?php
                                    $cursos = Curso::listar();
                                    foreach ($cursos as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["curso"] . $value["paralelo"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label id="labelDetalleCuotas" for="nuevoIdDetalleCuotas">Nro de cuotas</label>

                                <div class="input-group mb-3">
                                    <select class="custom-select" name="nuevoIdDetalleCuotas" id="nuevoIdDetalleCuotas" required>
                                        <option value="">Seleccionar</option>
                                        <?php
                                        $detalles_cuotas = DetalleCuota::listar();
                                        foreach ($detalles_cuotas as $key => $value) {
                                            echo '<option value="' . $value["id"] . '">' . $value["n_cuotas"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="number" class="form-control readonly" name="nuevoDetalleMonto" id="nuevoDetalleMonto">
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="inputGroupSelect02">Bs</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="nuevoMonto">Monto a pagar</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="nuevoMonto" name="nuevoMonto" required>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="inputGroupSelect02">Bs</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="nuevoRemanente">Saldo</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="nuevoRemanente" name="nuevoRemanente" disabled>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="inputGroupSelect02">Bs</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar Pago</button>
                </div>
                <?php
                $registro = new PagoControlador();
                $registro->crear();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal mostrar -->
<div class="modal fade" id="modalMostrar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Información del Pago</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verFecha">Fecha</label>
                            <input type="date" class="form-control" id="verFecha" name="verFecha" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verHora">Hora</label>
                            <input type="time" class="form-control" id="verHora" name="verHora" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verMonto">Monto</label>
                            <input type="text" class="form-control" id="verMonto" name="verMonto" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verNCuotas">Nro de cuotas</label>
                            <input type="text" class="form-control" id="verNCuotas" name="verNCuotas" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verIdEstudiante">Estudiante</label>

                            <select name="verIdEstudiante" id="verIdEstudiante" class="form-control" disabled>
                                <?php
                                $estudiantes = Estudiante::todos();
                                foreach ($estudiantes as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellidos"] . '</option>';
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verIdApoderado">Apoderado</label>

                            <select name="verIdApoderado" id="verIdApoderado" class="form-control" disabled>
                                <?php
                                $apoderados = Apoderado::listar(0, 100);
                                foreach ($apoderados as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . ' ' . $value["apellido"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verCurso">Curso</label>

                            <select name="verIdCurso" id="verIdCurso" class="form-control" disabled>
                                <?php
                                $cursos = Curso::listar();
                                foreach ($cursos as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["curso"] .$value["paralelo"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="verUsuario">Usuario</label>

                            <select name="verIdUsuario" id="verIdUsuario" class="form-control" disabled>
                                <?php
                                $usuarios = Usuario::listar();
                                foreach ($usuarios as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["usuario"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
  document.getElementById('nuevoMonto').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^0-9]/g, ''); // Reemplaza cualquier cosa que no sea un número
    });
    </script>