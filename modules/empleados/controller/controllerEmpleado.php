<?php
require_once ('./modules/empleados/service/serviceEmpleado.php');
class ControllerEmpleado
{
    private $serviceEmpleado;
    public function __construct($conexion)
    {
        $this->serviceEmpleado = new ServiceEmpleado($conexion);
    }
    public function listarEmpleados($numPage)
    {

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
        require_once ('./modules/views/layouts/header.php');
        require_once ('./modules/views/layouts/navBar.php');
        require_once ('./modules/views/listar/listar-table.php');
        require_once ('./modules/views/layouts/footer.php');
    }

    public function procesarCargarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $usuarioEmpleado, $passwordEmpleado)
    {
        $resultado = $this->serviceEmpleado->cargarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $usuarioEmpleado, $passwordEmpleado);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function procesarCambiarEstadoEmpleado($id, $estadoActual)
    {
        $resultado = $this->serviceEmpleado->cambiarEstadoEmpleado($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarEmpleados($filtro, $numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://localhost/proyectoTienda/page/filtrarListarEmpleados/1');
        }

        $resultado = $this->serviceEmpleado->filtrarListarEmpleados($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];

        //si no hay categorias que mostrar, ejecuta esto
        $contenedor = "Empleado";
        $titulo = "Empleado";
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = "Empleados";
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarEmpleados';
        $limpiarFiltros = True;
        $encabezados = array("ID Empleado", "Nombre del Empleado", "Apellido del Empleado", "Nombre de Usuario", "Contacto");
        require_once ('./modules/views/layouts/header.php');
        require_once ('./modules/views/layouts/navBar.php');
        require_once ('./modules/views/listar/listar-table.php');
        require_once ('./modules/views/layouts/footer.php');
    }

    public function mostrarModificarEmpleado($id)
    {
        $resultados = $this->serviceEmpleado->mostrarModificarEmpleado($id);
        $idPersona = $resultados[0];
        $nombrePersona = $resultados[1];
        $apellidoPersona = $resultados[2];
        $idContacto = $resultados[3];
        $telefono = $resultados[4];
        $roles = $resultados[5];
        $idUsuario = $resultados[6];
        $idRol = $resultados[7];
        require_once ('./modules/views/layouts/header.php');
        require_once ('./modules/views/layouts/navBar.php');
        require_once ('./modules/empleados/views/modificar-empleado.php');
        require_once ('./modules/views/layouts/footer.php');
    }

    public function procesarModificarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $idEmpleado, $idPersona, $idContacto, $idUsuario)
    {
        $resultado = $this->serviceEmpleado->procesarModificarEmpleado($nombreEmpleado, $apellidoEmpleado, 
        $contactoEmpleado, $idRol, $idEmpleado, $idPersona, $idContacto, $idUsuario);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}
?>