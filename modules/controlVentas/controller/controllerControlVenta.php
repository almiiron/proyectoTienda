<?php
require_once ('./modules/controlVentas/service/serviceControlVenta.php');

class ControllerControlVenta
{
    private $serviceControlVenta;
    public function __construct($conexion)
    {
        $this->serviceControlVenta = new ServiceControlVenta($conexion);
    }

    public function controlVentas()
    {
        $ingresosHoy = $this->serviceControlVenta->ingresosHoy();
        $cantidadProductosVendidosHoy = $this->serviceControlVenta->cantidadProductosVendidosHoy();
        $cantidadClientesHoy = $this->serviceControlVenta->cantidadClientesHoy();
        $promedioVentasHoy = $this->serviceControlVenta->promedioVentasHoy();
        $view = './modules/controlVentas/views/control-ventas.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function productosMasVendidos()
    {
        $resultado = $this->serviceControlVenta->productosMasVendidos();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function categoriasConMasVentas()
    {
        $resultado = $this->serviceControlVenta->categoriasConMasVentas();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function totalVentasCadaMesDelAnio()
    {
        $resultado = $this->serviceControlVenta->totalVentasCadaMesDelAnio();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function ingresosUltimosSieteDias()
    {
        $resultado = $this->serviceControlVenta->ingresosUltimosSieteDias();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }

    public function ingresosUltimasCuatroSemanas()
    {
        $resultado = $this->serviceControlVenta->ingresosUltimasCuatroSemanas();
        // Convierte el array a formato JSON y lo envía como respuesta
        echo json_encode($resultado);
    }
}
?>