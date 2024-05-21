<?php
require_once 'controllerHome.php';
require_once 'controllerProducto.php';
require_once 'controllerCategoria.php';
require_once 'controllerProveedor.php';
require_once 'controllerPagination.php';
class ControllerPage
{
    private $conexion;
    private $homeController;
    private $productoController;
    private $categoriaController;
    private $proveedorController;
    private $numPage;

    public function __construct($conexion, $numPage)
    {
        $this->conexion = $conexion;
        $this->homeController = new ControllerHome();
        $this->productoController = new ControllerProducto($conexion);
        $this->categoriaController = new ControllerCategoria($conexion);
        $this->proveedorController = new ControllerProveedor($conexion);
        $this->numPage = $numPage;
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
        $this->categoriaController->procesarModificarCategoria($id, $nombre_categoria);
    }

    //   metodos de categoria //

    // metodos de proveedor //
   
    public function procesarCargarProveedor()
    {
        $nombreProveedor = $_POST['nombreProveedor'];
        $contactoProveedor = $_POST['contactoProveedor'];
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
        $this->productoController->procesarCambiarEstadoProducto($id, $estadoActual);
    }

    // metodos de productos //


}
?>