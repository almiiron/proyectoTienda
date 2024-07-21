<?php
require_once './modules/notificaciones/model/classNotificaciones.php';

class ServiceNotificaciones
{
    private $modelNotificaciones;
    private $paginationController;
    private  $servicioProducto;
    public function __construct($conexion, $serviceProducto = null)
    {
        $this->modelNotificaciones = new ClassNotificaciones($conexion);
        $this->paginationController = new ControllerPagination($conexion, 30);
        $this->servicioProducto = $serviceProducto;
        // var_dump($this->servicioProducto);
    }

    public function listarNotificaciones($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;


        $totalRows = $this->paginationController->getTotalRows('notificaciones'); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modelNotificaciones->listarNotificaciones($start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_notif']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function cargarNotificacion($mensaje, $tipo)
    {
        $resultado = $this->modelNotificaciones->cargarNotificacion($mensaje, $tipo);
        return $resultado;
    }

    public function cambiarEstadoNotificacion($id, $estadoActual)
    {
        $nuevoEstado = ($estadoActual == 'Activo') ? 'Inactivo' : 'Activo';
        $resultado = $this->modelNotificaciones->cambiarEstadoNotificacion($id, $nuevoEstado);

        if ($resultado) {
            $estado = True;
            $message = '¡La notificación se modificó con correctamente!';
        } else {
            $estado = False;
            $message = 'Hubo un error al intentar modificar la notificación.';
        }
        return ['success' => $estado, 'message' => $message];
    }

    public function obtenerNotificacionesNoLeidas()
    {
        return $this->modelNotificaciones->obtenerNotificacionesNoLeidas();
    }
    public function filtrarListarNotificaciones($filtro, $numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $where_clause = $this->modelNotificaciones->prepararFiltrosNotificaciones($filtro); //preparo los filtros
        $totalRows = $this->paginationController->getTotalRows('notificaciones ', $where_clause); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas
        $lista = $this->modelNotificaciones->listaFiltradaNotificaciones($where_clause, $start, $this->paginationController->size); //obtengo los datos filtrados

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_notif']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }
}
?>