<?php
require_once './modules/home/controller/controllerHome.php';
require_once './modules/productos/controller/controllerProducto.php';
require_once './modules/categorias/controller/controllerCategoria.php';
require_once './modules/proveedores/controller/controllerProveedor.php';
require_once './modules/pagination/controller/controllerPagination.php';
require_once './modules/clientes/controller/controllerCliente.php';
require_once './modules/users/controller/controllerUser.php';
require_once './modules/empleados/controller/controllerEmpleado.php';
require_once './modules/ventas/controller/controllerVenta.php';
require_once './modules/panelControl/controller/controllerPanelControl.php';
require_once './modules/notificaciones/controller/controllerNotificaciones.php';
require_once './modules/compras/controller/controllerCompra.php';
require_once './modules/gastos/controller/controllerGasto.php';
class ControllerPage
{
    private $conexion;
    private $homeController;
    private $productoController;
    private $categoriaController;
    private $proveedorController;
    private $numPage;
    private $clienteController;
    private $userLoginController;
    private $empleadoController;
    private $ventaController;
    private $panelControlController;
    private $notificacionesController;
    private $compraController;
    private $gastoController;
    public function __construct($conexion, $numPage)
    {
        $this->homeController = new ControllerHome();
        $this->productoController = new ControllerProducto($conexion);
        $this->categoriaController = new ControllerCategoria($conexion);
        $this->proveedorController = new ControllerProveedor($conexion);
        $this->numPage = $numPage;
        $this->clienteController = new ControllerCliente($conexion);
        $this->userLoginController = new ControllerUser($conexion);
        $this->empleadoController = new ControllerEmpleado($conexion);
        $this->ventaController = new ControllerVenta($conexion);
        $this->panelControlController = new ControllerPanelControl($conexion);
        $this->notificacionesController = new ControllerNotificaciones($conexion);
        $this->compraController = new ControllerCompra($conexion);
        $this->gastoController = new ControllerGasto($conexion);
    }
    // Helper function to check for empty fields and redirect
    private function validarCamposYRedirigir($campos, $rutaRedireccion)
    {
        foreach ($campos as $campo) {
            if (empty($campo)) {
                header("Location: $rutaRedireccion");
                exit();
            }
        }
    }

    public function home()
    {
        // Ejecutar el método home del HomeController
        $this->homeController->home();
    }

    //   metodos de categoria //

    public function procesarCargarCategoria()
    {
        $nombreCategoria = $_POST['nombreCategoria'];
        $this->validarCamposYRedirigir([$nombreCategoria], '/proyectoTienda/page/listarCategorias/1');
        $this->categoriaController->procesarCargarCategoria($nombreCategoria);
    }
    public function listarCategorias()
    {
        $this->categoriaController->listarCategorias($this->numPage); // Pasar $this->numPage al método listarCategorias()
    }

