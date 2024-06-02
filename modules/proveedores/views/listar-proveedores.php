<div class="container my-5 ">
    <div class="table-responsive " style="height:400px;">
        <button type="button" class="btn btn-primary mb-1 text-center float-end" data-bs-toggle="modal"
            data-bs-placement="bottom" data-bs-title="Nuevo Proveedor"
            data-bs-target="#cargarProveedor" id="abrirModal">
            <img src="/proyectoTienda/modules/views/layouts/img/icons8-añadir-50.png" alt=""
                style="width:22px;height:22px;margin-left:2px;margin-top:-5px;">
        </button>

        <?php require_once ('./modules/proveedores/views/cargar-proveedor.php'); ?>
        <table class="table table-success table-striped" style="box-shadow: 1px 1px 10px 1px rgba(125, 125, 125, 0.5);">
            <thead style="height:80px;">
                <tr>

                    <th scope="col" class="bg-primary text-light text-center align-middle"
                        style="border-top-left-radius: 5px;">
                        ID Proveedor
                    </th>
                    <th class="bg-primary text-light text-center align-middle" scope="col">Nombre del Proveedor</th>
                    <th class="bg-primary text-light text-center align-middle" scope="col">Contacto</th>
                    <th class="bg-primary text-light text-center align-middle" scope="col">Estado</th>
                    <th class="bg-primary text-light text-center align-middle" scope="col"
                        style="border-top-right-radius: 5px;">Acción</th>
                </tr>

            </thead>
            <tbody>
                <?php if ($lista): ?>
                    <?php foreach ($lista as $index => $fila): ?>
                        <tr>
                            <?php foreach ($fila as $valor): ?>
                                <td class="text-center">
                                    <?php if ($valor != 'Activo' && $valor != 'Inactivo') {
                                        echo $valor;
                                    } else if ($valor == 'Activo') {
                                        ?>
                                            <!-- <div class="item-tabla "> -->
                                            <form method="post">
                                                <input type="hidden" name="idEstado" id="idEstado" value="<?php echo $ids[$index]; ?>">
                                                    <input type="hidden" name="metodo" id="metodoEstado" value="Proveedor">
                                                <input type="hidden" name="estadoActual" id="estadoActual" value="<?php echo $valor; ?>">
                                                <button type="submit" class="btn btn-success button-estado" id="button-submit">
                                                <?php echo $valor; ?>
                                                </button>
                                            </form>
                                            <!-- </div> -->
                                    <?php } else if ($valor == 'Inactivo') { ?>
                                                <form method="post">
                                                    <input type="hidden" name="idEstado" id="idEstado" value="<?php echo $ids[$index]; ?>">
                                                    <input type="hidden" name="metodo" id="metodoEstado" value="Proveedor">
                                                    <input type="hidden" name="estadoActual" id="estadoActual" value="<?php echo $valor; ?>">
                                                    <button type="submit" class="btn btn-danger button-estado" id="button-submit">
                                                <?php echo $valor; ?>
                                                        <!-- <img src="/proyectoTienda/views/layouts/img/icons8-basura-llena-30.png" alt=""> -->
                                                    </button>
                                                </form>
                                    <?php } ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="text-center">
                                <!-- Botón Modificar -->
                                <form action="http://localhost/proyectoTienda/page/mostrarModificarProveedor"
                                    method="post" class="modal-modificar">
                                    <input type="hidden" name="idModificar" value="<?php echo $ids[$index]; ?>">
                                    <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-placement="bottom" data-bs-target="#modificarProveedor">
                                        <!-- Modificar -->
                                        <img src="/proyectoTienda/modules/views/layouts/img/icons8-crear-nuevo-50.png" alt=""
                                            style="width:22px;height:22px;margin-left:2px;margin-top:-5px;">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nada que mostrar aquí.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<div class="col-12">
    <div class="text-center w-100 ">
        <nav aria-label="Page navigation example" class="d-flex align-items-center justify-content-center">
            <ul class="pagination">
                <?php
                $base_url .= "/";

                // Verificar si inputBusqueda no está vacío en la URL
                $searchParam = !empty($_GET['filtro']) ? '?filtro=' . urlencode($_GET['filtro']) : '';
                ?>
                <!-- Flecha de retroceso -->
                <li class="page-item <?php echo $numPage <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo max(1, $numPage - 5) . $searchParam; ?>"
                        aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Números de página -->
                <?php
                $start = max(1, $numPage - 2);
                $end = min($pages, $start + 4);

                for ($i = $start; $i <= $end; $i++) { ?>
                    <li class="page-item <?php echo $i == $numPage ? 'active' : ''; ?>">
                        <a class="page-link" href="<?php echo $base_url . $i . $searchParam; ?>"> <?php echo $i; ?> </a>
                    </li>
                <?php } ?>

                <!-- Flecha de avance -->
                <li class="page-item <?php echo $numPage >= $pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo min($pages, $numPage + 5) . $searchParam; ?>"
                        aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- ---------------------- -->