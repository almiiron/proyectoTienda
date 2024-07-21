<?php
require_once ('./modules/productos/model/classProducto.php');
require_once ('./modules/productos/service/serviceProducto.php');

class ControllerProducto
{
    private $conexion;
 
    private $serviceProducto;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
     
        $this->serviceProducto = new ServiceProducto($this->conexion);
    }

    public function procesarCargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProductoCompra, $precioProductoVenta, $stockProducto)
    {
        $resultado = $this->serviceProducto->cargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProductoCompra, $precioProductoVenta, $stockProducto);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function listarProductos($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {

            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarProductos/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }

        $resultado = $this->serviceProducto->listarProductos($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarProductos';
        $tituloTabla = "Productos";
        $limpiarFiltros = False;
        $mostrarBuscadorEnNavbar = true;

        $listaProveedores = $resultado[3];      // para el modal para cargar producto
        $listaCategorias = $resultado[4];       // para el modal ppara cargar producto

        $view = './modules/productos/views/listar-productos.php';
        require_once ('./modules/views/layouts/main.php');

    }

    public function mostrarModificarProducto($id)
    {
        if (empty($id)) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarProductos/1');
            exit();
        }

        $resultado = $this->serviceProducto->mostrarModificarProducto();
        $listaProveedores = $resultado[0];
        $listaCategorias = $resultado[1];

        $buscarProducto = $this->serviceProducto->listarUnProducto($id);
        $datosProducto = $buscarProducto;
        $view = './modules/productos/views/modificar-producto.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function procesarModificarProducto(
        $IdProducto,
        $nombreProducto,
        $IdCategoriaProducto,
        $IdProveedorProducto,
        $precioProductoCompra,
        $precioProductoVenta,
        $stockProducto
    ) {
        $resultado = $this->serviceProducto->modificarProducto(
            $IdProducto,
            $nombreProducto,
            $IdCategoriaProducto,
            $IdProveedorProducto,
            $precioProductoCompra,
            $precioProductoVenta,
            $stockProducto
        );

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarProductos($filtro, $numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://' . IP_HOST . '/proyectoTienda/page/filtrarListarProductoss/1');
        }

        $resultado = $this->serviceProducto->filtrarListarProductos($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = "Productos";
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/filtrarListarProductos';
        $limpiarFiltros = True;

        $listaProveedores = $resultado[3];      // para el modal para cargar producto
        $listaCategorias = $resultado[4];       // para el modal ppara cargar producto

        $view = './modules/productos/views/listar-productos.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function procesarCambiarEstadoProducto($id, $estadoActual)
    {
        $resultado = $this->serviceProducto->cambiarEstadoProducto($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function obtenerCantidadProductosBajoStock()
    {
        $notificaciones = $this->serviceProducto->obtenerCantidadProductosBajoStock();
        header('Content-Type: application/json');
        echo json_encode($notificaciones);
    }
    public function obtenerCantidadProductosSinStock()
    {
        $notificaciones = $this->serviceProducto->obtenerCantidadProductosSinStock();
        header('Content-Type: application/json');
        echo json_encode($notificaciones);
    }

}
?>