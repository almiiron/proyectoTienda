<?php
require_once ('./modules/clientes/service/serviceCliente.php');
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
            header('location:http://' . IP_HOST . '/proyectoTienda/page/listarClientes/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceCliente->listarClientes($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = False;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/listarClientes';
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = 'Clientes';
        $view = './modules/clientes/views/listar-clientes.php';
        require_once ('./modules/views/layouts/main.php');
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
        $view = './modules/clientes/views/modificar-cliente.php';
        require_once ('./modules/views/layouts/main.php');
    }
    public function procesarModificarCliente($idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono)
    {
        $resultado = $this->serviceCliente->procesarModificarCliente($idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarClientes($filtro, $numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://' . IP_HOST . '/proyectoTienda/page/filtrarListarClientes/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }
        $resultado = $this->serviceCliente->filtrarListarClientes($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = True;
        $base_url = 'http://' . IP_HOST . '/proyectoTienda/page/filtrarListarClientes';
        $tituloTabla = "Clientes";
        $mostrarBuscadorEnNavbar = true;
        $view = './modules/clientes/views/listar-clientes.php';
        require_once ('./modules/views/layouts/main.php');
    }

}
?>