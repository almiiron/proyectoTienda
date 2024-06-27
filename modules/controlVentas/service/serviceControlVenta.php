<?php
require_once ('./modules/controlVentas/model/classControlVenta.php');

class ServiceControlVenta
{

    private $modelControlVenta;

    public function __construct($conexion)
    {
        $this->modelControlVenta = new classControlVenta($conexion);
    }

    public function productosMasVendidos()
    {
        $resultado = $this->modelControlVenta->productosMasVendidos();
        return $resultado;
    }

    public function categoriasConMasVentas()
    {
        $resultado = $this->modelControlVenta->categoriasConMasVentas();
        return $resultado;
    }

    public function ingresosHoy(){
        $resultado = $this->modelControlVenta->ingresosHoy();
        return $resultado;
    }

    public function cantidadProductosVendidosHoy(){
        $resultado = $this->modelControlVenta->cantidadProductosVendidosHoy();
        return $resultado;
    }

    public function cantidadClientesHoy(){
        $resultado = $this->modelControlVenta->cantidadClientesHoy();
        return $resultado;
    }

    public function promedioVentasHoy(){
        $resultado = $this->modelControlVenta->promedioVentasHoy();
        return $resultado;
    }
   
    public function totalVentasCadaMesDelAnio(){
        $resultado = $this->modelControlVenta->totalVentasCadaMesDelAnio();
        return $resultado;
    }
   
    public function ingresosUltimosSieteDias(){
        $resultado = $this->modelControlVenta->ingresosUltimosSieteDias();
        return $resultado;
    }
    
    public function ingresosUltimasCuatroSemanas(){
        $resultado = $this->modelControlVenta->ingresosUltimasCuatroSemanas();
        return $resultado;
    }
}

?>