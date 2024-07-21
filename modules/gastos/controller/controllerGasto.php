<?php
require_once './modules/gastos/service/serviceGasto.php';

class ControllerGasto
{
    private $serviceGasto;

    public function __construct($conexion)
    {
        $this->serviceGasto = new ServiceGasto($conexion);
    }

    public function listarGastos($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarGastos/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceGasto->listarGastos($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $listaEmpleados = $resultado[3];
        $listaMetodosPagos = $resultado[4];
        $listarCategoriasGastos = $resultado[5];
        $limpiarFiltros = False;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarGastos';
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = 'Gastos';
        $view = './modules/gastos/views/listar-gastos.php';
        require_once './modules/views/layouts/main.php';
    }

    public function procesarCargarGasto(
        $categoriaGasto,
        $descripcionGasto,
        $empleadoGasto,
        $metodoPagoGasto,
        $precioTotalGasto,
        $fecha,
        $hora,
        $comentarioGasto
    ) {
        $resultado = $this->serviceGasto->procesarCargarGasto(
            $categoriaGasto,
            $descripcionGasto,
            $empleadoGasto,
            $metodoPagoGasto,
            $precioTotalGasto,
            $fecha,
            $hora,
            $comentarioGasto
        );
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function mostrarModificarGasto($id)
    {
        $resultado= $this->serviceGasto->mostrarModificarGasto($id);
        $listarUnGasto = $resultado[0];
        $listaEmpleados = $resultado[1];
        $listaMetodosPagos = $resultado[2];
        $listarCategoriasGastos = $resultado[3];
        $view = './modules/gastos/views/modificar-gasto.php';
        require_once './modules/views/layouts/main.php';
    }

    public function procesarModificarGasto(
        $idGasto,
        $categoriaGasto,
        $descripcionGasto,
        $empleadoGasto,
        $metodoPagoGasto,
        $precioTotalGasto,
        $fecha,
        $hora,
        $comentarioGasto
    ) {
        $resultado = $this->serviceGasto->procesarModificarGasto(
            $idGasto,
            $categoriaGasto,
            $descripcionGasto,
            $empleadoGasto,
            $metodoPagoGasto,
            $precioTotalGasto,
            $fecha,
            $hora,
            $comentarioGasto
        );
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function procesarCambiarEstadoGasto($id, $estadoActual)
    {
        $resultado = $this->serviceGasto->cambiarEstadoGasto($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}
?>