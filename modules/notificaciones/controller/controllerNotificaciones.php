<?php
require_once './modules/notificaciones/service/serviceNotificaciones.php';

class ControllerNotificaciones
{
    private $serviceNotificaciones;

    public function __construct($conexion)
    {
        $this->serviceNotificaciones = new ServiceNotificaciones($conexion);
    }

    public function listarNotificaciones($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarNotificaciones/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }

        $resultado = $this->serviceNotificaciones->listarNotificaciones($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = False;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarNotificaciones';
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = "Categorias";
        $view = './modules/notificaciones/views/listar-notificaciones.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function procesarCambiarEstadoNotificacion($id, $estadoActual)
    {
        $resultado = $this->serviceNotificaciones->cambiarEstadoNotificacion($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function obtenerNotificacionesNoLeidas()
    {
        $notificaciones = $this->serviceNotificaciones->obtenerNotificacionesNoLeidas();
        header('Content-Type: application/json');
        echo json_encode($notificaciones);
    }
}
?>