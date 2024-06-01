<?php
require_once ('./modules/productos/model/classProducto.php');
require_once ('./modules/productos/service/serviceProducto.php');
require_once ('./modules/categorias/controller/controllerCategoria.php');
require_once ('./modules/proveedores/controller/controllerProveedor.php');
class ControllerProducto
{
    private $conexion;
    private $serviceProveedores;
    private $serviceCategorias;
    private $serviceProducto;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->serviceProveedores = new serviceProveedor($this->conexion);
        $this->serviceCategorias = new serviceCategoria($this->conexion);
        $this->serviceProducto = new ServiceProducto($this->conexion);
    }

    public function procesarCargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $resultado = $this->serviceProducto->cargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function listarProductos($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {

            header('location:http://localhost/proyectoTienda/page/listarProductos/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }

        $resultado = $this->serviceProducto->listarProductos($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $contenedor = "Producto";
        $base_url = 'http://localhost/proyectoTienda/page/listarProductos';
        $titulo = "Producto";
        $tituloTabla = "Productos";
        $limpiarFiltros = False;
        $mostrarBuscadorEnNavbar = true;
        $encabezados = array("ID Producto", "Nombre del Producto", "Categoria", "Proveedor", "Precio", "Stock");
    
        $view = './modules/views/listar/listar-table.php';
        require_once ('./modules/views/layouts/main.php');

    }

    public function mostrarModificarProducto($id)
    {
        if (empty($id)) {
            header('location:http://localhost/proyectoTienda/page/listarProductos/1');
            exit();
        }

        $listaProveedores = $this->serviceProveedores->mostrarProveedores();
        $listaCategorias = $this->serviceCategorias->mostrarCategorias();

        $buscarProducto = $this->serviceProducto->listarUnProducto($id);
        $datosProducto = $buscarProducto;
        $view = './modules/productos/views/modificar-producto.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function procesarModificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $resultado = $this->serviceProducto->modificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto);

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarProductos($filtro, $numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://localhost/proyectoTienda/page/filtrarListarProductoss/1');
        }
       
        $resultado = $this->serviceProducto->filtrarListarProductos($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];

        //si no hay categorias que mostrar, ejecuta esto
        $contenedor = "Producto";
        $titulo = "Producto";
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = "Productos";
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarProductos';
        $limpiarFiltros = True;
        $encabezados = array("ID Producto", "Nombre del Producto", "Categoria", "Proveedor", "Precio", "Stock");
        $view = './modules/views/listar/listar-table.php';
        require_once ('./modules/views/layouts/main.php');

    }

    public function procesarCambiarEstadoProducto($id, $estadoActual)
    {
        $resultado = $this->serviceProducto->cambiarEstadoProducto($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}
?>