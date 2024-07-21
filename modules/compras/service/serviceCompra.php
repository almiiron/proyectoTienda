<?php
require_once './modules/compras/model/classCompra.php';
require_once './modules/notificaciones/service/serviceNotificaciones.php';
class ServiceCompra
{
    private $modeloCompra;
    private $paginationController;
    private $serviceEmpleado;
    private $serviceProveedor;
    private $serviceProducto;
    private $serviceNotificaciones;

    public function __construct($conexion)
    {
        $this->modeloCompra = new Compras($conexion);
        $this->paginationController = new ControllerPagination($conexion, 30);
        $this->serviceEmpleado = new ServiceEmpleado($conexion);
        $this->serviceProveedor = new ServiceProveedor($conexion);
        $this->serviceProducto = new ServiceProducto($conexion);
        $this->serviceNotificaciones = new ServiceNotificaciones($conexion);

    }

    public function listarCompras($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = " 
                    JOIN 
                        empleados e ON c.id_empleado = e.id_empleado
                    JOIN 
                        personas p2 ON e.id_persona = p2.id_persona
                    JOIN
                        proveedores prov ON c.id_proveedor = prov.id_proveedor
                    JOIN 
                        metodos_pagos mp ON c.id_metodo_pago = mp.id_medio_pago
                    JOIN 
                        detalle_compra dc ON c.id_compra = dc.id_compra
                    JOIN 
                        productos p ON dc.id_producto = p.id_producto
                    ";

        $totalRows = $this->paginationController->getTotalRows('compras c' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modeloCompra->listarCompras($start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_compra']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function mostrarCargarCompra()
    {
        $mostrarTodosProveedores = $this->serviceProveedor->mostrarProveedores();
        $mostrarTodosEmpleados = $this->serviceEmpleado->mostrarTodosEmpleados();
        $mostrarTodosProductos = $this->serviceProducto->mostrarTodosProductosCompra();
        $mostrarTodosMetodosPagos = $this->modeloCompra->listarMetodosPagos();
        return [$mostrarTodosProveedores, $mostrarTodosEmpleados, $mostrarTodosProductos, $mostrarTodosMetodosPagos];
    }

    public function procesarCargarCompra($idProveedor, $idEmpleado, $productos, $subTotalCompra, $totalCompra, $idMetodoPago)
    {
       
        $cargarCompra = $this->modeloCompra->cargarCompra($idProveedor, $idEmpleado, $idMetodoPago, $subTotalCompra, $totalCompra);

        if ($cargarCompra == False) {
            $estado = False;
            $message = '¡Hubo un error al cargar la compra!';
            $mensajeNotificacion = '¡Hubo un error al cargar la compra!';
            $tipoNotificacion = 'Error';
            return ['success' => $estado, 'message' => $message];
        }

        $idCompra = $this->obtenerUltimaCompraID();
        $cargarDetalleCompra = $this->modeloCompra->cargarDetalleCompra($idCompra, $productos);

        if ($cargarDetalleCompra == False) {
            $estado = False;
            $message = '¡Hubo un error al cargar detalle compra!';
            $mensajeNotificacion = '¡Hubo un error al cargar detalle compra!';
            $tipoNotificacion = 'Error';
            return ['success' => $estado, 'message' => $message];
        }

        $accionStock = 'sumar';
        $actualizarStock = $this->serviceProducto->actualizarStock($productos, $accionStock);
        if ($actualizarStock == False) {
            $estado = False;
            $message = '¡Hubo un error al actualizar stock!';
            return ['success' => $estado, 'message' => $message];
        }

        $estado = True;
        $message = '¡Se cargó correctamente la compra!';
        $mensajeNotificacion = 'Se cargó correctamente la compra con ID ' . $idCompra;
        $tipoNotificacion = 'Éxito';
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }

    public function obtenerUltimaCompraID(){
        $idCompra = $this->modeloCompra->obtenerUltimaCompraID();
        return $idCompra;
    }
}
?>