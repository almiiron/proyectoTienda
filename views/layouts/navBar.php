<nav class="navbar navbar-expand-sm" style="background-color: #008afd;">
    <div class="container-fluid">
        <a class="navbar-brand text-light fs-3" href="#">Tienda</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page"
                        href="/proyectoTienda/page/home">Inicio</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link text-light" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Productos
                        <img src="/proyectoTienda/views/layouts/img/icons8-chevron-para-abajo-50.png" class="imgNavBar"
                            alt="" data-flecha="productos">
                    </a>
                    <ul class="dropdown-menu menu-hor">
                        <li><a class="dropdown-item" href="/proyectoTienda/page/listarProductos">Ver Productos</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/proyectoTienda/page/listarCategorias">Ver Categorias</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/proyectoTienda/page/listarProveedores">Ver Proveedores</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page"
                        href="/proyectoTienda/page/listarClientes">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page"
                        href="/proyectoTienda/page/listarEmpleados">Empleados</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($mostrarBuscadorEnNavbar) && $mostrarBuscadorEnNavbar) { ?>
                    <li class="nav-item d-flex align-items-center">
                        <form action="http://localhost/proyectoTienda/page/filtrarListar<?php echo $tituloTabla; ?>/1"
                            method="get" class="d-flex" id="form-busqueda">
                            <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar"
                                id="input-busqueda" name="filtro">
                            <button class="btn btn-outline-light" type="submit">Buscar</button>
                        </form>
                        <?php if ($limpiarFiltros == True) { ?>
                            <a href="../listar<?php echo $tituloTabla; ?>" style="text-decoration:none;">
                                <button class="btn btn-outline-light ms-2" type="submit">Limpiar</button>
                            </a>
                        <?php } ?>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown ms-1" id="dropdown-user">
                    <a class="btn btn-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['user']; ?>
                        <img src="/proyectoTienda/views/layouts/img/usuario.png" class="imgNavBar" alt=""
                            style="width:25px; height: 25px; margin-top:-5px;">
                        <img src="/proyectoTienda/views/layouts/img/icons8-chevron-negro-para-abajo-50.png"
                            class="imgNavBar" alt="" style="width:15px; height: 15px;" data-flecha="usuario">
                    </a>
                    <ul class="dropdown-menu menu-hor dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/proyectoTienda/page/cerrarSesion">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>