<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Apoderados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Apoderado
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
                    Apoderado</button>

                <div class="card-tools">
                    <form method="GET" action="apoderados">
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
                <table class="table table-bordered table-hover dataTable dtr-inline tablas"
                    aria-describedby="example2_info">
                    <thead>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                colspan="1" aria-sort="ascending"
                                aria-label="Motor de renderizado: actívelo para ordenar las columnas de forma descendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">#</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Navegador: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Nombre</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Plataforma(s): activar para ordenar la columna de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Apellido</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Versión del motor: activar para ordenar columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Direccion</font>
                                </font>
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Telefono</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Usuario</font>
                                </font>
                            </th>

                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="Calificación CSS: activar para ordenar las columnas de forma ascendente">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Acciones</font>
                                </font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener el término de búsqueda si existe
                        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
                        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
                        $cantidad = 5; // Número de resultados por página
                        $totalApoderados = ApoderadoControlador::contarApoderados($busqueda); // Método para contar el total de resultados
                        $totalPaginas = ceil($totalApoderados / $cantidad);

                        // Llamar al método listar del controlador
                        $apoderados = ApoderadoControlador::listar($busqueda, $pagina, $cantidad);

                        foreach ($apoderados as $key => $value) {
                            echo ' <tr>
                            <td>' . ($key + 1) . '</td>
                            <td class="text-uppercase">' . $value["nombre"] . '</td>
                            <td class="text-uppercase">' . $value["apellido"] . '</td>
                            <td class="text-uppercase">' . $value["direccion"] . '</td>
                            <td class="text-uppercase">' . $value["telefono"] . '</td>
                            <td class="text-uppercase">' . UsuarioControlador::listar('id', $value["id_usuario"])['usuario'] . '</td>
                            <td>
                            <div class="btn-group">
                            <button class="btn btn-warning btnEditarApoderado" id="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditar"><i class="fa fa-solid fa-pen" style="color: white;"></i></button>
                            <button class="btn btn-danger btnEliminarApoderado" id="' . $value["id"] . '"><i class="fa fa-trash" style="color: white;"></i></button>
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
                                <a class="page-link" href="apoderados?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                                <a class="page-link" href="apoderados?pagina=<?php echo $i; ?>&busqueda=<?php echo $busqueda; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina < $totalPaginas) : ?>
                            <li class="page-item">
                                <a class="page-link" href="apoderados?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalAgregar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Apoderado</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="example">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Nombre</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="NuevoNombre" name="NuevoNombre"
                            placeholder="Ingrese Nombre">
                        <input type="hidden" name="id" id="id" required>
                    </div>

                    <div class="form-group">
                        <label>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Apellido</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="NuevoApellido" name="NuevoApellido"
                            placeholder="Ingrese Apellido">
                    </div>

                    <div class="form-group">
                        <label>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Direccion</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="NuevaDireccion" name="NuevaDireccion"
                            placeholder="Ingrese direccion">
                    </div>

                    <div class="form-group">
                        <label>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">telefono</font>
                            </font>
                        </label>
                        <input type="number" class="form-control" id="NuevoTelefono" name="NuevoTelefono"
                            placeholder="Ingrese telefono">
                    </div>
                    <div class="form-group">
                        <label>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Usuario</font>
                            </font>
                        </label>
                        <select name="NuevoIdUsuario" id="NuevoIdUsuario" class="form-control">
                            <?php
                            $usuarios = UsuarioControlador::listar(null, null);

                            foreach ($usuarios as $key => $value) {
                                echo '<option value="' . $value["id"] . '">' . $value["usuario"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>

                <?php
                $NuevoCliente = new ApoderadoControlador();
                $NuevoCliente->crear();
                ?>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalEditar">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <form role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Apoderado</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Nombre</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="EditarNombre" name="EditarNombre"
                            placeholder="Ingrese Nombre">
                        <input type="hidden" name="IdApoderado" id="IdApoderado" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Apellido</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="EditarApellido" name="EditarApellido"
                            placeholder="Ingrese Apellido">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Direccion</font>
                            </font>
                        </label>
                        <input type="text" class="form-control" id="EditarDireccion" name="EditarDireccion"
                            placeholder="Ingrese direccion">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">telefono</font>
                            </font>
                        </label>
                        <input type="number" class="form-control" id="EditarTelefono" name="EditarTelefono"
                            placeholder="Ingrese telefono">
                    </div>
                    <div class="form-group">
                        <label>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Usuario</font>
                            </font>
                        </label>
                        <select name="EditarIdUsuario" id="EditarIdUsuario" class="form-control">
                            <?php
                            $usuarios = UsuarioControlador::listar(null, null);

                            foreach ($usuarios as $key => $value) {
                                echo '<option value="' . $value["id"] . '">' . $value["usuario"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-light">Guardar</button>
                </div>

                <?php

                $editarapoderado = new ApoderadoControlador();
                $editarapoderado->editar();
                ?>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$borrarCliente = new ApoderadoControlador();
$borrarCliente->eliminar();
?>

<script>
    document.getElementById('NuevoNombre').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Reemplaza cualquier cosa que no sea letra o espacio
    });
    document.getElementById('NuevoApellido').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^a-zA-Z\s]/g, ''); // Reemplaza cualquier cosa que no sea letra o espacio
    });
    document.getElementById('NuevoTelefono').addEventListener('input', function(e) {
        const input = e.target;
        input.value = input.value.replace(/[^0-9]/g, ''); // Reemplaza cualquier cosa que no sea un número


    });
</script>