    public function filtrarListarCategorias()
    {
        $filtro = null;
        if (!empty($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        // echo $filtro;
        $this->categoriaController->filtrarListarCategorias($filtro, $this->numPage);
    }

    public function procesarCambiarEstadoCategoria()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarCategorias/1');
        $this->categoriaController->procesarCambiarEstadoCategoria($id, $estadoActual);
    }
    public function mostrarModificarCategoria()
    {
        $id = $_POST['idModificar'];
        $this->categoriaController->mostrarModificarCategoria($id);
    }
    public function procesarModificarCategoria()
    {
        $id = $_POST['id'];
        $nombre_categoria = $_POST['nombreCategoria'];
        $this->validarCamposYRedirigir([$id, $nombre_categoria], '/proyectoTienda/page/listarCategorias/1');
        $this->categoriaController->procesarModificarCategoria($id, $nombre_categoria);
    }

    //   metodos de categoria //

    // metodos de proveedor //

    public function procesarCargarProveedor()
    {
        $nombreProveedor = $_POST['nombreProveedor'];
        $contactoProveedor = $_POST['contactoProveedor'];
        $this->validarCamposYRedirigir([$nombreProveedor, $contactoProveedor], '/proyectoTienda/page/listarProveedores/1');
        $this->proveedorController->procesarCargarProveedor($nombreProveedor, $contactoProveedor);
    }
    public function listarProveedores()
    {
        $this->proveedorController->listarProveedores($this->numPage);
    }


    public function filtrarListarProveedores()
    {
        $filtro = null;
        if (!empty($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $this->proveedorController->filtrarListarProveedores($filtro, $this->numPage);
    }

    public function procesarCambiarEstadoProveedor()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarProveedores/1');
        $this->proveedorController->procesarCambiarEstadoProveedor($id, $estadoActual);
    }

    public function mostrarModificarProveedor()
    {
        $id = $_POST['idModificar'];
        $this->proveedorController->mostrarModificarProveedor($id);
    }
    public function procesarModificarProveedor()
    {
        $idProveedor = $_POST['id'];
        $idContacto = $_POST['idContacto'];
        $nombreProveedor = $_POST['nombreProveedor'];
        $contactoProveedor = $_POST['contactoProveedor'];
        $this->validarCamposYRedirigir([$idProveedor, $idContacto, $nombreProveedor, $contactoProveedor], '/proyectoTienda/page/listarProveedores/1');
        $this->proveedorController->procesarModificarProveedor($idProveedor, $idContacto, $nombreProveedor, $contactoProveedor);
    }
    // metodos de proveedor //

    // metodos de productos //

    public function procesarCargarProducto()
    {
        $nombreProducto = $_POST['nombreProducto'];
        $IdCategoriaProducto = $_POST['IdCategoriaProducto'];
        $IdProveedorProducto = $_POST['IdProveedorProducto'];
        $precioProductoCompra = $_POST['precioProductoCompra'];
        $precioProductoVenta = $_POST['precioProductoVenta'];
        $stockProducto = $_POST['stockProducto'];
        $this->validarCamposYRedirigir(
            [$nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProductoCompra, $precioProductoVenta, $stockProducto],
            '/proyectoTienda/page/listarProductos/1'
        );
        $this->productoController->procesarCargarProducto(
            $nombreProducto,
            $IdCategoriaProducto,
            $IdProveedorProducto,
            $precioProductoCompra,
            $precioProductoVenta,
            $stockProducto
        );
    }
    public function listarProductos()
    {
        $this->productoController->listarProductos($this->numPage);
    }
    public function mostrarModificarProducto()
    {
        $id = $_POST['idModificar'];
        $this->productoController->mostrarModificarProducto($id);
    }

    public function procesarModificarProducto()
    {
        $IdProducto = $_POST['IdProducto'];
        $nombreProducto = $_POST['nombreProducto'];
        $IdCategoriaProducto = $_POST['IdCategoriaProducto'];
        $IdProveedorProducto = $_POST['IdProveedorProducto'];
        $precioProductoCompra = $_POST['precioProductoCompra'];
        $precioProductoVenta = $_POST['precioProductoVenta'];
        $stockProducto = $_POST['stockProducto'];
        $this->validarCamposYRedirigir(
            [$IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProductoCompra, $precioProductoVenta, $stockProducto],
            '/proyectoTienda/page/listarProductos/1'
        );
        $this->productoController->procesarModificarProducto(
            $IdProducto,
            $nombreProducto,
            $IdCategoriaProducto,
            $IdProveedorProducto,
            $precioProductoCompra,
            $precioProductoVenta,
            $stockProducto
        );
    }

    public function filtrarListarProductos()
    {
        $filtro = null;
        if (!empty($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $this->productoController->filtrarListarProductos($filtro, $this->numPage);
    }

    public function procesarCambiarEstadoProducto()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarProductos/1');
        $this->productoController->procesarCambiarEstadoProducto($id, $estadoActual);
    }

    // metodos de productos //

    // metodos de clientes //
    public function listarClientes()
    {
        $this->clienteController->listarClientes($this->numPage);
    }

    public function procesarCargarCliente()
    {
        $nombreCliente = $_POST['nombreCliente'];
        $apellidoCliente = $_POST['apellidoCliente'];
        $telefonoCliente = $_POST['telefonoCliente'];
        $this->validarCamposYRedirigir([$nombreCliente, $apellidoCliente, $telefonoCliente], '/proyectoTienda/page/listarClientes/1');
        $this->clienteController->procesarCargarCliente($nombreCliente, $apellidoCliente, $telefonoCliente);
    }
    public function procesarCambiarEstadoCliente()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarClientes/1');
        $this->clienteController->procesarCambiarEstadoCliente($id, $estadoActual);
    }

    public function mostrarModificarCliente()
    {
        $id = $_POST['idModificar'];
        $this->clienteController->mostrarModificarCliente($id);
    }

    public function procesarModificarCliente()
    {
        $idCliente = $_POST['idCliente'];
        $idPersona = $_POST['idPersona'];
        $nombrePersona = $_POST['nombreCliente'];
        $apellidoPersona = $_POST['apellidoCliente'];
        $idContacto = $_POST['idContacto'];
        $telefono = $_POST['telefonoCliente'];
        $this->validarCamposYRedirigir([$$idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono], '/proyectoTienda/page/listarClientes/1');
        $this->clienteController->procesarModificarCliente($idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono);
    }
    public function filtrarListarClientes()
    {
        $filtro = (empty($_GET['filtro'])) ? null : $_GET['filtro'];
        $this->clienteController->filtrarListarClientes($filtro, $this->numPage);
    }
    // metodos de clientes //

    // metodos de login //
    public function iniciarSesion()
    {
        $this->userLoginController->iniciarSesion();
    }
    public function procesarIniciarSesion()
    {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $this->validarCamposYRedirigir([$user, $password], '/proyectoTienda/page/home');
        $this->userLoginController->procesarIniciarSesion($user, $password);
    }

    public function cerrarSesion()
    {
        $this->userLoginController->procesarCerrarSesion();
    }
    // metodos de login //

    // metodos de empleado //
    public function listarEmpleados()
    {
        $this->empleadoController->listarEmpleados($this->numPage);
    }
    public function procesarCargarEmpleado()
    {
        $nombreEmpleado = $_POST['nombreEmpleado'];
        $apellidoEmpleado = $_POST['apellidoEmpleado'];
        $contactoEmpleado = $_POST['contactoEmpleado'];
        $idRol = $_POST['IdRolUsuario'];
        $usuarioEmpleado = $_POST['usuarioEmpleado'];
        $passwordEmpleado = $_POST['passwordEmpleado'];
        $this->validarCamposYRedirigir(
            [$nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $usuarioEmpleado, $passwordEmpleado],
            '/proyectoTienda/page/listarEmpleados/1'
        );
        $this->empleadoController->procesarCargarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $usuarioEmpleado, $passwordEmpleado);
    }

    public function procesarCambiarEstadoEmpleado()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarEmpleados/1');
        $this->empleadoController->procesarCambiarEstadoEmpleado($id, $estadoActual);
    }

