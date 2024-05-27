<?php
require_once ('./services/serviceProveedor.php');
class ControllerProveedor
{
    private $serviceProveedor;
    public function __construct($conexion)
    {
        $this->serviceProveedor = new ServiceProveedor($conexion);
    }

    public function procesarCargarProveedor($nombreProveedor, $contactoProveedor)
    {
        $resultado = $this->serviceProveedor->cargarProveedor($nombreProveedor, $contactoProveedor);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function listarProveedores($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://localhost/proyectoTienda/page/listarProveedores/1');
        }

        $resultado = $this->serviceProveedor->listarProveedores($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $contenedor = "Proveedor";
        $base_url = 'http://localhost/proyectoTienda/page/listarProveedores';
        $titulo = "Proveedor";
        $tituloTabla = "Proveedores";
        $mostrarBuscadorEnNavbar = true;
        $limpiarFiltros = False;
        $encabezados = array("ID Proveedor", "Nombre Proveedor", "Contacto");
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }

    // public function mostrarProveedores()
    // {
    //     $lista = $this->serviceProveedor->mostrarProveedores();
    //     return $lista;
    // }

    public function procesarCambiarEstadoProveedor($id, $estadoActual)
    {
        $resultado = $this->serviceProveedor->cambiarEstadoProveedor($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function mostrarModificarProveedor($id)
    {
        if (empty($id)) {
            header('location:http://localhost/proyectoTienda/page/listarProveedores/1');
            exit();
        }
        $buscarProveedor = $this->serviceProveedor->listarUnProveedor($id);
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/modificar/modificar-proveedor.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarModificarProveedor($idProveedor, $idContacto, $nombreProveedor, $contactoProveedor)
    {
        $resultado = $this->serviceProveedor->modificarProveedor($idProveedor, $idContacto, $nombreProveedor, $contactoProveedor);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }



    public function filtrarListarProveedores($filtro, $numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://localhost/proyectoTienda/page/filtrarListarProveedores/1');
        }

        $resultado = $this->serviceProveedor->filtrarListarProveedores($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $contenedor = "Proveedor";
        $titulo = "Proveedor";
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarProveedores';
        $tituloTabla = "Proveedores";
        $mostrarBuscadorEnNavbar = true;
        $limpiarFiltros = True;
        $encabezados = array("ID Proveedor", "Nombre Proveedor", "Contacto");
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');

    }
}
?>