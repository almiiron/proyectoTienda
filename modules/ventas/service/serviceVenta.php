<?php
require_once './modules/ventas/model/classVenta.php';
require_once './modules/clientes/service/serviceCliente.php';
require_once './modules/notificaciones/service/serviceNotificaciones.php';

class ServiceVenta
{
    private $modeloVenta;
    private $paginationController;
    private $serviceEmpleado;
    private $serviceCliente;
    private $serviceProducto;
    private $serviceNotificaciones;

    public function __construct($conexion)
    {
        $this->modeloVenta = new Ventas($conexion);
        $this->paginationController = new ControllerPagination($conexion, 30);
        $this->serviceEmpleado = new ServiceEmpleado($conexion);
        $this->serviceCliente = new ServiceCliente($conexion);
        $this->serviceProducto = new ServiceProducto($conexion);
        $this->serviceNotificaciones = new ServiceNotificaciones($conexion);

    }


    public function listarVentas($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = " 
            JOIN 
                clientes c ON v.id_cliente = c.id_cliente
            JOIN 
                personas p1 ON c.id_persona = p1.id_persona
            JOIN 
                empleados e ON v.id_empleado = e.id_empleado
            JOIN 
                personas p2 ON e.id_persona = p2.id_persona
            JOIN 
                metodos_pagos mp ON v.id_metodo_pago = mp.id_medio_pago
            JOIN 
                detalle_venta dv ON v.id_venta = dv.id_venta ";

        $totalRows = $this->paginationController->getTotalRows('ventas v' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modeloVenta->listarVentas($start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_venta']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function mostrarCargarVenta()
    {
        $mostrarTodosClientes = $this->serviceCliente->mostrarTodosClientes();
        $mostrarTodosEmpleados = $this->serviceEmpleado->mostrarTodosEmpleados();
        $mostrarTodosProductos = $this->serviceProducto->mostrarTodosProductosVenta();
        $mostrarTodosMetodosPagos = $this->modeloVenta->listarMetodosPagos();
        return [$mostrarTodosClientes, $mostrarTodosEmpleados, $mostrarTodosProductos, $mostrarTodosMetodosPagos];
    }

    public function procesarCargarVenta($idCliente, $idEmpleado, $productos, $subTotalVenta, $totalVenta, $idMetodoPago, $interesVenta)
    {
        switch ($interesVenta) {
            case '0.00':
                $interes_venta = '0%';
                break;
            case '0.05':
                $interes_venta = '5%';
                break;
            case '0.10':
                $interes_venta = '10%';
                break;
            case '0.15':
                $interes_venta = '15%';
                break;
            case '0.20':
                $interes_venta = '20%';
                break;
            case '0.25':
                $interes_venta = '25%';
                break;
            default:
                $interes_venta = '';
                break;
        }
        $cargarVenta = $this->modeloVenta->cargarVenta($idCliente, $idEmpleado, $idMetodoPago, $subTotalVenta, $totalVenta, $interes_venta);

        if ($cargarVenta == False) {
            $estado = False;
            $message = '¡Hubo un error al cargar la venta!';
            $mensajeNotificacion = '¡Hubo un error al cargar la venta!';
            $tipoNotificacion = 'Error';
            return ['success' => $estado, 'message' => $message];
        }

        $idVenta = $this->obtenerUltimaVentaID();
        $cargarDetalleVenta = $this->modeloVenta->cargarDetalleVenta($idVenta, $productos);

        if ($cargarDetalleVenta == False) {
            $estado = False;
            $message = '¡Hubo un error al cargar detalle venta!';
            $mensajeNotificacion = '¡Hubo un error al cargar detalle venta!';
            $tipoNotificacion = 'Error';
            return ['success' => $estado, 'message' => $message];
        }

        $accionStock = 'restar';
        $actualizarStock = $this->serviceProducto->actualizarStock($productos, $accionStock);
        if ($actualizarStock == False) {
            $estado = False;
            $message = '¡Hubo un error al actualizar stock!';
            return ['success' => $estado, 'message' => $message];
        }

        $estado = True;
        $message = '¡Se cargó correctamente la venta!';
        $mensajeNotificacion = 'Se cargó correctamente la venta con ID ' . $idVenta;
        $tipoNotificacion = 'Éxito';
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }


    public function filtrarListarVentas($filtro, $numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;
        $innerJoin = " 
        JOIN 
            clientes c ON v.id_cliente = c.id_cliente
        JOIN 
            personas p1 ON c.id_persona = p1.id_persona
        JOIN 
            empleados e ON v.id_empleado = e.id_empleado
        JOIN 
            personas p2 ON e.id_persona = p2.id_persona
        JOIN 
            metodos_pagos mp ON v.id_metodo_pago = mp.id_medio_pago
        JOIN 
            detalle_venta dv ON v.id_venta = dv.id_venta
        JOIN
            productos p ON dv.id_producto = p.id_producto ";
        $where_clause = $this->modeloVenta->prepararFiltrosVenta($filtro);
        $where_clause_Pagination = $innerJoin . ' ' . $where_clause;
        $totalRows = $this->paginationController->getTotalRows('ventas v' . $where_clause_Pagination); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modeloVenta->listaFiltradaVentas($where_clause, $start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_venta']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function obtenerUltimaVentaID()
    {
        $idVenta = $this->modeloVenta->obtenerUltimaVentaID();
        return $idVenta;
    }

    public function procesarCambiarEstadoVenta($idVenta, $estadoActual)
    {
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }
        $cambiarEstadoVenta = $this->modeloVenta->cambiarEstadoVenta($idVenta, $nuevoEstado);
        $cambiarEstadoDetalleVenta = $this->modeloVenta->cambiarEstadoDetalleVenta($idVenta, $nuevoEstado);
        if ($cambiarEstadoVenta && $cambiarEstadoDetalleVenta) {
            $estado = True;
            $message = "¡Se modificó correctamente la venta!";
            $mensajeNotificacion = 'Se modificó correctamente la venta de ID ' . $idVenta;
            $mensajeNotificacion .= ', de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Información';
        } else {
            $estado = False;
            $message = "¡Hubo un error al modificar la venta!";
            $mensajeNotificacion = '¡Hubo un error al modificar la venta de ID ' . $idVenta;
            $mensajeNotificacion .= ', de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Error';
        }
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }
}
?>