    public function filtrarListarEmpleados()
    {
        $filtro = (empty($_GET['filtro'])) ? null : $_GET['filtro'];
        $this->empleadoController->filtrarListarEmpleados($filtro, $this->numPage);
    }

    public function mostrarModificarEmpleado()
    {
        $id = $_POST['idModificar'];
        $this->validarCamposYRedirigir([$id], '/proyectoTienda/page/listarEmpleados/1');
        $this->empleadoController->mostrarModificarEmpleado($id);
    }

    public function procesarModificarEmpleado()
    {
        $nombreEmpleado = $_POST['nombreEmpleado'];
        $apellidoEmpleado = $_POST['apellidoEmpleado'];
        $contactoEmpleado = $_POST['contactoEmpleado'];
        $idRol = $_POST['IdRolUsuarioModificar'];
        $idEmpleado = $_POST['idEmpleado'];
        $idPersona = $_POST['idPersona'];
        $idContacto = $_POST['idContacto'];
        $idUsuario = $_POST['idUsuario'];
        $this->validarCamposYRedirigir(
            [$nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $idEmpleado, $idPersona, $idContacto, $idUsuario],
            '/proyectoTienda/page/listarEmpleados/1'
        );
        $this->empleadoController->procesarModificarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $idEmpleado, $idPersona, $idContacto, $idUsuario);
    }
    // metodos de empleado //

    // metodos ventas //
    public function listarVentas()
    {
        $this->ventaController->listarVentas($this->numPage);
    }
    public function mostrarCargarVenta()
    {
        $this->ventaController->mostrarCargarVenta();
    }
    public function procesarCargarVenta()
    {
        $idCliente = $_POST['IdClienteVenta'];
        $idEmpleado = $_POST['IdEmpleadoVenta'];
        $productos = $_POST['productos'];
        $subTotalVenta = $_POST['subTotalVenta'];
        $totalVenta = $_POST['totalVenta'];
        $idMetodoPago = $_POST['IdMetodoPagoVenta'];
        $interesVenta = $_POST['interesVenta'];
        $this->validarCamposYRedirigir(
            [$idCliente, $idEmpleado, $productos, $subTotalVenta, $totalVenta, $idMetodoPago, $interesVenta],
            '/proyectoTienda/page/listarVentas/1'
        );
        $this->ventaController->procesarCargarVenta($idCliente, $idEmpleado, $productos, $subTotalVenta, $totalVenta, $idMetodoPago, $interesVenta);
    }

    public function filtrarListarVentas()
    {
        $filtro = (empty($_GET['filtro'])) ? null : $_GET['filtro'];
        $this->ventaController->filtrarListarVentas($filtro, $this->numPage);
    }

    // metodos ventas //

    // metodos control de ventas //  
    public function panelControl()
    {
        $this->panelControlController->panelControl();
    }

    public function productosMasVendidos()
    {
        $this->panelControlController->productosMasVendidos();
    }

    public function categoriasConMasVentas()
    {
        $this->panelControlController->categoriasConMasVentas();
    }

    public function totalVentasCadaMesDelAnio()
    {
        $this->panelControlController->totalVentasCadaMesDelAnio();
    }

    public function ingresosUltimosSieteDias()
    {
        $this->panelControlController->ingresosUltimosSieteDias();
    }

    public function ingresosUltimasCuatroSemanas()
    {
        $this->panelControlController->ingresosUltimasCuatroSemanas();
    }
    // metodos control de ventas //  

    // metodos de nofiticaciones //
    public function listarNotificaciones()
    {
        $this->notificacionesController->listarNotificaciones($this->numPage);
    }
    public function filtrarListarNotificaciones()
    {
        $filtro = (empty($_GET['filtro'])) ? null : $_GET['filtro'];
        $this->notificacionesController->filtrarListarNotificaciones($filtro, $this->numPage);
    }
    public function procesarCambiarEstadoNotificacion()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarNotificaciones/1');
        $this->notificacionesController->procesarCambiarEstadoNotificacion($id, $estadoActual);
    }

    public function obtenerNotificacionesNoLeidas()
    {
        $this->notificacionesController->obtenerNotificacionesNoLeidas();

    }
    // son notificaciones pero utilizo los controladores de cada modulo //
    public function obtenerCantidadProductosBajoStock()
    {
        $this->productoController->obtenerCantidadProductosBajoStock();
    }
    public function obtenerCantidadProductosSinStock()
    {
        $this->productoController->obtenerCantidadProductosSinStock();
    }

    // son notificaciones pero utilizo los controladores de cada modulo //

    // metodos de nofiticaciones //

    // metodos de compra //     // metodos de compra //     // metodos de compra //

    public function listarCompras()
    {
        $this->compraController->listarCompras($this->numPage);
    }

    public function mostrarCargarCompra()
    {
        $this->compraController->mostrarCargarCompra();
    }

    public function procesarCargarCompra()
    {
        $IdProveedorCompra = $_POST['IdProveedorCompra'];
        $idEmpleado = $_POST['IdEmpleadoCompra'];
        $productos = $_POST['productos'];
        $subTotalCompra = $_POST['subTotalCompra'];
        $totalCompra = $_POST['totalCompra'];
        $idMetodoPago = $_POST['IdMetodoPagoCompra'];
        $this->validarCamposYRedirigir(
            [$IdProveedorCompra, $idEmpleado, $productos, $subTotalCompra, $totalCompra, $idMetodoPago],
            '/proyectoTienda/page/listarCompras/1'
        );
        $this->compraController->procesarCargarCompra($IdProveedorCompra, $idEmpleado, $productos, $subTotalCompra, $totalCompra, $idMetodoPago);
    }


    // metodos de compra //     // metodos de compra //     // metodos de compra //

    // metodos de gasto //      // metodos de gasto //        // metodos de gasto //      // metodos de gasto //
    public function listarGastos()
    {
        $this->gastoController->listarGastos($this->numPage);
    }

    public function procesarCargarGasto()
    {
        $categoriaGasto = $_POST['categoriaGasto'];
        $descripcionGasto = $_POST['descripcionGasto'];
        $empleadoGasto = $_POST['empleadoGasto'];
        $metodoPagoGasto = $_POST['metodoPagoGasto'];
        $precioTotalGasto = $_POST['precioTotalGasto'];
        $fecha = !empty($_POST['hiddenDate']) ? $_POST['hiddenDate'] : $_POST['date'];
        $hora = !empty($_POST['hiddenTime']) ? $_POST['hiddenTime'] : $_POST['time'];
        $comentarioGasto = $_POST['comentarioGasto'];
        $this->validarCamposYRedirigir(
            [$categoriaGasto, $descripcionGasto, $empleadoGasto, $metodoPagoGasto, $precioTotalGasto, $fecha, $hora],
            '/proyectoTienda/page/listarGastos/1'
        );
        $this->gastoController->procesarCargarGasto($categoriaGasto, $descripcionGasto, $empleadoGasto, $metodoPagoGasto, $precioTotalGasto, $fecha, $hora, $comentarioGasto);
    }

    public function mostrarModificarGasto()
    {
        $id = $_POST['idModificar'];
        $this->validarCamposYRedirigir([$id], '/proyectoTienda/page/listarGastos/1');
        $this->gastoController->mostrarModificarGasto($id);
    }

    public function procesarModificarGasto()
    {
        $idGasto = $_POST['idGastoModificar'];
        $categoriaGasto = $_POST['categoriaGastoModificar'];
        $descripcionGasto = $_POST['descripcionGastoModificar'];
        $empleadoGasto = $_POST['empleadoGastoModificar'];
        $metodoPagoGasto = $_POST['metodoPagoGastoModificar'];
        $precioTotalGasto = $_POST['precioTotalGastoModificar'];
        $fecha = !empty($_POST['hiddenDate']) ? $_POST['hiddenDate'] : $_POST['date'];
        $hora = !empty($_POST['hiddenTime']) ? $_POST['hiddenTime'] : $_POST['time'];
        $comentarioGasto = $_POST['comentarioGastoModificar'];
        $this->validarCamposYRedirigir(
            [$idGasto, $categoriaGasto, $descripcionGasto, $empleadoGasto, $metodoPagoGasto, $precioTotalGasto, $fecha, $hora],
            '/proyectoTienda/page/listarGastos/1'
        );
        $this->gastoController->procesarModificarGasto($idGasto, $categoriaGasto, $descripcionGasto, $empleadoGasto, $metodoPagoGasto, $precioTotalGasto, $fecha, $hora, $comentarioGasto);
    }

    public function procesarCambiarEstadoGasto()
    {
        $id = $_POST['id'];
        $estadoActual = $_POST['estadoActual'];
        $this->validarCamposYRedirigir([$id, $estadoActual], '/proyectoTienda/page/listarGastos/1');
        $this->gastoController->procesarCambiarEstadoGasto($id, $estadoActual);
    }
    // metodos de gasto //      // metodos de gasto //        // metodos de gasto //      // metodos de gasto //
}
?>