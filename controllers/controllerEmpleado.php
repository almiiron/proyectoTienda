<?php
require_once ('./services/serviceEmpleado.php');
class ControllerEmpleado{
    private $serviceEmpleado;
    public function __construct($conexion) {
        $this->serviceEmpleado= new ServiceEmpleado($conexion);
    }
    public function listarEmpleados($numPage){

        if ($numPage == "" || $numPage <= 0) {

            header('location:http://localhost/proyectoTienda/page/listarEmpleados/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }

        $resultado = $this->serviceEmpleado->listarEmpleados($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $contenedor = "Empleado";
        $base_url = 'http://localhost/proyectoTienda/page/listarEmpleados';
        $titulo = "Empleado";
        $tituloTabla = "Empleados";
        $limpiarFiltros = False;
        $mostrarBuscadorEnNavbar = true;
        $encabezados = array("ID Empleado", "Nombre del Empleado", "Apellido del Empleado", "Nombre de Usuario", "Contacto");
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }
}
?>