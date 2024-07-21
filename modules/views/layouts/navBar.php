<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header custom-bg-primary">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel" class="">
            <a href="/proyectoTienda/page/home" class="nav-link align-middle px-0  text-white">
                <i class="ms-1 fs-4 bi-house"></i>
                <span class="ms-1 d-sm-inline ">Inicio</span>
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
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-tags"></i>
                    <span class="ms-1 d-sm-inline">
                        Categorias
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarClientes/1', 'Clientes', 'bi-people')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-people"></i>
                    <span class="ms-1 d-sm-inline">
                        Clientes
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarCompras/1', 'Compras', 'bi-bag-fill')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-bag-fill text-white"></i>
                    <span class="ms-1 d-sm-inline">
                        Compras
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarEmpleados/1', 'Empleados', 'bi-people')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-people"></i>
                    <span class="ms-1 d-sm-inline">
                        Empleados
                    </span>
                </button>
            </li>
          
            <li class="w-100">
                <button onclick="addTab('listarGastos/1', 'Gastos', 'bi-cash')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-cash"></i>
                    <span class="ms-1 d-sm-inline">
                        Gastos
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarNotificaciones/1', 'Notificaciones', 'bi-bell notificaciones-icon')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white w-100 text-start">
                    <i class="ms-1 fs-4 bi bi-bell" id="notificaciones-icon"></i>
                    <span class="ms-1 d-sm-inline">
                        Notificaciones
                        <span id="notificaciones-count"></span>
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('panelControl', 'Panel de control', 'bi-graph-up text-white')"
                    class="nav-link w-100 text-start px-0">
                    <i class="ms-1 fs-4 bi bi-graph-up text-white"></i>
                    <span class="d-sm-inline text-white">
                        Panel de Control
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarProductos/1', 'Productos', 'bi-dropbox')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-dropbox"></i>
                    <span class="ms-1 d-sm-inline">
                        Productos
                    </span>
                </button>
            </li>

            <li class="w-100">
                <button onclick="addTab('listarProveedores/1', 'Proveedores', 'bi-people')"
                    class="nav-link w-100 text-start px-0 align-middle  text-white">
                    <i class="ms-1 fs-4 bi-people"></i>
                    <span class="ms-1 d-sm-inline">
                        Proveedores
                    </span>
                </button>
            </li>
            <li class="w-100">
                <button onclick="addTab('listarVentas/1', 'Ventas', 'bi-cart3')" 
                class="nav-link px-0 w-100 text-start">
                    <i class="ms-1 fs-4 bi-cart3 text-white"></i>
                    <span class="d-sm-inline text-white">
                        Ventas
                    </span>
                </button>
            </li>


        </ul>


    </div>

    <div class="dropdown pb-4 sticky-bottom custom-bg-primary " style="margin-left:-5px">
        &nbsp;

        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle my-2 ms-3"
            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

            <img src="/proyectoTienda/modules/views/layouts/img/usuario.png" alt="hugenerd"
                style="width:30px;height:30px;" class="rounded-circle">

            <span class="d-sm-inline mx-1">
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