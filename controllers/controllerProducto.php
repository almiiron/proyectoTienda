<?php
require_once ('./models/classProducto.php');
require_once ('./services/serviceProducto.php');
require_once ('controllerCategoria.php');
require_once ('controllerProveedor.php');
class ControllerProducto
{
    private $conexion;
    private $proveedores;
    private $categorias;
    private $paginationController;
    private $modeloProductos;
    private $serviceProducto;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->paginationController = new ControllerPagination($this->conexion, 30);
        $this->proveedores = new controllerProveedor($this->conexion);
        $this->categorias = new ControllerCategoria($this->conexion);
        $this->modeloProductos = new Productos($this->conexion);
        $this->serviceProducto = new ServiceProducto($this->conexion);
    }

    public function procesarCargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $resultado = $this->serviceProducto->cargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function listarProductos($numPage)
    {
        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://localhost/proyectoTienda/page/listarProductos/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        } else {
            $start = $numPage * $this->paginationController->size - $this->paginationController->size;
        }
        $innerJoin = "  INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor ";
        $totalRows = $this->paginationController->getTotalRows('productos prod' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas

        $lista = $this->modeloProductos->listarProductos($start, $this->paginationController->size);

        if ($lista) { //si hay productos para mostrar, ejecuta esto
            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_producto']; // Agregar cada ID al array
            }
        }
        $contenedor = "Producto";
        $base_url = 'http://localhost/proyectoTienda/page/listarProductos';
        $titulo = "Producto";
        $tituloTabla = "Productos";
        $limpiarFiltros = False;
        $mostrarBuscadorEnNavbar = true;
        $encabezados = array("ID Producto", "Nombre del Producto", "Categoria", "Proveedor", "Precio", "Stock");
        require_once ('./views/layouts/header.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');

    }

    public function mostrarModificarProducto($id)
    {

        $listaProveedores = $this->proveedores->mostrarProveedores();
        $listaCategorias = $this->categorias->mostrarCategorias();

        $buscarProducto = $this->modeloProductos->listarUnProducto($id);
        $datosProducto = $buscarProducto;
        require_once ('./views/layouts/header.php');
        require_once ('./views/modificar/modificar-producto.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarModificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $resultado = $this->serviceProducto->modificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto);

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function filtrarListarProductos($filtro, $numPage)
    {

        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://localhost/proyectoTienda/page/filtrarListarProductoss/1');
        } else {
            $start = $numPage * $this->paginationController->size - $this->paginationController->size;
        }

        $where_clause = $this->modeloProductos->prepararFiltrosProductos($filtro);
        $where_clause_Pagination = "  INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor " . $where_clause;
        $totalRows = $this->paginationController->getTotalRows('productos prod', $where_clause_Pagination); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas
        $lista = $this->modeloProductos->listaFiltradaProductos($where_clause, $start, $this->paginationController->size);

        if ($lista) {   //si hay productos para mostrar, ejecuta esto
            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_producto']; // Agregar cada ID al array
            }
        }
        //si no hay categorias que mostrar, ejecuta esto
        $contenedor = "Producto";
        $titulo = "Producto";
        $mostrarBuscadorEnNavbar = true;
        $tituloTabla = "Productos";
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarProductos';
        $limpiarFiltros = True;
        $encabezados = array("ID Producto", "Nombre del Producto", "Categoria", "Proveedor", "Precio", "Stock");
        require_once ('./views/layouts/header.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');

    }

    public function procesarCambiarEstadoProducto($id, $estadoActual)
    {
        $resultado = $this->serviceProducto->cambiarEstadoProducto($id,$estadoActual);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}
?>