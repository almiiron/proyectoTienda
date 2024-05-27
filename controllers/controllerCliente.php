<?php
require_once ('./services/serviceCliente.php');
class ControllerCliente
{
    private $conexion;
    private $serviceCliente;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->serviceCliente = new ServiceCliente($this->conexion);
    }

    public function listarClientes($numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            header('location:http://localhost/proyectoTienda/page/listarClientes/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceCliente->listarClientes($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = False;
        $base_url = 'http://localhost/proyectoTienda/page/listarClientes';
        $tituloTabla = "Clientes";
        $contenedor = "Cliente";
        $mostrarBuscadorEnNavbar = true;
        $titulo = "Cliente";
        $tituloTabla = "Clientes";
        $encabezados = array("ID Cliente", "Nombre del Cliente", "Apellido del Cliente", "Contacto");

        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarCargarCliente($nombreCliente, $apellidoCliente, $telefonoCliente)
    {
        $resultado = $this->serviceCliente->cargarCliente($nombreCliente, $apellidoCliente, $telefonoCliente);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
    public function procesarCambiarEstadoCliente($id, $estadoActual)
    {
        $resultado = $this->serviceCliente->cambiarEstadoCliente($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function mostrarModificarCliente($id)
    {
        $resultados = $this->serviceCliente->mostrarModificarCliente($id);
        $idPersona = $resultados[0];
        $nombrePersona = $resultados[1];
        $apellidoPersona = $resultados[2];
        $idContacto = $resultados[3];
        $telefono = $resultados[4];
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/modificar/modificar-cliente.php');
        require_once ('./views/layouts/footer.php');

    }
    public function procesarModificarCliente($idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono)
    {
        $resultado = $this->serviceCliente->procesarModificarCliente($idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarClientes($filtro, $numPage){
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://localhost/proyectoTienda/page/filtrarListarClientes/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceCliente->filtrarListarClientes($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = True;
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarClientes';
        $tituloTabla = "Clientes";
        $contenedor = "Cliente";
        $mostrarBuscadorEnNavbar = true;
        $titulo = "Cliente";
        $tituloTabla = "Clientes";
        $encabezados = array("ID Cliente", "Nombre del Cliente", "Apellido del Cliente", "Contacto");

        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }

}
?>