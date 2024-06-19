<?php
require_once ('./modules/ventas/service/serviceVenta.php');

class ControllerVenta
{
    private $serviceVenta;
    public function __construct($conexion)
    {
        $this->serviceVenta = new ServiceVenta($conexion);
    }



    public function listarVentas($numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarVentas/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceVenta->listarVentas($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = False;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarVentas';
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = 'Ventas';
        $view = './modules/ventas/views/listar-ventas.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function mostrarCargarVenta()
    {
        $resultados = $this->serviceVenta->mostrarCargarVenta();
        $mostrarTodosClientes = $resultados[0];
        $mostrarTodosEmpleados = $resultados[1];
        $mostrarTodosProductos = $resultados[2];
        $mostrarTodosMetodosPagos = $resultados[3];
        $view = './modules/ventas/views/cargar-venta.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function procesarCargarVenta($idCliente, $idEmpleado, $productos, $subTotalVenta, $totalVenta, $idMetodoPago)
    {
        $resultado = $this->serviceVenta->procesarCargarVenta($idCliente, $idEmpleado, $productos, $subTotalVenta, $totalVenta, $idMetodoPago);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarVentas($filtro, $numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarVentas/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceVenta->filtrarListarVentas($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = True;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/filtrarListarVentas';
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = 'Ventas';
        $view = './modules/ventas/views/listar-ventas.php';
        require_once ('./modules/views/layouts/main.php');
    }
}
?>