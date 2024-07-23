<div class="container my-5 ">
    <div class="table-responsive " style="height:400px;">
        <button type="button" class="btn btn-primary mb-1 text-center float-end" data-bs-placement="bottom"
            data-bs-title="Nueva Venta" onclick="addTab('mostrarCargarVenta', 'Venta', ' bi-plus-circle')">
            <i class="bi bi-plus-circle"></i>
        </button>

        <table class="table table-striped">
            <thead style="height:80px;">
                <tr>
                    <th scope="col" class="custom-bg-secondary text-light text-center align-middle"
                        style="border-top-left-radius: 5px;">ID Venta</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Cliente</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Metodo de Pago</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Fecha</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Hora</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Precio Total</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Interes</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">Estado</th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col"
                        style="border-top-right-radius: 5px;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lista): ?>
                    <?php foreach ($lista as $index => $fila): ?>
                        <tr>
                            <td class="text-center custom-bg-tertiary"><?php echo $fila['id_venta']; ?></td>
                            <td class="text-center custom-bg-tertiary">
                                <?php echo $fila['nombreCliente'] . ' ' . $fila['apellidoCliente']; ?>
                            </td>
                            <td class="text-center custom-bg-tertiary"><?php echo $fila['metodo_pago']; ?></td>
                            <td class="text-center custom-bg-tertiary"><?php echo $fila['fecha']; ?></td>
                            <td class="text-center custom-bg-tertiary"><?php echo $fila['hora']; ?></td>
                            <td class="text-center custom-bg-tertiary todosPreciosFormateados"><?php echo $fila['precio_total']; ?></td>
                            <td class="text-center custom-bg-tertiary"><?php echo $fila['interes']; ?></td>
                            <td class="text-center custom-bg-tertiary">
                                <form method="post">
                                    <input type="hidden" name="idEstado" value="<?php echo $fila['id_venta']; ?>">
                                    <input type="hidden" name="metodoEstado" id="metodoEstado" value="Venta">
                                    <input type="hidden" name="estadoActual" value="<?php echo $fila['estado_venta']; ?>">
                                    <button type="submit"
                                        class="<?php echo ($fila['estado_venta'] == 'Activo') ? 'btn btn-primary' : 'btn btn-secondary'; ?> button-estado">
                                        <?php echo $fila['estado_venta']; ?>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center custom-bg-tertiary">
                                <button class="btn btn-info" onclick="toggleDetails(<?php echo $index; ?>)">Ver
                                    Detalles</button>
                            </td>
                        </tr>
                        <tr id="details-<?php echo $index; ?>" class="hidden-row details-row">
                            <td colspan="9" style="padding:0px;">
                                <div class="details-content">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="custom-bg-secondary text-light text-center align-middle">ID Producto</th>
                                                <th class="custom-bg-secondary text-light text-center align-middle">Nombre Producto</th>
                                                <th class="custom-bg-secondary text-light text-center align-middle">Cantidad</th>
                                                <th class="custom-bg-secondary text-light text-center align-middle">Precio Producto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($fila['detalles'] as $detalle): ?>
                                                <tr>
                                                    <td  class="text-center custom-bg-tertiary"><?php echo $detalle['id_producto']; ?></td>
                                                    <td  class="text-center custom-bg-tertiary"><?php echo $detalle['nombre_producto']; ?></td>
                                                    <td  class="text-center custom-bg-tertiary"><?php echo $detalle['cantidad_producto']; ?></td>
                                                    <td  class="text-center custom-bg-tertiary todosPreciosFormateados"><?php echo $detalle['precio_producto']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center custom-bg-tertiary">Nada que mostrar aquí.</td>
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