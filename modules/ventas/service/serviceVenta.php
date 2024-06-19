<?php
require_once ('./modules/ventas/model/classVenta.php');
require_once ('./modules/clientes/service/serviceCliente.php');
class ServiceVenta
{
    private $modeloVenta;
    private $paginationController;
    private $serviceEmpleado;
    private $serviceCliente;
    private $serviceProducto;
    public function __construct($conexion)
    {
        $this->modeloVenta = new Ventas($conexion);
        $this->paginationController = new ControllerPagination($conexion, 30);
        $this->serviceEmpleado = new ServiceEmpleado($conexion);
        $this->serviceCliente = new ServiceCliente($conexion);
        $this->serviceProducto = new ServiceProducto($conexion);
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

    public function procesarCargarVenta($idCliente, $idEmpleado, $productos, $subTotalVenta, $totalVenta, $idMetodoPago)
    {

        $cargarVenta = $this->modeloVenta->cargarVenta($idCliente, $idEmpleado, $idMetodoPago, $subTotalVenta, $totalVenta);

        if ($cargarVenta == False) {
            $estado = False;
            $message = '¡Hubo un error al cargar la venta!';
            return ['success' => $estado, 'message' => $message];
        }

        $idVenta = $this->modeloVenta->obtenerUltimaVentaID();
        $cargarDetalleVenta = $this->modeloVenta->cargarDetalleVenta($idVenta, $productos);

        if ($cargarDetalleVenta == False) {
            $estado = False;
            $message = '¡Hubo un error al cargar detalle venta!';
            return ['success' => $estado, 'message' => $message];
        }

        $estado = True;
        $message = '¡La venta fue cargada correctamente!';
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
}
?>