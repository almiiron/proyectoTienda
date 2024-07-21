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
}
?>