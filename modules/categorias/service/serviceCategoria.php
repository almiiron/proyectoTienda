<?php
require_once ('./modules/categorias/model/classCategoria.php');
class ServiceCategoria
{
    private $conexion;
    private $modeloCategorias;
    private $paginationController;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->modeloCategorias = new Categorias($this->conexion);
        $this->paginationController = new ControllerPagination($this->conexion, 30);
    }

    public function cargarCategoria($nombreCategoria)
    {
        $categoriaCargada = $this->modeloCategorias->buscarCategoria(null, $nombreCategoria);

        if ($categoriaCargada) { //significa que la categoria no existe en la bd
            $estado = False;
            $message = '¡La categoria cargada ya existe!';
            return ['success' => $estado, 'message' => $message];
        }

        $cargarCategoria = $this->modeloCategorias->cargarCategoria($nombreCategoria);
        if ($cargarCategoria) {
            $estado = True;
            $message = "¡Se cargó correctamente la categoria!";
        } else {
            $message = "¡Hubo un error al cargar la categoria!";
            $estado = False;
        }
        return ['success' => $estado, 'message' => $message];
    }

    public function cambiarEstadoCategoria($id, $estadoActual)
    {
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }
        $cambiarEstadoCategoria = $this->modeloCategorias->cambiarEstadoCategoria($id, $nuevoEstado);
        if ($cambiarEstadoCategoria) {
            $estado = True;
            $message = '¡La categoría se modificó correctamente!';
        } else {
            $estado = False;
            $message = 'Hubo un error al intentar modificar la categoría.';
        }
        return ['success' => $estado, 'message' => $message];
    }

    public function modificarCategoria($id, $nombreCategoria)
    {

        $categoriaCargada = $this->modeloCategorias->buscarCategoria(null, $nombreCategoria);
        if ($categoriaCargada) {
            $estado = False;
            $message = '¡La categoria cargada ya existe!';
            return ['success' => $estado, 'message' => $message];
        }

        $modificarCategoria = $this->modeloCategorias->procesarModificarCategoria($id, $nombreCategoria);
        if ($modificarCategoria) {
            $estado = True;
            $message = '¡La categoria se modificó con correctamente!';
        } else {
            $estado = False;
            $message = 'Hubo un error al intentar modificar la categoría.';
        }
        return ['success' => $estado, 'message' => $message];
    }

    public function listarCategorias($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;


        $totalRows = $this->paginationController->getTotalRows('categorias'); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modeloCategorias->listarCategorias($start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_categoria']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function filtrarListarCategorias($filtro, $numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $where_clause = $this->modeloCategorias->prepararFiltrosCategorias($filtro); //preparo los filtros
        $totalRows = $this->paginationController->getTotalRows('categorias', $where_clause); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas
        $lista = $this->modeloCategorias->listaFiltradaCategorias($where_clause, $start, $this->paginationController->size); //obtengo los datos filtrados

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_categoria']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function listarUnaCategoria($id, $nombreCategoria){
        $categoria = $this->modeloCategorias->listarUnaCategoria($id, $nombreCategoria);
        return $categoria;
    }

    public function mostrarCategorias(){
        $lista = $this->modeloCategorias->mostrarCategorias(); //los datos a mostrar
        if ($lista) {
            // Si hay categorías, devuelve la lista
            return $lista;
        } else {
            // Si no hay categorías, devuelve un array vacío
            return array();
        }
    }
}
?>