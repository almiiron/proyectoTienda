<div style="width:70%; margin: 50px auto;" class="d-flex">
    <form action="http://localhost/proyectoTienda/page/filtrarListar<?php echo $tituloTabla; ?>/1" method="get"
        class="form d-flex" id="form-busqueda">
        <input class="form-control mr-sm-2 w-80" type="search" placeholder="Buscar" aria-label="Buscar"
            id="input-busqueda" name="filtro">


        <button class="btn btn-outline-primary my-2 my-sm-0 ms-2 w-20 d-flex" type="submit">
            Buscar
        </button>
    </form>
    <?php
    if ($limpiarFiltros == True) { ?>
        <a href="../listar<?php echo $tituloTabla; ?>" style="text-decoration:none;">
            <button class="btn btn-outline-primary my-2 my-sm-0 ms-2 w-20 d-flex" type="submit">
                Limpiar
            </button>
        </a>
    <?php } ?>
</div>
<!-- ------------------- -->
<div class="contenedor-general contenedor-<?php echo $contenedor; ?> mb-5">
    <div class="titulo-general titulo-<?php echo $titulo; ?>"><?php echo $tituloTabla; ?></div>

    <!-- iterar sobre los encabezados del array encabezados -->
    <?php foreach ($encabezados as $encabezado): ?>
        <div class="header-general"><?php echo $encabezado ?></div>
    <?php endforeach; ?>
    <div class="header-general">Estado</div>
    <div class="header-general">Modificar</div>

    <?php if ($lista) { ?>
        <!-- iterar sobre las filas de mi consulta guardadas en el array $lista -->
        <?php foreach ($lista as $index => $fila): ?>

            <!-- ahora itero sobre las filas para obtener cada dato de la fila -->
            <?php foreach ($fila as $valor): ?>
                <div class="item-tabla">
                    <?php if ($valor != 'Activo' && $valor != 'Inactivo') {
                        echo $valor;
                    } else if ($valor == 'Activo') {
                        ?>
                            <!-- <div class="item-tabla "> -->
                            <form method="post">
                                <input type="hidden" name="idEstado" id="idEstado" value="<?php echo $ids[$index]; ?>">
                                <input type="hidden" name="metodo" id="metodo" value="<?php echo $titulo; ?>">
                                <input type="hidden" name="estadoActual" id="estadoActual" value="<?php echo $valor; ?>">
                                <button type="submit" class="btn btn-success button-estado" id="button-submit">
                                <?php echo $valor; ?>
                                    <!-- <img src="/proyectoTienda/views/layouts/img/icons8-basura-llena-30.png" alt=""> -->
                                </button>
                            </form>
                            <!-- </div> -->
                    <?php } else if ($valor == 'Inactivo') { ?>
                                <form method="post">
                                    <input type="hidden" name="idEstado" id="idEstado" value="<?php echo $ids[$index]; ?>">
                                    <input type="hidden" name="metodo" id="metodo" value="<?php echo $titulo; ?>">
                                    <input type="hidden" name="estadoActual" id="estadoActual" value="<?php echo $valor; ?>">
                                    <button type="submit" class="btn btn-danger button-estado" id="button-submit">
                                <?php echo $valor; ?>
                                        <!-- <img src="/proyectoTienda/views/layouts/img/icons8-basura-llena-30.png" alt=""> -->
                                    </button>
                                </form>
                    <?php } ?>
                </div>
            <?php endforeach; ?>

            <div class="item-tabla ">
                <form action="http://localhost/proyectoTienda/page/mostrarModificar<?php echo $titulo; ?>" method="post">
                    <input type="hidden" name="idModificar" value="<?php echo $ids[$index]; ?>">
                    <button type="submit" class="button-modificar">
                        Modificar
                        <img src="/proyectoTienda/views/layouts/img/icons8-crear-nuevo-50.png" alt="">
                    </button>
                </form>
            </div>



        <?php endforeach; ?>
    <?php } else { ?>
        <div class="item-tabla-vacio-<?php echo $titulo; ?>">
            Nada que mostrar por aquí :(
        </div>
    <?php } ?>
</div>
<div class="row my-3 ml-5">
    <div class="col-12 text-center">
        <nav aria-label="Page navigation example" class="w-100 d-flex align-items-center justify-content-center" >
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