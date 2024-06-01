<div class="w-100">
    <?php if (isset($mostrarBuscadorEnNavbar) && $mostrarBuscadorEnNavbar) { ?>
        <li class="nav-item d-flex align-items-center w-100">
            <form action="http://localhost/proyectoTienda/page/filtrarListar<?php echo $tituloTabla; ?>/1" method="get"
                class="d-flex flex-grow-1" id="form-busqueda">
                <input class="form-control me-2 flex-grow-1" type="search" placeholder="Buscar" aria-label="Buscar"
                    id="input-busqueda" name="filtro">
                <button class="btn btn-outline-light" type="submit">Buscar</button>
                <?php if ($limpiarFiltros == True) { ?>
                    <a href="../listar<?php echo $tituloTabla; ?>" style="text-decoration:none;">
                        <button class="btn btn-outline-light ms-2" type="button">Limpiar</button>
                    </a>
                <?php } ?>
            </form>
        </li>
    <?php } ?>
</div>