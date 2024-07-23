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

    public function ingresosHoy()
    {
        $resultado = $this->modelPanelControl->ingresosHoy();
        return $resultado;
    }

    public function cantidadProductosVendidosHoy()
    {
        $resultado = $this->modelPanelControl->cantidadProductosVendidosHoy();
        return $resultado;
    }

    public function cantidadClientesHoy()
    {
        $resultado = $this->modelPanelControl->cantidadClientesHoy();
        return $resultado;
    }

    public function promedioVentasHoy()
    {
        $resultado = $this->modelPanelControl->promedioVentasHoy();
        return $resultado;
    }

    public function totalVentasCadaMesDelAnio()
    {
        $resultado = $this->modelPanelControl->totalVentasCadaMesDelAnio();
        return $resultado;
    }

    public function ingresosUltimosSieteDias()
    {
        $resultado = $this->modelPanelControl->ingresosUltimosSieteDias();
        return $resultado;
    }

    public function ingresosUltimasCuatroSemanas()
    {
        $resultado = $this->modelPanelControl->ingresosUltimasCuatroSemanas();
        return $resultado;
    }

    public function ingresosDiariosPorMes()
    {
        $resultado = $this->modelPanelControl->ingresosDiariosPorMes();
        return $resultado;
    }

    public function ingresosTotalHistorico()
    {
        $resultado = $this->modelPanelControl->ingresosTotalHistorico();
        return $resultado;
    }

    public function comprasTotalesHistorico()
    {
        $resultado = $this->modelPanelControl->comprasTotalesHistorico();
        return $resultado;
    }

    public function gastosTotalesHistorico()
    {
        $resultado = $this->modelPanelControl->gastosTotalesHistorico();
        return $resultado;
    }

    public function gananciaRealHistorico()
    {
        $resultado = $this->modelPanelControl->gananciaRealHistorico();
        return $resultado;
    }

    public function totalComprasCadaMesDelAnio()
    {
        $resultado = $this->modelPanelControl->totalComprasCadaMesDelAnio();
        return $resultado;
    }

    public function categoriasConMasCompras()
    {
        $resultado = $this->modelPanelControl->categoriasConMasCompras();
        return $resultado;
    }

    public function productosMasComprados()
    {
        $resultado = $this->modelPanelControl->productosMasComprados();
        return $resultado;
    }

    public function totalGastosCadaMesDelAnio()
    {
        $resultado = $this->modelPanelControl->totalGastosCadaMesDelAnio();
        return $resultado;
    }

    public function categoriasConMasGastos()
    {
        $resultado = $this->modelPanelControl->categoriasConMasGastos();
        return $resultado;
    }

    public function categoriasMasRepetidasGastos()
    {
        $resultado = $this->modelPanelControl->categoriasMasRepetidasGastos();
        return $resultado;
    }

    public function datosDiariosPorMes()
    {
        $resultado = $this->modelPanelControl->datosDiariosPorMes();
        return $resultado;
    }

    public function obtenerTotalesDelMes()
    {
        $resultado = $this->modelPanelControl->obtenerTotalesDelMes();
        return $resultado;
    }

    public function obtenerDatosMensuales()
    {
        $resultado = $this->modelPanelControl->obtenerDatosMensuales();
        return $resultado;
    }

    public function obtenerRentabilidadProductos()
    {
        $resultado = $this->modelPanelControl->obtenerRentabilidadProductos();
        return $resultado;
    }

}

?>