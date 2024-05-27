<?php
require_once ('./services/serviceCategoria.php');

class ControllerCategoria
{
    private $conexion;
    // private $modeloCategorias;
    private $serviceCategoria;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        // $this->modeloCategorias = new Categorias($conexion);
        $this->serviceCategoria = new ServiceCategoria($this->conexion);
    }

    public function procesarCargarCategoria($nombreCategoria)
    {
        $resultado = $this->serviceCategoria->cargarCategoria($nombreCategoria);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }


    public function listarCategorias($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://localhost/proyectoTienda/page/listarCategorias/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        }

        $resultado = $this->serviceCategoria->listarCategorias($numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];
        $limpiarFiltros = False;
        $base_url = 'http://localhost/proyectoTienda/page/listarCategorias';
        $tituloTabla = "Categorias";
        $contenedor = "Categoria";
        $mostrarBuscadorEnNavbar = true;
        $titulo = "Categoria";
        $tituloTabla = "Categorias";
        $encabezados = array("ID Categoria", "Nombre de la Categoria");

        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }

    // public function mostrarCategorias()
    // {
    //     $lista = $this->serviceCategoria->mostrarCategorias();
    //     return $lista;
    // }

    public function procesarCambiarEstadoCategoria($id, $estadoActual)
    {
        $resultado = $this->serviceCategoria->cambiarEstadoCategoria($id, $estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function mostrarModificarCategoria($id)
    {
        if (empty($id)) {
            header('location:http://localhost/proyectoTienda/page/listarCategorias/1');
            exit();
        }
        // $buscarCategoria = $this->modeloCategorias->listarUnaCategoria($id, null, $this->conexion);
        $buscarCategoria = $this->serviceCategoria->listarUnaCategoria($id, null);
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/modificar/modificar-categoria.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarModificarCategoria($id, $nombre_categoria)
    {
        $resultado = $this->serviceCategoria->modificarCategoria($id, $nombre_categoria);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }


    public function filtrarListarCategorias($filtro, $numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            header('location:http://localhost/proyectoTienda/page/filtrarListarCategorias/1');
        }


        $resultado = $this->serviceCategoria->filtrarListarCategorias($filtro, $numPage);
        $lista = $resultado[0];
        $pages = $resultado[1];
        $ids = $resultado[2];

        $limpiarFiltros = True;
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarCategorias';
        $tituloTabla = "Categorias";
        $contenedor = "Categoria";
        $mostrarBuscadorEnNavbar = true;
        $titulo = "Categoria";
        $tituloTabla = "Categorias";
        $encabezados = array("ID Categoria", "Nombre de la Categoria");
        require_once ('./views/layouts/header.php');
        require_once ('./views/layouts/navBar.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }
}

?>