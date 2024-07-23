<?php
require_once './modules/compras/service/serviceCompra.php';

class ControllerCompra
{
    private $serviceCompras;

    public function __construct($conexion)
    {
        $this->serviceCompras = new ServiceCompra($conexion);
    }

    public function listarCompras($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarCompras/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceCompras->listarCompras($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = False;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarCompras';
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = 'Compras';
        $view = './modules/compras/views/listar-compras.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function mostrarCargarCompra()
    {
        $resultados = $this->serviceCompras->mostrarCargarCompra();
        $mostrarTodosProveedores = $resultados[0];
        $mostrarTodosEmpleados = $resultados[1];
        $mostrarTodosProductos = $resultados[2];
        $mostrarTodosMetodosPagos = $resultados[3];
        $view = './modules/compras/views/cargar-compra.php';
        require_once './modules/views/layouts/main.php';
    }

    public function procesarCargarCompra($IdProveedorCompra, $idEmpleado, $productos, $subTotalCompra, $totalCompra, $idMetodoPago)
    {
        $resultado = $this->serviceCompras->procesarCargarCompra($IdProveedorCompra, $idEmpleado, $productos, $subTotalCompra, $totalCompra, $idMetodoPago);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function procesarCambiarEstadoCompra($idVenta, $estadoActual)
    {
        $resultado = $this->serviceCompras->procesarCambiarEstadoCompra($idVenta, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
}
?>