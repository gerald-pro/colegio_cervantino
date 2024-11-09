<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Estudiantes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Estudiante
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
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAgregar">Registrar
                    Estudiante</button>

                <div class="card-tools">
                    <form method="GET" action="estudiantes">
                        <div class="input-group my-auto">
                            <input type="text" class="form-control" placeholder="Buscar estudiante..." name="busqueda" value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button> -->
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover dataTable dtr-inline tablas" aria-describedby="example2_info">
                    <thead>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Motor de renderizado: actívelo para ordenar las columnas de forma descendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">#</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Navegador: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Nombre</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Plataforma(s): activar para ordenar la columna de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Apellido</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Telefono</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Fecha de nacimiento</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Fecha registro</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Curso</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Apoderado </font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Acciones</font>
                                </font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
                        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                        $cantidad = 5;
                        $estudiantes = EstudianteControlador::listar($busqueda, $pagina, $cantidad);
                        $totalEstudiantes = EstudianteControlador::contarEstudiantes($busqueda);
                        $totalPaginas = ceil($totalEstudiantes / $cantidad);

                        foreach ($estudiantes as $key => $value) {
                            $curso = Curso::listar('id', $value["id_curso"]);
                            $apoderado = Apoderado::buscarPorId($value["id_apoderado"]);

                            echo '
                            <tr>
                                <td>' . (($pagina-1) * $cantidad) + ($key + 1) . '</td>
                                <td class="text-uppercase">' . $value["nombre"] . '</td>
                                <td class="text-uppercase">' . $value["apellidos"] . '</td>
                                <td class="text-uppercase">' . $value["telefono"] . '</td>
                                <td class="text-uppercase">' . $value["fechanac"] . '</td>
                                <td class="text-uppercase">' . $value["fecharegistro"] . '</td>
                                <td class="text-uppercase">' . $curso['curso'] . $curso['paralelo'] . '</td>
                                <td class="text-uppercase">' . $apoderado['nombre'] . ' ' . $apoderado['apellido'] . '</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-info btnVerEstudiante" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalMostrar"><i class="fa fa-solid fa-eye" style="color: white;"></i></button>
                                        <button class="btn btn-warning btnEditarEstudiante" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditar"><i class="fa fa-solid fa-pen" style="color: white;"></i></button>
                                        <button class="btn btn-danger btnEliminarEstudiante" id="' . $value["id"] . '"><i class="fa fa-trash" style="color: white;"></i></button>
                                    </div>
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                <a class="page-link" href="estudiantes?pagina=<?php echo $i; ?>&busqueda=<?php echo $busqueda; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Modal agregar -->
<div class="modal fade" id="modalAgregar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Estudiante</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nuevoNombre">Nombre</label>
                                <input type="text" class="form-control" id="nuevoNombre" name="nuevoNombre" placeholder="Ingrese Nombre">
                                <input type="hidden" name="id" id="id" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nuevoApellido">Apellido</label>
                                <input type="text" class="form-control" id="nuevoApellido" name="nuevoApellido" placeholder="Ingrese Apellido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nuevaDireccion">Direccion</label>
                                <input type="text" class="form-control" id="nuevaDireccion" name="nuevaDireccion" placeholder="Ingrese Direccion">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nuevoTelefono">Telefono</label>
                                <input type="number" class="form-control" id="nuevoTelefono" name="nuevoTelefono" placeholder="Ingrese Telefono">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nuevoCorreo">Correo</label>
                                <input type="email" class="form-control" id="nuevoCorreo" name="nuevoCorreo" placeholder="Ingrese Correo">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nuevaFechaNac">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="nuevaFechaNac" name="nuevaFechaNac" placeholder="Ingrese Fecha de nacimiento">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nuevoIdCurso">Curso</label>
                                <select name="nuevoIdCurso" id="nuevoIdCurso" class="form-control">
                                    <?php
                                    $cursos = Curso::listar();
                                    foreach ($cursos as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["curso"] . $value["paralelo"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nuevoIdApoderado">Apoderado</label>
                                <select name="nuevoIdApoderado" id="nuevoIdApoderado" class="form-control">
                                    <?php
                                    $apoderados = Apoderado::listar(0, 100);
                                    foreach ($apoderados as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . " " . $value["apellido"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>
                <?php
                $nuevo = new EstudianteControlador();
                $nuevo->crear();
                ?>
            </form>
        </div>
    </div>
</div>

<!-- Modal ver -->
<div class="modal fade" id="modalMostrar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Ver Estudiante</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verNombre">Nombre</label>
                            <input type="text" class="form-control" id="verNombre" name="verNombre" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verApellido">Apellido</label>
                            <input type="text" class="form-control" id="verApellido" name="verApellido" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verDireccion">Direccion</label>
                            <input type="text" class="form-control" id="verDireccion" name="verDireccion" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verCorreo">Correo</label>
                            <input type="email" class="form-control" id="verCorreo" name="verCorreo" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verTelefono">Telefono</label>
                            <input type="number" class="form-control" id="verTelefono" name="verTelefono" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verFechaNac">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="verFechaNac" name="verFechaNac" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verCurso">Curso</label>
                            <select name="verIdCurso" id="verIdCurso" class="form-control" disabled>
                                <?php
                                $cursos = Curso::listar();
                                foreach ($cursos as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["curso"] . $value["paralelo"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verApoderado">Apoderado</label>
                            <select name="verApoderado" id="verApoderado" class="form-control" disabled>
                                <?php
                                $apoderados = Apoderado::listar(0, 100);
                                foreach ($apoderados as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . " " . $value["apellido"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="verFechaReg">Fecha de registro</label>
                            <input type="date" class="form-control" id="verFechaReg" name="verFechaReg" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="verfechaAct">Fecha de actualizacion</label>
                            <input type="datetime" class="form-control" id="verfechaAct" name="verfechaAct" readonly>
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


<!-- Modal editar -->
<div class="modal fade" id="modalEditar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Editar estudiante</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="editarNombre">Nombre</label>
                                <input type="text" class="form-control" id="editarNombre" name="editarNombre" placeholder="Ingrese Nombre">
                                <input type="hidden" name="idEstudiante" id="idEstudiante" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="editarApellido">Apellido</label>
                                <input type="text" class="form-control" id="editarApellido" name="editarApellido" placeholder="Ingrese Apellido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="editarDireccion">Direccion</label>
                                <input type="text" class="form-control" id="editarDireccion" name="editarDireccion" placeholder="Ingrese Direccion">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="editarCorreo">Correo</label>
                                <input type="email" class="form-control" id="editarCorreo" name="editarCorreo" placeholder="Ingrese Correo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="editarTelefono">Telefono</label>
                                <input type="number" class="form-control" id="editarTelefono" name="editarTelefono" placeholder="Ingrese Telefono">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="editarFechaNac">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="editarFechaNac" name="editarFechaNac" placeholder="Ingrese fecha de nacimiento">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="editarIdCurso">Curso</label>
                                <select name="editarIdCurso" id="editarIdCurso" class="form-control">
                                    <?php
                                    $cursos = Curso::listar();
                                    foreach ($cursos as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["curso"] . $value["paralelo"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="editarIdApoderado">Apoderado</label>
                                <select name="editarIdApoderado" id="editarIdApoderado" class="form-control">
                                    <?php
                                    $apoderados = Apoderado::listar(0, 100);
                                    foreach ($apoderados as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["nombre"] . " " . $value["apellido"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>
                <?php
                $editarestudiante = new EstudianteControlador();
                $editarestudiante->editar();
                ?>
            </form>
        </div>
    </div>
</div>

<?php
$borrar = new EstudianteControlador();
$borrar->eliminar();
?>

<script>
    document.getElementById('nuevoNombre').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Reemplaza cualquier cosa que no sea letra o espacio
    });
    document.getElementById('nuevoApellido').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Reemplaza cualquier cosa que no sea letra o espacio
    });
    document.getElementById('nuevoTelefono').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^0-9]/g, ''); // Reemplaza cualquier cosa que no sea un número
    });
   
</script>