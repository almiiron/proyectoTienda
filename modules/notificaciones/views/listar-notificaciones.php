<div class="container tabla my-5">
    <div class="table-responsive " style="height:400px;">

        <table class="table ">
            <thead style="height:80px;">
                <tr>

                    <th scope="col" class="custom-bg-secondary text-light text-center align-middle"
                        style="border-top-left-radius: 5px;">
                        ID Notificación
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Mensaje
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Tipo
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Fecha
                    </th>
                    <th class="custom-bg-secondary text-light text-center align-middle" scope="col">
                        Hora
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
            <tbody class="custom-hover">
                <?php if ($lista): ?>
                    <?php foreach ($lista as $index => $fila): ?>
                        <?php
                        // Inicializamos la clase de Bootstrap en función del valor de 'tipo'
                        $claseBootstrap = 'border-end'; // Clase por defecto
                        foreach ($fila as $clave => $valor) {
                            if ($clave === 'tipo') { // Asegúrate de que la clave sea la que contiene el tipo
                                switch ($valor) {
                                    case 'Información':
                                        $claseBootstrap = 'alert alert-info';
                                        break;
                                    case 'Advertencia':
                                        $claseBootstrap = 'alert alert-warning';
                                        break;
                                    case 'Error':
                                        $claseBootstrap = 'alert alert-danger';
                                        break;
                                    case 'Éxito':
                                        $claseBootstrap = 'alert alert-success';
                                        break;
                                    default:
                                        $claseBootstrap = '';
                                        break;
                                }
                            }
                        }
                        ?>
                        <tr class="<?php echo $claseBootstrap; ?>">
                            <?php foreach ($fila as $valor): ?>
                                <td class="text-center" style="background-color:transparent !important; mb-5">
                                    <?php if ($valor != 'Activo' && $valor != 'Inactivo') {
                                        echo $valor;
                                    } else {
                                        $btnClass = ($valor == 'Activo') ? 'btn btn-primary' : 'btn btn-secondary';
                                        $btnLeido = ($valor == 'Inactivo') ? 'text-success' : 'text-secondary';
                                        ?>
                                        <button type="button" class="<?php echo $btnClass; ?>" id="button-submit"
                                            disabled>
                                            <?php echo $valor; ?>
                                        </button>
                                    <?php } ?>
                                </td>

                            <?php endforeach; ?>

                            <td class="text-center" style="background-color:transparent !important; mb-5">
                                <form method="post" class="">
                                    <input type="hidden" name="idEstado" value="<?php echo $ids[$index]; ?>">
                                    <input type="hidden" name="metodoEstado" id="metodoEstado" value="Notificacion">
                                    <input type="hidden" name="estadoActual" id="estadoActual" value="<?php echo $valor; ?>">
                                    <button type="submit" class="btn marcar-leido-notififacion">
                                        <i class="fs-4 bi bi-check-square-fill <?php echo $btnLeido; ?>"></i>
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
<br>
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