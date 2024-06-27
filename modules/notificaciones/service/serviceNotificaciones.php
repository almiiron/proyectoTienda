<?php
require_once './modules/notificaciones/model/classNotificaciones.php';

class ServiceNotificaciones
{
    private $modelNotificaciones;
    private $paginationController;
    public function __construct($conexion)
    {
        $this->modelNotificaciones = new ClassNotificaciones($conexion);
        $this->paginationController = new ControllerPagination($conexion, 30);
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

    public function obtenerNotificacionesNoLeidas() {
        return $this->modelNotificaciones->obtenerNotificacionesNoLeidas();
    }

}
?>