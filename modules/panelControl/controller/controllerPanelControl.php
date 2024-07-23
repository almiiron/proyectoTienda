<?php
require_once ('./modules/panelControl/service/servicePanelControl.php');

class ControllerPanelControl
{
    private $servicePanelControl;
    public function __construct($conexion)
    {
        $this->servicePanelControl = new ServicePanelControl($conexion);
    }

    public function panelControl()
    {
        $ingresosHoy = $this->servicePanelControl->ingresosHoy();
        $cantidadProductosVendidosHoy = $this->servicePanelControl->cantidadProductosVendidosHoy();
        $cantidadClientesHoy = $this->servicePanelControl->cantidadClientesHoy();
        $promedioVentasHoy = $this->servicePanelControl->promedioVentasHoy();
        $ingresosTotalHistorico = $this->servicePanelControl->ingresosTotalHistorico();
        $comprasTotalesHistorico = $this->servicePanelControl->comprasTotalesHistorico();
        $gastosTotalesHistorico = $this->servicePanelControl->gastosTotalesHistorico();
        $gananciaRealHistorico = $this->servicePanelControl->gananciaRealHistorico();
        $view = './modules/panelControl/views/listar-panel-control.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function productosMasVendidos()
    {
        $resultado = $this->servicePanelControl->productosMasVendidos();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function categoriasConMasVentas()
    {
        $resultado = $this->servicePanelControl->categoriasConMasVentas();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function totalVentasCadaMesDelAnio()
    {
        $resultado = $this->servicePanelControl->totalVentasCadaMesDelAnio();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function ingresosUltimosSieteDias()
    {
        $resultado = $this->servicePanelControl->ingresosUltimosSieteDias();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function ingresosUltimasCuatroSemanas()
    {
        $resultado = $this->servicePanelControl->ingresosUltimasCuatroSemanas();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function ingresosDiariosPorMes()
    {
        $resultado = $this->servicePanelControl->ingresosDiariosPorMes();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function totalComprasCadaMesDelAnio()
    {
        $resultado = $this->servicePanelControl->totalComprasCadaMesDelAnio();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function categoriasConMasCompras()
    {
        $resultado = $this->servicePanelControl->categoriasConMasCompras();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function productosMasComprados()
    {
        $resultado = $this->servicePanelControl->productosMasComprados();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function totalGastosCadaMesDelAnio()
    {
        $resultado = $this->servicePanelControl->totalGastosCadaMesDelAnio();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function categoriasConMasGastos()
    {
        $resultado = $this->servicePanelControl->categoriasConMasGastos();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function categoriasMasRepetidasGastos()
    {
        $resultado = $this->servicePanelControl->categoriasMasRepetidasGastos();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function datosDiariosPorMes()
    {
        $resultado = $this->servicePanelControl->datosDiariosPorMes();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function obtenerTotalesDelMes()
    {
        $resultado = $this->servicePanelControl->obtenerTotalesDelMes();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function obtenerDatosMensuales()
    {
        $resultado = $this->servicePanelControl->obtenerDatosMensuales();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function obtenerRentabilidadProductos()
    {
        $resultado = $this->servicePanelControl->obtenerRentabilidadProductos();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

}
?>