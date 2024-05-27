<?php
require_once('./models/classEmpleado.php');
require_once('./controllers/controllerPagination.php');
class ServiceEmpleado{
    private $modeloEmpleado;
    private $paginationController;
    public function __construct($conexion){
        $this->modeloEmpleado = new Empleado($conexion);
        $this->paginationController = new controllerPagination($conexion, 30); 
    }

    public function listarEmpleados($numPage){
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = " INNER JOIN personas pe ON pe.id_persona = em.id_persona 
        INNER JOIN usuarios us ON em.id_usuario = us.id_usuario
        INNER JOIN contactos c ON c.id_contacto = pe.id_contacto ";
        $totalRows = $this->paginationController->getTotalRows('empleados em' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas

        $lista = $this->modeloEmpleado->listarEmpleados($start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay productos para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_empleado']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }
}
?>