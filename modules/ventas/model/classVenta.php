<?php
class Ventas
{
    private $conexion;
    public $fecha;
    public $hora;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;


        // Establecer la zona horaria a America/Argentina/Buenos_Aires
        $zonaHoraria = new DateTimeZone('America/Argentina/Buenos_Aires');

        // Crear un objeto DateTime con la zona horaria establecida
        $fechaHora = new DateTime('now', $zonaHoraria);

        // Obtener la fecha y la hora actual
        $this->fecha = $fechaHora->format('Y-m-d'); // Formato de fecha: Año-Mes-Día
        $this->hora = $fechaHora->format('H:i:s');  // Formato de hora: Hora:Minuto:Segundo
    }


    public function listarVentas($start, $size)
    {
        // Construye la consulta SQL con los filtros
        $query = "
          SELECT 
    v.id_venta, 
    v.id_cliente, 
    c.id_persona as id_persona_cliente, 
    p1.nombre as nombreCliente, 
    p1.apellido as apellidoCliente, 
    v.id_empleado, 
    e.id_persona as id_persona_empleado, 
    p2.nombre as nombreEmpleado, 
    p2.apellido as apellidoEmpleado, 
    v.id_metodo_pago, 
    mp.descripcion as metodo_pago, 
    v.fecha, 
    v.hora, 
    v.precio_subtotal, 
    v.precio_total, 
    v.estado as estado_venta,
    dv.id_detalle_venta,
    dv.id_producto,
    dv.cantidad_producto,
    dv.precio_producto,
    dv.estado as estado_detalle_venta,
    p.nombre_producto as nombre_producto,
    v.interes
FROM 
    ventas v
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
    productos p ON dv.id_producto = p.id_producto

            LIMIT $start, $size
        ";

        $resultado = $this->conexion->ejecutarConsulta($query);

        // Array para almacenar las ventas
        $ventas = array();

        // Procesa los resultados
        while ($row = mysqli_fetch_assoc($resultado)) {
            $id_venta = $row['id_venta'];

            // Si la venta no está ya en el array, agregarla
            if (!isset($ventas[$id_venta])) {
                $ventas[$id_venta] = array(
                    'id_venta' => $row['id_venta'],
                    'id_cliente' => $row['id_cliente'],
                    'nombreCliente' => $row['nombreCliente'],
                    'apellidoCliente' => $row['apellidoCliente'],
                    'id_empleado' => $row['id_empleado'],
                    'nombreEmpleado' => $row['nombreEmpleado'],
                    'apellidoEmpleado' => $row['apellidoEmpleado'],
                    'id_metodo_pago' => $row['id_metodo_pago'],
                    'metodo_pago' => $row['metodo_pago'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'precio_subtotal' => $row['precio_subtotal'],
                    'precio_total' => $row['precio_total'],
                    'interes' => $row['interes'],
                    'estado_venta' => $row['estado_venta'],
                    'detalles' => array()
                );
            }

            // Agrega el detalle de la venta
            $ventas[$id_venta]['detalles'][] = array(
                'id_detalle_venta' => $row['id_detalle_venta'],
                'id_producto' => $row['id_producto'],
                'nombre_producto' => $row['nombre_producto'],
                'cantidad_producto' => $row['cantidad_producto'],
                'precio_producto' => $row['precio_producto'],
                'estado_detalle_venta' => $row['estado_detalle_venta']
            );
        }

        // Convierte el array de ventas en una lista indexada
        return array_values($ventas);
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


    public function cargarVenta($idCliente, $idEmpleado, $idMetodoPago, $subTotalVenta, $totalVenta, $interes_venta)
    {
        $query = "INSERT INTO ventas (id_cliente, id_empleado, id_metodo_pago, fecha, hora, precio_subtotal, precio_total, interes, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Activo')";
        $tipos = 'iiissiis'; // i para enteros (id_cliente, id_empleado, id_metodo_pago), d para dobles (sub_total_venta, total_venta)

        // Usar la función ejecutarConsultaPreparada
        $resultado = $this->conexion->ejecutarConsultaPreparada(
            $query,
            $tipos,
            $idCliente,
            $idEmpleado,
            $idMetodoPago,
            $this->fecha,
            $this->hora,
            $subTotalVenta,
            $totalVenta,
            $interes_venta
        );

        if ($resultado !== false) {
            return true; // Retorna true si la inserción fue exitosa
        } else {
            return false; // Retorna false si hubo un error en la inserción
        }
        // return $resultado;
    }

    public function obtenerUltimaVentaID()
    {

        $query = "SELECT MAX(id_venta) as id_venta FROM ventas";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_venta
        $id_venta = $fila['id_venta'];    // Devolver el valor de id_venta
        return $id_venta;

    }

    public function cargarDetalleVenta($idVenta, $productos)
    {
        // Preparar la consulta para insertar los detalles de la venta
        $queryInsertDetalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad_producto, precio_producto, estado) VALUES (?, ?, ?, ?, 'Activo')";
        $tiposInsertDetalle = 'iiis';

        // Iterar sobre los productos y agregar los detalles de la venta
        foreach ($productos as $producto) {
            // Obtener los valores del producto
            $idProducto = $producto['id'];
            $precioProducto = $producto['precio'];
            $cantidadProducto = $producto['cantidad'];

            // Ejecutar la consulta preparada para insertar el detalle de la venta
            $resultadoInsertDetalle = $this->conexion->ejecutarConsultaPreparada($queryInsertDetalle, $tiposInsertDetalle, $idVenta, $idProducto, $cantidadProducto, $precioProducto);

            // Verificar si la inserción del detalle fue exitosa
            if (!$resultadoInsertDetalle) {
                return false; // Salir del método si hay un error
            }

        }
        // Si todas las inserciones y actualizaciones fueron exitosas, retornar true
        return true;
    }



    public function prepararFiltrosVenta($filtro)
    {
        $where_clause = "  WHERE 
        c.id_cliente LIKE '%$filtro%' OR 
        p1.nombre LIKE '%$filtro%' OR 
        p1.apellido LIKE '%$filtro%' OR 
        p2.nombre LIKE '%$filtro%' OR 
        p2.apellido LIKE '%$filtro%' OR 
        mp.descripcion LIKE '%$filtro%' OR 
        v.fecha LIKE '%$filtro%' OR 
        v.estado LIKE '%$filtro%' OR 
        dv.id_producto LIKE '%$filtro%' OR 
        dv.cantidad_producto LIKE '%$filtro%' OR 
        dv.precio_producto LIKE '%$filtro%' OR
        v.id_venta IN (
        SELECT DISTINCT id_venta 
        FROM detalle_venta 
        WHERE id_producto IN (
            SELECT id_producto 
            FROM productos 
            WHERE nombre_producto LIKE '%$filtro%'
        )
    )
    OR 
    p.nombre_producto LIKE '%$filtro%' ";

        return $where_clause;
    }
    public function listaFiltradaVentas($where_clause, $start, $size)
    {
        // Construye la consulta SQL con los filtros
        $query = "
    SELECT 
        v.id_venta, 
        v.id_cliente, 
        c.id_persona as id_persona_cliente, 
        p1.nombre as nombreCliente, 
        p1.apellido as apellidoCliente, 
        v.id_empleado, 
        e.id_persona as id_persona_empleado, 
        p2.nombre as nombreEmpleado, 
        p2.apellido as apellidoEmpleado, 
        v.id_metodo_pago, 
        mp.descripcion as metodo_pago, 
        v.fecha, 
        v.hora, 
        v.precio_subtotal, 
        v.precio_total, 
        v.estado as estado_venta,
        dv.id_detalle_venta,
        dv.id_producto,
        dv.cantidad_producto,
        dv.precio_producto,
        dv.estado as estado_detalle_venta,
        p.nombre_producto as nombre_producto
    FROM 
        ventas v
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
        productos p ON dv.id_producto = p.id_producto 
   $where_clause 
    LIMIT $start, $size
";
        $resultado = $this->conexion->ejecutarConsulta($query);

        // Array para almacenar las ventas
        $ventas = array();

        // Procesa los resultados
        while ($row = mysqli_fetch_assoc($resultado)) {
            $id_venta = $row['id_venta'];

            // Si la venta no está ya en el array, agregarla
            if (!isset($ventas[$id_venta])) {
                $ventas[$id_venta] = array(
                    'id_venta' => $row['id_venta'],
                    'id_cliente' => $row['id_cliente'],
                    'nombreCliente' => $row['nombreCliente'],
                    'apellidoCliente' => $row['apellidoCliente'],
                    'id_empleado' => $row['id_empleado'],
                    'nombreEmpleado' => $row['nombreEmpleado'],
                    'apellidoEmpleado' => $row['apellidoEmpleado'],
                    'id_metodo_pago' => $row['id_metodo_pago'],
                    'metodo_pago' => $row['metodo_pago'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'precio_subtotal' => $row['precio_subtotal'],
                    'precio_total' => $row['precio_total'],
                    'estado_venta' => $row['estado_venta'],
                    'detalles' => array()
                );
            }

            // Agrega el detalle de la venta
            $ventas[$id_venta]['detalles'][] = array(
                'id_detalle_venta' => $row['id_detalle_venta'],
                'id_producto' => $row['id_producto'],
                'nombre_producto' => $row['nombre_producto'],
                'cantidad_producto' => $row['cantidad_producto'],
                'precio_producto' => $row['precio_producto'],
                'estado_detalle_venta' => $row['estado_detalle_venta']
            );
        }

        // Convierte el array de ventas en una lista indexada
        return array_values($ventas);
    }

    public function ultimoIdVenta()
    {
        $query = "SELECT MAX(id_venta) as id_contacto FROM contactos";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_contacto
        $id_contacto = $fila['id_contacto'];    // Devolver el valor de id_contacto
        return $id_contacto;
    }

    public function cambiarEstadoVenta($idVenta, $nuevoEstado)
    {
        $query = "UPDATE
                    ventas
                SET
                    estado = ?
                WHERE
                    id_venta = ?";
        $tipos = 'si';
        $sql = $this->conexion->ejecutarConsultaPreparada($query, $tipos, $nuevoEstado, $idVenta);
        if (!$sql) {
            return false;
        }
        return true;
    }
    public function cambiarEstadoDetalleVenta($idVenta, $nuevoEstado)
    {
        $query = "UPDATE
                    detalle_venta
                SET
                    estado = ?
                WHERE
                    id_venta = ?";
        $tipos = 'si';
        $sql = $this->conexion->ejecutarConsultaPreparada($query, $tipos, $nuevoEstado, $idVenta);
        if (!$sql) {
            return false;
        }
        return true;
    }
}
?>