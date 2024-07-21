<?php
require_once ('./modules/panelControl/model/classPanelControl.php');

class ServicePanelControl
{

    private $modelPanelControl;

    public function __construct($conexion)
    {
        $this->modelPanelControl = new ClassPanelControl($conexion);
    }

    public function productosMasVendidos()
    {
        $resultado = $this->modelPanelControl->productosMasVendidos();
        return $resultado;
    }

    public function categoriasConMasVentas()
    {
        $resultado = $this->modelPanelControl->categoriasConMasVentas();
        return $resultado;
    }

    public function ingresosHoy(){
        $resultado = $this->modelPanelControl->ingresosHoy();
        return $resultado;
    }

    public function cantidadProductosVendidosHoy(){
        $resultado = $this->modelPanelControl->cantidadProductosVendidosHoy();
        return $resultado;
    }

    public function cantidadClientesHoy(){
        $resultado = $this->modelPanelControl->cantidadClientesHoy();
        return $resultado;
    }

    public function promedioVentasHoy(){
        $resultado = $this->modelPanelControl->promedioVentasHoy();
        return $resultado;
    }
   
    public function totalVentasCadaMesDelAnio(){
        $resultado = $this->modelPanelControl->totalVentasCadaMesDelAnio();
        return $resultado;
    }
   
    public function ingresosUltimosSieteDias(){
        $resultado = $this->modelPanelControl->ingresosUltimosSieteDias();
        return $resultado;
    }
    
    public function ingresosUltimasCuatroSemanas(){
        $resultado = $this->modelPanelControl->ingresosUltimasCuatroSemanas();
        return $resultado;
    }
}

?>