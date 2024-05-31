<?php
require_once './modules/home/controller/controllerHome.php';
require_once './modules/productos/controller/controllerProducto.php';
require_once './modules/categorias/controller/controllerCategoria.php';
require_once './modules/proveedores/controller/controllerProveedor.php';
require_once './modules/pagination/controller/controllerPagination.php';
require_once './modules/clientes/controller/controllerCliente.php';
require_once './modules/users/controller/controllerUser.php';
require_once './modules/empleados/controller/controllerEmpleado.php';
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
        $precioProducto = $_POST['precioProducto'];
        $stockProducto = $_POST['stockProducto'];
        $this->validarCamposYRedirigir(
            [$nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto],
            '/proyectoTienda/page/listarProductos/1'
        );
        $this->productoController->procesarCargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto);
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
        $precioProducto = $_POST['precioProducto'];
        $stockProducto = $_POST['stockProducto'];
        $this->validarCamposYRedirigir(
            [$IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto],
            '/proyectoTienda/page/listarProductos/1'
        );
        $this->productoController->procesarModificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto);
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

    public function procesarModificarEmpleado(){
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
}
?>