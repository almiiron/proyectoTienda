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

            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarEmpleados/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }

        $resultado = $this->serviceEmpleado->listarEmpleados($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarEmpleados';
        $tituloTabla = "Empleados";
        $limpiarFiltros = False;
        $mostrarBuscadorEnNavbar = true;
        $view = './modules/empleados/views/listar-empleados.php';
        require_once ('./modules/conexion/model/classConexion.php');
        $conexion = new Conexion();
        $conexion->obtenerConexion();
        require_once ('./modules/views/layouts/main.php');

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
            header('location:http://' . IP_HOST . '/proyectoTienda/page/filtrarListarEmpleados/1');
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
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/filtrarListarEmpleados';
        $limpiarFiltros = True;

        require_once ('./modules/conexion/model/classConexion.php');
        $conexion = new Conexion();
        $conexion->obtenerConexion();
        $encabezados = array("ID Empleado", "Nombre del Empleado", "Apellido del Empleado", "Nombre de Usuario", "Contacto");
        $view = './modules/empleados/views/listar-empleados.php';
        require_once ('./modules/views/layouts/main.php');
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

        $view = './modules/empleados/views/modificar-empleado.php';
        require_once ('./modules/views/layouts/main.php');
    }

    public function procesarModificarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $idEmpleado, $idPersona, $idContacto, $idUsuario)
    {
        $resultado = $this->serviceEmpleado->procesarModificarEmpleado(
            $nombreEmpleado,
            $apellidoEmpleado,
            $contactoEmpleado,
            $idRol,
            $idEmpleado,
            $idPersona,
            $idContacto,
            $idUsuario
        );
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}
?>