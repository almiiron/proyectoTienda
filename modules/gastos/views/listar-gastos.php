<div class="container my-5 ">
    <div class="table-responsive " style="height:400px;">

        <button type="button" class="btn btn-primary mb-1 text-center float-end" data-bs-toggle="modal"
            data-bs-placement="bottom" data-bs-title="Nuevo Cliente" data-bs-target="#cargarGasto" id="abrirModal">
            <img src="/proyectoTienda/modules/views/layouts/img/icons8-añadir-50.png" alt=""
                style="width:22px;height:22px;margin-left:2px;margin-top:-5px;">
        </button>
        <?php require_once './modules/gastos/views/cargar-gasto.php'; ?>
        <?php require_once './modules/gastos/views/detalle-gasto.php'; ?>

        <table class="table table-striped" id="tabla-gastos">
            <thead style="height:80px;">
                <tr>
                    <th scope="col" class="custom-bg-secondary text-light text-center align-middle"
                        style="border-top-left-radius: 5px;">
                        ID Gasto
                    </th>

                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Empleado
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Categoria
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Fecha
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Precio Total
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Estado
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col"
                        style="border-top-right-radius: 5px;">
                        Acción
                    </th>
                </tr>

            </thead>
            <tbody>
                <?php if ($lista): ?>
                    <?php foreach ($lista as $index => $fila): ?>
                        <tr data-id-gasto="<?php echo $fila['id_gasto'] ?>"
                            data-id-empleado="<?php echo $fila['id_empleado'] ?>"
                            data-nombre-empleado="<?php echo $fila['nombreEmpleado'] ?>"
                            data-apellido-empleado="<?php echo $fila['apellidoEmpleado'] ?>"
                            data-metodo-pago="<?php echo $fila['metodo_pago'] ?>"
                            data-categoria-gasto="<?php echo $fila['nombre_categoria_gasto'] ?>"
                            data-descripcion-gasto="<?php echo $fila['descripcion'] ?>"
                            data-fecha="<?php echo $fila['fecha'] ?>" data-hora="<?php echo $fila['hora'] ?>"
                            data-precio-total="<?php echo $fila['precio_total'] ?>"
                            data-comentario="<?php echo $fila['comentario'] ?>" data-estado="<?php echo $fila['estado'] ?>">

                            <td class="text-center custom-bg-tertiary">
                                <?php echo $fila['id_gasto']; ?>
                            </td>
                            <td class="text-center custom-bg-tertiary">
                                <?php echo $fila['nombreEmpleado']; ?>
                            </td>
                            <td class="text-center custom-bg-tertiary">
                                <?php echo $fila['nombre_categoria_gasto']; ?>
                            </td>

                            </td>
                            <td class="text-center custom-bg-tertiary">
                                <?php echo $fila['fecha']; ?>
                            </td>
                            <td class="text-center custom-bg-tertiary todosPreciosFormateados">
                                <?php echo $fila['precio_total']; ?>
                            </td>
                            <td class="text-center custom-bg-tertiary">
                                <form method="post">
                                    <input type="hidden" name="idEstado" value="<?php echo $fila['id_gasto']; ?>">
                                    <input type="hidden" id="metodoEstado" name="metodo" value="Gasto">
                                    <input type="hidden" name="estadoActual" value="<?php echo $fila['estado']; ?>">
                                    <button type="submit"
                                        class="<?php echo ($fila['estado'] == 'Activo') ? 'btn btn-primary' : 'btn btn-secondary'; ?> button-estado">
                                        <?php echo $fila['estado']; ?>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center custom-bg-tertiary d-flex justify-content-center">
                                <button type="button" class="btn btn-info text-center  me-1" data-bs-toggle="modal"
                                    data-bs-placement="bottom" data-bs-title="Detalles Gasto" data-bs-target="#detalleGasto"
                                    id="buttonDetalleGasto">
                                    <i class="bi bi-eye text-white" style="font-size:1.1rem;"></i>
                                </button>

                                <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/mostrarModificarGasto"
                                    method="post" class="modal-modificar">
                                    <input type="hidden" name="idModificar" value="<?php echo $ids[$index]; ?>">
                                    <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-placement="bottom" data-bs-target="#modificarGasto">
                                        <!-- Modificar -->
                                        <i class="bi bi-pencil-square" style="font-size:1.1rem;"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center custom-bg-tertiary">Nada que mostrar aquí.</td>
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