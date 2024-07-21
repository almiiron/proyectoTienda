<?php
require_once './modules/gastos/model/classGasto.php';
require_once './modules/notificaciones/service/serviceNotificaciones.php';


class ServiceGasto
{
    private $modelGasto;
    private $paginationController;
    private $serviceNotificaciones;
    private $serviceEmpleados;

    public function __construct($conexion)
    {
        $this->modelGasto = new ClassGasto($conexion);
        $this->serviceNotificaciones = new ServiceNotificaciones($conexion);
        $this->paginationController = new ControllerPagination($conexion, 30);
        $this->serviceEmpleados = new ServiceEmpleado($conexion);

    }

    public function listarGastos($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = " 
                     JOIN 
                        empleados e ON g.id_empleado = e.id_empleado
                    JOIN 
                        personas p2 ON e.id_persona = p2.id_persona
                    JOIN 
                        metodos_pagos mp ON g.id_metodo_pago = mp.id_medio_pago 
                    ";

        $totalRows = $this->paginationController->getTotalRows('gastos g' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modelGasto->listarGastos($start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_gasto']; // Agregar cada ID al array
            }
        }
        $listaEmpleados = $this->serviceEmpleados->mostrarTodosEmpleados();
        $mostrarTodosMetodosPagos = $this->modelGasto->listarMetodosPagos();
        $mostrarCategoriasGastos = $this->modelGasto->listarCategoriasGastos();
        return [$lista, $pages, $ids, $listaEmpleados, $mostrarTodosMetodosPagos, $mostrarCategoriasGastos];
    }

    public function procesarCargarGasto(
        $categoriaGasto,
        $descripcionGasto,
        $empleadoGasto,
        $metodoPagoGasto,
        $precioTotalGasto,
        $fecha,
        $hora,
        $comentarioGasto
    ) {
        $cargarGasto = $this->modelGasto->cargarGasto(
            $categoriaGasto,
            $descripcionGasto,
            $empleadoGasto,
            $metodoPagoGasto,
            $precioTotalGasto,
            $fecha,
            $hora,
            $comentarioGasto
        );

        if ($cargarGasto) {
            $idGasto = $this->obtenerUltimoGastoID();
            $estado = True;
            $message = "¡Se cargó correctamente el gasto!";
            $mensajeNotificacion = "Se cargó correctamente el gasto de $categoriaGasto con ID $idGasto";
            $tipoNotificacion = 'Información';
        } else {
            $estado = false;
            $message = "¡Hubo un error al cargar el gasto!";
            $mensajeNotificacion = "Hubo un error al cargar el gasto de $categoriaGasto.";
            $tipoNotificacion = 'Error';
        }

        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];

    }

    public function obtenerUltimoGastoID()
    {
        $idGasto = $this->modelGasto->obtenerUltimoGastoID();
        return $idGasto;
    }

    public function mostrarModificarGasto($idGasto)
    {
        $gasto = $this->modelGasto->listarUnGasto($idGasto);
        $listaEmpleados = $this->serviceEmpleados->mostrarTodosEmpleados();
        $mostrarTodosMetodosPagos = $this->modelGasto->listarMetodosPagos();
        $mostrarCategoriasGastos = $this->modelGasto->listarCategoriasGastos();
        return [$gasto, $listaEmpleados, $mostrarTodosMetodosPagos, $mostrarCategoriasGastos];
    }

    public function procesarModificarGasto(
        $idGasto,
        $categoriaGasto,
        $descripcionGasto,
        $empleadoGasto,
        $metodoPagoGasto,
        $precioTotalGasto,
        $fecha,
        $hora,
        $comentarioGasto
    ) {
        $modificarGasto = $this->modelGasto->modificarGasto(
            $idGasto,
            $categoriaGasto,
            $descripcionGasto,
            $empleadoGasto,
            $metodoPagoGasto,
            $precioTotalGasto,
            $fecha,
            $hora,
            $comentarioGasto
        );

        if ($modificarGasto) {

            $estado = True;
            $message = "¡Se modificó correctamente el gasto!";
            $mensajeNotificacion = "Se modificó correctamente el gasto con ID $idGasto";
            $tipoNotificacion = 'Información';
        } else {
            $estado = false;
            $message = "¡Hubo un error al modificar el gasto!";
            $mensajeNotificacion = "Hubo un error al modificar el gasto con ID $idGasto";
            $tipoNotificacion = 'Error';
        }

        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }

    public function cambiarEstadoGasto($id, $estadoActual)
    {
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }

        $cambiarEstadoCategoria = $this->modelGasto->cambiarEstadoGasto($id, $nuevoEstado);
        if ($cambiarEstadoCategoria) {
            $estado = True;
            $message = '¡La notificación se modificó correctamente!';
            $mensajeNotificacion = "La notificación con ID $id se modificó correctamente, ";
            $mensajeNotificacion .= 'de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Información';
        } else {
            $estado = False;
            $message = 'Hubo un error al intentar modificar la notificación.';
            $mensajeNotificacion = "Hubo un error al intentar modificar la notificación con ID $id, ";
            $mensajeNotificacion .= 'de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Error';
        }
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }
}
?>