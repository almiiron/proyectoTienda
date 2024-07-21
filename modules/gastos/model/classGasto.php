<?php
class ClassGasto
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function listarGastos($start, $size)
    {
        // aca hago una consulta para traer todas mis gastos de la bd
        $query = "SELECT
                    g.id_gasto, 

                    g.id_empleado, 
                    e.id_persona as id_persona_empleado, 
                    p2.nombre as nombreEmpleado, 
                    p2.apellido as apellidoEmpleado,

                    g.id_metodo_pago,  
                    mp.descripcion as metodo_pago, 
                    
                    g.id_categoria_gasto,
                    cg.nombre_categoria_gasto as nombre_categoria_gasto,
                    g.descripcion,
                    g.fecha,
                    g.hora,
                    g.precio_total,
                    g.comentario,
                    g.estado

                    FROM gastos g
                    JOIN 
                        empleados e ON g.id_empleado = e.id_empleado
                    JOIN 
                        personas p2 ON e.id_persona = p2.id_persona
                    JOIN 
                        metodos_pagos mp ON g.id_metodo_pago = mp.id_medio_pago  
                    JOIN
                        categorias_gastos cg ON g.id_categoria_gasto = cg.id_categoria_gasto 
                    LIMIT " . $start . ',' . $size;

        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar los gastos
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $gastos
        //luego recorro el array con un foreach

        $gastos = array(); // Array para almacenar los gastos
        while ($row = mysqli_fetch_assoc($resultado)) {
            $gastos[] = $row; // Agrega el resultado al array
        }
        return $gastos;
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

    public function cargarGasto(
        $categoriaGasto,
        $descripcionGasto,
        $empleadoGasto,
        $metodoPagoGasto,
        $precioTotalGasto,
        $fecha,
        $hora,
        $comentarioGasto
    ) {
        $query = "INSERT INTO gastos (id_empleado, id_metodo_pago, id_categoria_gasto, descripcion, fecha, hora, precio_total, comentario, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Activo')";
        $tipos = 'iiisssss';

        // Usar la función ejecutarConsultaPreparada
        $resultado = $this->conexion->ejecutarConsultaPreparada(
            $query,
            $tipos,
            $empleadoGasto,
            $metodoPagoGasto,
            $categoriaGasto,
            $descripcionGasto,
            $fecha,
            $hora,
            $precioTotalGasto,
            $comentarioGasto
        );

        if ($resultado !== false) {
            return true; // Retorna true si la inserción fue exitosa
        } else {
            return false; // Retorna false si hubo un error en la inserción
        }
        // return $resultado;
    }

    public function obtenerUltimoGastoID()
    {

        $query = "SELECT MAX(id_gasto) as id_gasto FROM gastos";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_gasto
        $id_gasto = $fila['id_gasto'];    // Devolver el valor de id_gasto
        return $id_gasto;

    }

    public function listarCategoriasGastos()
    {
        $query = "SELECT * FROM categorias_gastos";

        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las clientes
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $clientes
        //luego recorro el array con un foreach

        $categoriaGasto = array(); // Array para almacenar las 
        while ($row = mysqli_fetch_assoc($resultado)) {
            $categoriaGasto[] = $row; // Agrega el resultado al array
        }
        return $categoriaGasto;
    }

    public function listarUnGasto($idGasto)
    {
        $query = "SELECT
                    g.id_gasto, 

                    g.id_empleado, 
                    e.id_persona as id_persona_empleado, 
                    p2.nombre as nombreEmpleado, 
                    p2.apellido as apellidoEmpleado,

                    g.id_metodo_pago,  
                    mp.descripcion as metodo_pago, 
                    
                    g.id_categoria_gasto,
                    cg.nombre_categoria_gasto as nombre_categoria_gasto,
                    g.descripcion,
                    g.fecha,
                    g.hora,
                    g.precio_total,
                    g.comentario,
                    g.estado

                    FROM gastos g
                    JOIN 
                        empleados e ON g.id_empleado = e.id_empleado
                    JOIN 
                        personas p2 ON e.id_persona = p2.id_persona
                    JOIN 
                        metodos_pagos mp ON g.id_metodo_pago = mp.id_medio_pago  
                    JOIN
                        categorias_gastos cg ON g.id_categoria_gasto = cg.id_categoria_gasto
                    WHERE g.id_gasto = $idGasto";

        $resultado = $this->conexion->ejecutarConsulta($query);
        $gasto = $resultado->fetch_assoc();
        return $gasto;
    }

    public function modificarGasto(
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
        $query = "UPDATE
                    gastos
                SET
                    id_empleado = ?,
                    id_metodo_pago = ?,
                    id_categoria_gasto = ?,
                    descripcion = ?,
                    fecha = ?,
                    hora = ?,
                    precio_total = ?,
                    comentario = ?
                WHERE id_gasto = ?";
        $tipos = 'iiisssssi';

        // Usar la función ejecutarConsultaPreparada
        $resultado = $this->conexion->ejecutarConsultaPreparada(
            $query,
            $tipos,
            $empleadoGasto,
            $metodoPagoGasto,
            $categoriaGasto,
            $descripcionGasto,
            $fecha,
            $hora,
            $precioTotalGasto,
            $comentarioGasto,
            $idGasto
        );

        if ($resultado !== false) {
            return true; // Retorna true si la inserción fue exitosa
        } else {
            return false; // Retorna false si hubo un error en la inserción
        }
        // return $resultado;
    }

    public function cambiarEstadoGasto($id, $nuevoEstado)
    {
        $query = "UPDATE gastos SET estado='$nuevoEstado' WHERE id_gasto = ?";
        $tipos = "i";

        $resultado = $this->conexion->ejecutarConsultaPreparada(
            $query,
            $tipos,
            $id
        );
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
}
?>