<div style="width:70%; margin: 50px auto;" class="d-flex">
    <form action="filtrarListar<?php echo $tituloTabla; ?>" method="post" class="form d-flex" id="form-busqueda">
        <input class="form-control mr-sm-2 w-80" type="search" placeholder="Buscar" aria-label="Buscar"
            id="input-busqueda" name="inputBusqueda">

        <button class="btn btn-outline-primary my-2 my-sm-0 ms-2 w-20 d-flex" type="submit">
            Buscar
        </button>
    </form>
    <?php
    if ($limpiarFiltros == True) { ?>
        <a href="./listar<?php echo $tituloTabla; ?>" style="text-decoration:none;">
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
                <form action="../page/mostrarModificar<?php echo $titulo; ?>" method="post">
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