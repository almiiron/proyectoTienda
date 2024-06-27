<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header custom-bg-primary">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel" class="">
            <a href="/proyectoTienda/page/home" class="nav-link align-middle px-0  text-white">
                <i class="fs-4 bi-house"></i>
                <span class="ms-1 d-none d-sm-inline ">Inicio</span>
            </a>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body custom-bg-primary">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">

            <!-- <li class="nav-item w-100 ">
               
            </li> -->

            <li class="w-100">
                <button onclick="addTab('listarCategorias', 'Categorias', 'bi-tags')"
                    class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-tags"></i>
                    <span class="ms-1 d-none d-sm-inline">
                        Categorias
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarClientes/1', 'Clientes', 'bi-people')"
                    class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-people"></i>
                    <span class="ms-1 d-none d-sm-inline">
                        Clientes
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarEmpleados/1', 'Empleados', 'bi-people')"
                    class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-people"></i>
                    <span class="ms-1 d-none d-sm-inline">
                        Empleados
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarProductos/1', 'Productos', 'bi-dropbox')"
                    class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-dropbox"></i>
                    <span class="ms-1 d-none d-sm-inline">
                        Productos
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarProveedores/1', 'Proveedores', 'bi-people')"
                    class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-people"></i>
                    <span class="ms-1 d-none d-sm-inline">
                        Proveedores
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button class="nav-link px-0 align-middle" data-bs-toggle="collapse" data-bs-target="#submenu1">
                    <i class="fs-4 bi-bag-fill text-white"></i>
                    <span class="ms-1 d-none d-sm-inline text-white">Ventas</span>
                </button>
                <ul class="collapse nav flex-column" id="submenu1" data-bs-parent="#menu">
                    <li class="w-100">
                        <button class="nav-link px-0" onclick="addTab('listarVentas/1', 'Ventas', 'bi-cart3')">
                            <i class="fs-4 bi-cart3 text-white"></i>
                            <span class="d-none d-sm-inline text-white">
                                Ventas
                            </span>
                        </button>
                    </li>
                    <li class="w-100">
                        <button class="nav-link px-0"
                            onclick="addTab('controlVentas', 'Control de Ventas', 'bi-graph-up text-white')">
                            <i class="bi bi-graph-up text-white"></i>
                            <span class="d-none d-sm-inline text-white">
                                Panel de <br> Control
                            </span>
                        </button>
                    </li>
                </ul>
            </li>


            <li class="w-100">
                <button onclick="addTab('listarNotificaciones/1', 'Notificaciones', 'bi-bell notificaciones-icon')"
                    class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi bi-bell" id="notificaciones-icon"></i>
                    <span class="ms-1 d-none d-sm-inline">
                        Notificaciones
                        <span id="notificaciones-count"></span>
                    </span>
                </button>
            </li>

            <li class="w-100">
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle  text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>

            <!-- <li>
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                            </li>
                        </ul>
                    </li> -->
            <!-- <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                            </li>
                        </ul>
                    </li> -->

        </ul>


    </div>

    <div class="dropdown pb-4 sticky-bottom custom-bg-primary " style="margin-left:-5px">
        &nbsp;

        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle my-2 ms-3"
            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

            <img src="/proyectoTienda/modules/views/layouts/img/usuario.png" alt="hugenerd"
                style="width:30px;height:30px;" class="rounded-circle">

            <span class="d-none d-sm-inline mx-1">
                <?php echo $_SESSION['user']; ?>
            </span>
        </a>


        <ul class="dropdown-menu dropdown-menu-dark text-small shadow custom-bg-primary">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item" href="/proyectoTienda/page/cerrarSesion">
                    <i class="bi bi-box-arrow-right"></i>
                    Cerrar Sesión
                </a>
            </li>
        </ul>

    </div>
</div>

<!-- </div>
</div> -->