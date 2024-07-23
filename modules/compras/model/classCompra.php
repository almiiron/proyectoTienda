<?php
class Compras {
    private $conexion;
    public $fecha;
    public $hora;
    public function __construct($conexion) {
        $this->conexion = $conexion;
        
        // Establecer la zona horaria a America/Argentina/Buenos_Aires
        $zonaHoraria = new DateTimeZone('America/Argentina/Buenos_Aires');

        // Crear un objeto DateTime con la zona horaria establecida
        $fechaHora = new DateTime('now', $zonaHoraria);

        // Obtener la fecha y la hora actual
        $this->fecha = $fechaHora->format('Y-m-d'); // Formato de fecha: Año-Mes-Día
        $this->hora = $fechaHora->format('H:i:s');  // Formato de hora: Hora:Minuto:Segundo
    }

    public function listarCompras($start, $size)
    {
        // Construye la consulta SQL con los filtros
        $query = "SELECT 
                    c.id_compra, 
                    c.id_empleado, 
                 
                    c.id_proveedor,
                    prov.nombre as nombreProveedor,

                    c.id_empleado, 
                    e.id_persona as id_persona_empleado, 
                    p2.nombre as nombreEmpleado, 
                    p2.apellido as apellidoEmpleado, 

                    c.id_metodo_pago, 
                    mp.descripcion as metodo_pago, 
                    c.fecha, 
                    c.hora, 
                    c.precio_subtotal, 
                    c.precio_total, 
                    c.estado as estado_compra,

                    dc.id_detalle_compra,
                    dc.id_producto,
                    dc.cantidad_producto,
                    dc.precio_producto,
                    dc.estado as estado_detalle_compra,
                    p.nombre_producto as nombre_producto
                    FROM 
                        compras c
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
                    LIMIT $start, $size
                ";

        $resultado = $this->conexion->ejecutarConsulta($query);

        // Array para almacenar las compras
        $compras = array();

        // Procesa los resultados
        while ($row = mysqli_fetch_assoc($resultado)) {
            $id_compra = $row['id_compra'];

            // Si la venta no está ya en el array, agregarla
            if (!isset($compras[$id_compra])) {
                $compras[$id_compra] = array(
                    'id_compra' => $row['id_compra'],

                    'id_proveedor' => $row['id_proveedor'],
                    'nombreProveedor' => $row['nombreProveedor'],

                    'id_empleado' => $row['id_empleado'],
                    'nombreEmpleado' => $row['nombreEmpleado'],
                    'apellidoEmpleado' => $row['apellidoEmpleado'],

                    'id_metodo_pago' => $row['id_metodo_pago'],
                    'metodo_pago' => $row['metodo_pago'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'precio_subtotal' => $row['precio_subtotal'],
                    'precio_total' => $row['precio_total'],
                   
                    'estado_compra' => $row['estado_compra'],
                    'detalles' => array()
                );
            }

            // Agrega el detalle de la venta
            $compras[$id_compra]['detalles'][] = array(
                'id_detalle_compra' => $row['id_detalle_compra'],
                'id_producto' => $row['id_producto'],
                'nombre_producto' => $row['nombre_producto'],
                'cantidad_producto' => $row['cantidad_producto'],
                'precio_producto' => $row['precio_producto'],
                'estado_detalle_compra' => $row['estado_detalle_compra']
            );
        }

        // Convierte el array de compras en una lista indexada
        return array_values($compras);
    }

    public function listarMetodosPagos()
    {
        $query = "SELECT * FROM metodos_pagos";

        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las clientes
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $clientes
        //luego recorro el array con un foreach

        $metodosPagos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $metodosPagos[] = $row; // Agrega el resultado al array
        }
        return $metodosPagos;
    }

    public function cargarCompra($idProveedor, $idEmpleado, $idMetodoPago, $subTotalCompra, $totalCompra)
    {
        $query = "INSERT INTO compras (id_empleado, id_proveedor, id_metodo_pago, fecha, hora, precio_subtotal, precio_total, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Activo')";
        $tipos = 'iiissss'; 

        // Usar la función ejecutarConsultaPreparada
        $resultado = $this->conexion->ejecutarConsultaPreparada(
            $query,
            $tipos,
            $idEmpleado,
            $idProveedor,
            $idMetodoPago,
            $this->fecha,
            $this->hora,
            $subTotalCompra,
            $totalCompra
        );

        if ($resultado !== false) {
            return true; // Retorna true si la inserción fue exitosa
        } else {
            return false; // Retorna false si hubo un error en la inserción
        }
        // return $resultado;
    }

    public function obtenerUltimaCompraID()
    {

        $query = "SELECT MAX(id_compra) as id_compra FROM compras";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_compra
        $id_compra = $fila['id_compra'];    // Devolver el valor de id_compra
        return $id_compra;

    }

    public function cargarDetalleCompra($idCompra, $productos)
    {
        // Preparar la consulta para insertar los detalles de la compra
        $queryInsertDetalle = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad_producto, precio_producto, estado) VALUES (?, ?, ?, ?, 'Activo')";
        $tiposInsertDetalle = 'iiis';
       
        // Iterar sobre los productos y agregar los detalles de la compra
        foreach ($productos as $producto) {
            // Obtener los valores del producto
            $idProducto = $producto['id'];
            $precioProducto = $producto['precio'];
            $cantidadProducto = $producto['cantidad'];

            // Ejecutar la consulta preparada para insertar el detalle de la compra
            $resultadoInsertDetalle = $this->conexion->ejecutarConsultaPreparada($queryInsertDetalle, $tiposInsertDetalle, $idCompra, $idProducto, $cantidadProducto, $precioProducto);

            // Verificar si la inserción del detalle fue exitosa
            if (!$resultadoInsertDetalle) {
                return false; // Salir del método si hay un error
            }

        }
        // Si todas las inserciones y actualizaciones fueron exitosas, retornar true
        return true;
    }

    public function cambiarEstadoCompra($idCompra, $nuevoEstado)
    {
        $query = "UPDATE
                    compras
                SET
                    estado = ?
                WHERE
                    id_compra = ?";
        $tipos = 'si';
        $sql = $this->conexion->ejecutarConsultaPreparada($query, $tipos, $nuevoEstado, $idCompra);
        if (!$sql) {
            return false;
        }
        return true;
    }
    public function cambiarEstadoDetalleCompra($idCompra, $nuevoEstado)
    {
        $query = "UPDATE
                    detalle_compra
                SET
                    estado = ?
                WHERE
                    id_compra = ?";
        $tipos = 'si';
        $sql = $this->conexion->ejecutarConsultaPreparada($query, $tipos, $nuevoEstado, $idCompra);
        if (!$sql) {
            return false;
        }
        return true;
    }
}
?>