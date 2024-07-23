<?php
class ClassPanelControl
{
    private $conexion;

    private $fecha;
    private $hora;
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

    public function productosMasVendidos()
    {
        $query = "SELECT p.nombre_producto, 
                SUM(dv.cantidad_producto * dv.precio_producto) AS ingresos
                FROM detalle_venta dv
                INNER JOIN productos p ON dv.id_producto = p.id_producto
                WHERE dv.estado = 'Activo' 
                GROUP BY p.nombre_producto
                ORDER BY ingresos DESC
                LIMIT 10;
                ";

        $result = $this->conexion->ejecutarConsulta($query);

        $productos = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row["nombre_producto"];
                $ingresos[] = $row["ingresos"];
            }
        }

        // Crea un array asociativo con los datos
        $data = array(
            "productos" => $productos,
            "ingresos" => $ingresos
        );
        return $data;
    }

    public function categoriasConMasVentas()
    {
        $query = "SELECT c.nombre_categoria, 
                SUM(dv.cantidad_producto * dv.precio_producto) ingresos
                FROM detalle_venta dv
                INNER JOIN productos p ON dv.id_producto = p.id_producto
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE dv.estado = 'Activo' 
                GROUP BY c.nombre_categoria
                ORDER BY ingresos DESC
                LIMIT 10";

        $result = $this->conexion->ejecutarConsulta($query);

        $categorias = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row["nombre_categoria"];
                $ingresos[] = $row["ingresos"];

            }
        }

        // Crea un array asociativo con los datos
        $data = array(
            "categorias" => $categorias,
            "ingresos" => $ingresos
        );

        // Convertir a JSON y devolver
        return $data;
    }

    public function ingresosHoy()
    {

        $sql = "SELECT SUM(precio_total) AS ingresosHoy FROM ventas WHERE fecha = '$this->fecha' AND estado = 'Activo';";

        $query = $this->conexion->ejecutarConsulta($sql);
        $row = $query->fetch_assoc();
        $dato = (isset($row['ingresosHoy'])) ? $row['ingresosHoy'] : 0;
        $resultado = array(
            "titulo" => 'Ingresos hoy',
            "dato" => $dato
        );
        return $resultado;
    }

    public function cantidadProductosVendidosHoy()
    {

        $sql = "SELECT SUM(dv.cantidad_producto) AS cantidadProductosVendidos
                FROM ventas v
                INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
                WHERE v.fecha = '$this->fecha' AND v.estado = 'Activo';
                ";

        $query = $this->conexion->ejecutarConsulta($sql);
        $row = $query->fetch_assoc();
        $dato = (isset($row['cantidadProductosVendidos'])) ? $row['cantidadProductosVendidos'] : 0;
        $resultado = array(
            "titulo" => 'Productos vendidos hoy',
            "dato" => $dato
        );
        return $resultado;
    }
    public function cantidadClientesHoy()
    {

        $sql = "SELECT COUNT(DISTINCT id_cliente) AS cantidadClientes
                FROM ventas
                WHERE fecha = '$this->fecha' AND estado = 'Activo';
                ";

        $query = $this->conexion->ejecutarConsulta($sql);
        $row = $query->fetch_assoc();
        $dato = (isset($row['cantidadClientes'])) ? $row['cantidadClientes'] : 0;
        $resultado = array(
            "titulo" => 'Cantidad clientes hoy',
            "dato" => $dato
        );
        return $resultado;
    }

    public function promedioVentasHoy()
    {

        $sql = "SELECT FORMAT(AVG(precio_total), 2) AS promedioVentasHoy FROM ventas WHERE fecha = '$this->fecha' AND estado = 'Activo'; ";

        $query = $this->conexion->ejecutarConsulta($sql);
        $row = $query->fetch_assoc();
        $dato = (isset($row['promedioVentasHoy'])) ? $row['promedioVentasHoy'] : 0;
        $resultado = array(
            "titulo" => 'Promedio ventas hoy',
            "dato" => $dato
        );
        return $resultado;
    }

    public function totalVentasCadaMesDelAnio()
    {
        // Consulta SQL para obtener el total de ventas de cada mes del año actual
        $sql = "SELECT
                meses.mes_numero AS mes,
                COALESCE(SUM(v.precio_total), 0) AS total_ventas
            FROM (
                -- Generar una serie de números del 1 al 12 (representando los meses)
                SELECT 1 AS mes_numero UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL
                SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL
                SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
            ) meses
            LEFT JOIN ventas v ON MONTH(v.fecha) = meses.mes_numero AND YEAR(v.fecha) = YEAR(CURDATE())  AND v.estado = 'Activo'
            GROUP BY meses.mes_numero
            ORDER BY meses.mes_numero;";


        $query = $this->conexion->ejecutarConsulta($sql);

        // // Arrays para almacenar los ingresos
        $ingresos = array();

        // // Recorrer los resultados de la consulta
        while ($row = $query->fetch_assoc()) {
            $ingresos[] = $row['total_ventas']; //agrego cada ingreso de la consulta a un array
        }

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        // Retornar un array con los nombres de los meses y los ingresos
        $data = array(
            "meses" => $meses,
            "ingresos" => $ingresos
        );
        return $data;
    }

    public function ingresosUltimosSieteDias()
    {
        $fechaActual = $this->fecha; //obtengo fecha actual
        $fechaHace7Dias = date('Y-m-d', strtotime('-7 days', strtotime($fechaActual))); //obtengo fecha hace 7 dias

        $query = "SELECT fecha, 
                    SUM(precio_total) AS ingresos
                    FROM ventas
                    WHERE fecha BETWEEN '$fechaHace7Dias' AND '$fechaActual' AND estado = 'Activo'
                    GROUP BY fecha
                    ORDER BY fecha";
        $sql = $this->conexion->ejecutarConsulta($query);
        $fechas = array();
        $ingresos = array();

        while ($row = $sql->fetch_assoc()) {
            $fechas[] = $row["fecha"];
            $ingresos[] = $row["ingresos"];
        }

        $data = array(
            "fechas" => $fechas,
            "ingresos" => $ingresos
        );
        // var_dump($data);
        return $data;
    }

    public function ingresosUltimasCuatroSemanas()
    {
        // Calcular la fecha actual
        $fechaActual = $this->fecha;

        // Calcular la fecha de hace 8 semanas
        $fechaHace8Semanas = date('Y-m-d', strtotime('-8 weeks', strtotime($fechaActual)));

        // Consulta SQL para obtener los ingresos totales durante las últimas 8 semanas
        $query = "SELECT WEEK(fecha) AS semana, 
                 MIN(fecha) AS fecha_inicio_semana, 
                 MAX(fecha) AS fecha_fin_semana, 
                 SUM(precio_total) AS ingresos
          FROM ventas
          WHERE fecha BETWEEN '$fechaHace8Semanas' AND '$fechaActual' AND estado = 'Activo'
          GROUP BY semana
          ORDER BY semana";

        $result = $this->conexion->ejecutarConsulta($query);

        $semanas = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fechaInicio = date('d-m-Y', strtotime($row['fecha_inicio_semana']));
                $fechaFin = date('d-m-Y', strtotime($row['fecha_fin_semana']));
                $semana = "Semana $fechaInicio - $fechaFin";
                $semanas[] = $semana;
                $ingresos[] = (float) $row['ingresos'];
            }
        }

        // Crea un array asociativo con los datos
        $data = array(
            "semanas" => $semanas,
            "ingresos" => $ingresos
        );
        return $data;
    }

    public function ingresosDiariosPorMes()
    {
        // Obten el mes seleccionado desde la solicitud POST
        $mesSeleccionado = date('n'); // Usar el mes actual como valor predeterminado

        // Calcular la fecha de inicio del mes seleccionado
        $fechaInicioMes = date('Y-m-d', mktime(0, 0, 0, $mesSeleccionado, 1, date('Y')));

        // Calcular la fecha de fin del mes seleccionado
        $fechaFinMes = date('Y-m-d', mktime(0, 0, 0, $mesSeleccionado + 1, 0, date('Y')));

        // Crear un arreglo con todos los días del mes
        $diasDelMes = range(1, date('t', strtotime($fechaInicioMes)));

        // Formatear los días como strings con dos dígitos
        $diasDelMes = array_map(function ($dia) {
            return str_pad($dia, 2, '0', STR_PAD_LEFT);
        }, $diasDelMes);

        // Consulta SQL para obtener los ingresos diarios del mes seleccionado
        $query = "SELECT DATE_FORMAT(fecha, '%d') AS dia, SUM(precio_total) AS ingresos
          FROM ventas
          WHERE fecha BETWEEN '$fechaInicioMes' AND '$fechaFinMes' AND estado = 'Activo'
          GROUP BY dia
          ORDER BY fecha";

        $result = $this->conexion->ejecutarConsulta($query);

        $dias = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dia = str_pad($row['dia'], 2, '0', STR_PAD_LEFT);
                $dias[] = $dia;
                $ingresos[] = (float) $row['ingresos'];
            }
        }

        // Llenar los ingresos en los días faltantes
        foreach ($diasDelMes as $diaDelMes) {
            if (!in_array($diaDelMes, $dias)) {
                $dias[] = $diaDelMes;
                $ingresos[] = 0.00; // Agregar ingresos cero con el formato correcto
            }
        }

        // Ordenar los datos por día
        array_multisort($dias, $ingresos);

        // Crea un array asociativo con los datos
        $data = array(
            "dias" => $dias,
            "ingresos" => $ingresos
        );

        return $data;
    }

    public function ingresosTotalHistorico()
    {
        $query = "SELECT SUM(precio_total) AS ingresos_historico FROM ventas WHERE estado = 'Activo'";
        $sql = $this->conexion->ejecutarConsulta($query);
        $row = $sql->fetch_assoc();
        $dato = (isset($row['ingresos_historico'])) ? $row['ingresos_historico'] : 0;

        $resultado = array(
            "titulo" => 'Ingresos totales histórico',
            "dato" => $dato
        );
        return $resultado;
    }

    public function comprasTotalesHistorico()
    {
        $query = "SELECT SUM(precio_total) AS compras_historico FROM compras WHERE estado = 'Activo'";
        $sql = $this->conexion->ejecutarConsulta($query);
        $row = $sql->fetch_assoc();
        $dato = (isset($row['compras_historico'])) ? $row['compras_historico'] : 0;

        $resultado = array(
            "titulo" => 'Compras totales histórico',
            "dato" => $dato
        );
        return $resultado;
    }

    public function gastosTotalesHistorico()
    {
        $query = "SELECT SUM(precio_total) AS gastos_historico FROM gastos WHERE estado = 'Activo'";
        $sql = $this->conexion->ejecutarConsulta($query);
        $row = $sql->fetch_assoc();
        $dato = (isset($row['gastos_historico'])) ? $row['gastos_historico'] : 0;

        $resultado = array(
            "titulo" => 'Gastos totales histórico',
            "dato" => $dato
        );
        return $resultado;
    }

    public function gananciaRealHistorico()
    {
        $ventasHistorico = $this->ingresosTotalHistorico();
        $comprasHistorico = $this->comprasTotalesHistorico();
        $gastosHistorico = $this->gastosTotalesHistorico();
        $datoVentasHistorico = $ventasHistorico['dato'];
        $datoComprasHistorico = $comprasHistorico['dato'];
        $datoGastosHistorico = $gastosHistorico['dato'];

        $gananciaReal = $datoVentasHistorico - ($datoComprasHistorico + $datoGastosHistorico);
        $dato = $gananciaReal;
        $resultado = array(
            "titulo" => 'Ganancia real histórico',
            "dato" => $dato
        );
        return $resultado;
    }

    public function totalComprasCadaMesDelAnio()
    {
        // Consulta SQL para obtener el total de ventas de cada mes del año actual
        $sql = "SELECT
                meses.mes_numero AS mes,
                COALESCE(SUM(c.precio_total), 0) AS total_compras
            FROM (
                -- Generar una serie de números del 1 al 12 (representando los meses)
                SELECT 1 AS mes_numero UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL
                SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL
                SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
            ) meses
            LEFT JOIN compras c ON MONTH(c.fecha) = meses.mes_numero AND YEAR(c.fecha) = YEAR(CURDATE())  AND c.estado = 'Activo'
            GROUP BY meses.mes_numero
            ORDER BY meses.mes_numero;";


        $query = $this->conexion->ejecutarConsulta($sql);

        // // Arrays para almacenar los ingresos
        $ingresos = array();

        // // Recorrer los resultados de la consulta
        while ($row = $query->fetch_assoc()) {
            $ingresos[] = $row['total_compras']; //agrego cada ingreso de la consulta a un array
        }

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        // Retornar un array con los nombres de los meses y los ingresos
        $data = array(
            "meses" => $meses,
            "ingresos" => $ingresos
        );
        return $data;
    }

    public function categoriasConMasCompras()
    {
        $query = "SELECT c.nombre_categoria, 
                SUM(dc.cantidad_producto * dc.precio_producto) ingresos
                FROM detalle_compra dc
                INNER JOIN productos p ON dc.id_producto = p.id_producto
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE dc.estado = 'Activo' 
                GROUP BY c.nombre_categoria
                ORDER BY ingresos DESC
                LIMIT 10";

        $result = $this->conexion->ejecutarConsulta($query);

        $categorias = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row["nombre_categoria"];
                $ingresos[] = $row["ingresos"];

            }
        }

        // Crea un array asociativo con los datos
        $data = array(
            "categorias" => $categorias,
            "ingresos" => $ingresos
        );

        // Convertir a JSON y devolver
        return $data;
    }


    public function productosMasComprados()
    {
        $query = "SELECT p.nombre_producto, 
                SUM(dc.cantidad_producto * dc.precio_producto) AS ingresos
                FROM detalle_compra dc
                INNER JOIN productos p ON dc.id_producto = p.id_producto
                WHERE dc.estado = 'Activo' 
                GROUP BY p.nombre_producto
                ORDER BY ingresos DESC
                LIMIT 10;
                ";

        $result = $this->conexion->ejecutarConsulta($query);

        $productos = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row["nombre_producto"];
                $ingresos[] = $row["ingresos"];
            }
        }

        // Crea un array asociativo con los datos
        $data = array(
            "productos" => $productos,
            "ingresos" => $ingresos
        );
        return $data;
    }

    public function totalGastosCadaMesDelAnio()
    {
        // Consulta SQL para obtener el total de ventas de cada mes del año actual
        $sql = "SELECT
                meses.mes_numero AS mes,
                COALESCE(SUM(g.precio_total), 0) AS total_gastos
            FROM (
                -- Generar una serie de números del 1 al 12 (representando los meses)
                SELECT 1 AS mes_numero UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL
                SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL
                SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
            ) meses
            LEFT JOIN gastos g ON MONTH(g.fecha) = meses.mes_numero AND YEAR(g.fecha) = YEAR(CURDATE())  AND g.estado = 'Activo'
            GROUP BY meses.mes_numero
            ORDER BY meses.mes_numero;";


        $query = $this->conexion->ejecutarConsulta($sql);

        // // Arrays para almacenar los ingresos
        $ingresos = array();

        // // Recorrer los resultados de la consulta
        while ($row = $query->fetch_assoc()) {
            $ingresos[] = $row['total_gastos']; //agrego cada ingreso de la consulta a un array
        }

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        // Retornar un array con los nombres de los meses y los ingresos
        $data = array(
            "meses" => $meses,
            "ingresos" => $ingresos
        );
        return $data;
    }

    public function categoriasConMasGastos()
    {
        $query = "SELECT 
                    cg.nombre_categoria_gasto, 
                    SUM(g.precio_total) AS gastos_total
                    FROM gastos g
                    JOIN 
                        categorias_gastos cg ON cg.id_categoria_gasto = g.id_categoria_gasto
                    WHERE g.estado = 'Activo' 
                    GROUP BY cg.nombre_categoria_gasto
                    ORDER BY gastos_total DESC
                    LIMIT 10";

        $result = $this->conexion->ejecutarConsulta($query);

        $categorias = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row["nombre_categoria_gasto"];
                $ingresos[] = $row["gastos_total"];

            }
        }
        if (empty($categorias) || empty($ingresos)) {
            $categorias = ['Sin gastos'];
            $ingresos = [0];
        }

        // Crea un array asociativo con los datos
        $data = array(
            "categorias" => $categorias,
            "ingresos" => $ingresos
        );

        // Convertir a JSON y devolver
        return $data;
    }

    public function categoriasMasRepetidasGastos()
    {
        $query = "SELECT 
                    cg.nombre_categoria_gasto, 
                    COUNT(g.id_categoria_gasto) AS cantidadRepiteGasto
                    FROM gastos g
                    JOIN 
                        categorias_gastos cg ON cg.id_categoria_gasto = g.id_categoria_gasto
                    WHERE g.estado = 'Activo' 
                    GROUP BY cg.nombre_categoria_gasto
                    ORDER BY cantidadRepiteGasto DESC
                    LIMIT 10";

        $result = $this->conexion->ejecutarConsulta($query);

        $categorias = array();
        $ingresos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = $row["nombre_categoria_gasto"];
                $ingresos[] = $row["cantidadRepiteGasto"];

            }
        }

        if (empty($categorias) || empty($ingresos)) {
            $categorias = ['Sin gastos'];
            $ingresos = [0];
        }

        // Crea un array asociativo con los datos
        $data = array(
            "categorias" => $categorias,
            "ingresos" => $ingresos
        );

        // Convertir a JSON y devolver
        return $data;
    }



    public function datosDiariosPorMes()
    {
        $mesSeleccionado = date('n');
        $fechaInicioMes = date('Y-m-d', mktime(0, 0, 0, $mesSeleccionado, 1, date('Y')));
        $fechaFinMes = date('Y-m-d', mktime(0, 0, 0, $mesSeleccionado + 1, 0, date('Y')));
        $diasDelMes = range(1, date('t', strtotime($fechaInicioMes)));
        $diasDelMes = array_map(function ($dia) {
            return str_pad($dia, 2, '0', STR_PAD_LEFT);
        }, $diasDelMes);

        $ventas = $this->obtenerDatosDiarios('ventas', 'precio_total', $fechaInicioMes, $fechaFinMes, $diasDelMes);
        $compras = $this->obtenerDatosDiarios('compras', 'precio_total', $fechaInicioMes, $fechaFinMes, $diasDelMes);
        $gastos = $this->obtenerDatosDiarios('gastos', 'precio_total', $fechaInicioMes, $fechaFinMes, $diasDelMes);
        $gananciaReal = $this->calcularGananciaReal($ventas, $gastos, $compras);
        // tengo que hacer que descuente compra tambien en la ganancia real //
        $data = array(
            "dias" => $diasDelMes,
            "ventas" => $ventas,
            "compras" => $compras,
            "gastos" => $gastos,
            "gananciaReal" => $gananciaReal
        );

        // echo json_encode($data);
        return $data;
    }

    private function obtenerDatosDiarios($tabla, $campo, $fechaInicio, $fechaFin, $diasDelMes)
    {
        $query = "SELECT DATE_FORMAT(fecha, '%d') AS dia, SUM($campo) AS monto
              FROM $tabla
              WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado = 'Activo'
              GROUP BY dia
              ORDER BY fecha";

        $result = $this->conexion->ejecutarConsulta($query);
        $dias = array();
        $montos = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dia = str_pad($row['dia'], 2, '0', STR_PAD_LEFT);
                $dias[] = $dia;
                $montos[] = (float) $row['monto'];
            }
        }

        foreach ($diasDelMes as $diaDelMes) {
            if (!in_array($diaDelMes, $dias)) {
                $dias[] = $diaDelMes;
                $montos[] = 0.00;
            }
        }

        array_multisort($dias, $montos);
        return $montos;
    }

    private function calcularGananciaReal($ventas, $gastos, $compras)
    {
        $gananciaReal = array();
        for ($i = 0; $i < count($ventas); $i++) {
            $gananciaReal[] = $ventas[$i] - ($gastos[$i] + $compras[$i]);
        }
        return $gananciaReal;
    }

    public function obtenerTotalesDelMes()
    {
        $mesSeleccionado = date('n');
        $fechaInicioMes = date('Y-m-d', mktime(0, 0, 0, $mesSeleccionado, 1, date('Y')));
        $fechaFinMes = date('Y-m-d', mktime(0, 0, 0, $mesSeleccionado + 1, 0, date('Y')));

        // Obtener datos diarios
        $ventas = $this->obtenerDatosDiarios('ventas', 'precio_total', $fechaInicioMes, $fechaFinMes, range(1, date('t', strtotime($fechaInicioMes))));
        $compras = $this->obtenerDatosDiarios('compras', 'precio_total', $fechaInicioMes, $fechaFinMes, range(1, date('t', strtotime($fechaInicioMes))));
        $gastos = $this->obtenerDatosDiarios('gastos', 'precio_total', $fechaInicioMes, $fechaFinMes, range(1, date('t', strtotime($fechaInicioMes))));
        $gananciaReal = $this->calcularGananciaReal($ventas, $gastos, $compras);

        // Calcular totales
        $totalVentas = array_sum($ventas);
        $totalCompras = array_sum($compras);
        $totalGastos = array_sum($gastos);
        $totalGananciaReal = array_sum($gananciaReal);

        $data = array(
            "totalVentas" => $totalVentas,
            "totalCompras" => $totalCompras,
            "totalGastos" => $totalGastos,
            "totalGananciaReal" => $totalGananciaReal
        );

        return $data;
    }

    public function obtenerDatosMensuales()
    {
        $anioActual = date('Y');
        $meses = array();
        $gananciaReal = array();
        $dineroPerdido = array();

        for ($mes = 1; $mes <= 12; $mes++) {
            $fechaInicioMes = date('Y-m-d', mktime(0, 0, 0, $mes, 1, $anioActual));
            $fechaFinMes = date('Y-m-d', mktime(0, 0, 0, $mes + 1, 0, $anioActual));

            $ventas = $this->obtenerDatosDiarios('ventas', 'precio_total', $fechaInicioMes, $fechaFinMes, range(1, date('t', strtotime($fechaInicioMes))));
            $compras = $this->obtenerDatosDiarios('compras', 'precio_total', $fechaInicioMes, $fechaFinMes, range(1, date('t', strtotime($fechaInicioMes))));
            $gastos = $this->obtenerDatosDiarios('gastos', 'precio_total', $fechaInicioMes, $fechaFinMes, range(1, date('t', strtotime($fechaInicioMes))));
            $gananciaRealMes = array_sum($ventas) - array_sum($compras) - array_sum($gastos);

            $meses[] = date('F', mktime(0, 0, 0, $mes, 1, $anioActual));
            $gananciaReal[] = $gananciaRealMes;
            $dineroPerdido[] = array_sum($compras) + array_sum($gastos);
        }
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $data = array(
            "meses" => $meses,
            "gananciaReal" => $gananciaReal,
            "dineroPerdido" => $dineroPerdido
        );

        return $data;
    }

    public function obtenerRentabilidadProductos()
    {
        // Obtener los productos más vendidos
        $queryVentas = "SELECT p.nombre_producto, 
                       SUM(dv.cantidad_producto * dv.precio_producto) AS ingresos
                       FROM detalle_venta dv
                       INNER JOIN productos p ON dv.id_producto = p.id_producto
                       WHERE dv.estado = 'Activo'
                       GROUP BY p.nombre_producto
                       ORDER BY ingresos DESC
                       LIMIT 10";
        $resultVentas = $this->conexion->ejecutarConsulta($queryVentas);

        $productos = array();
        $ventas = array();
        $costos = array();
        $rentabilidad = array();

        while ($row = $resultVentas->fetch_assoc()) {
            $productos[] = $row['nombre_producto'];
            $ventas[] = (float) $row['ingresos'];
        }

        // Obtener los costos de compra para los productos más vendidos
        foreach ($productos as $index => $producto) {
            $queryCompras = "SELECT p.nombre_producto, 
                            SUM(dc.cantidad_producto * dc.precio_producto) AS ingresos
                            FROM detalle_compra dc
                            INNER JOIN productos p ON dc.id_producto = p.id_producto
                            WHERE dc.estado = 'Activo' AND p.nombre_producto = '$producto'
                            GROUP BY p.nombre_producto";
            $resultCompras = $this->conexion->ejecutarConsulta($queryCompras);
            $rowCompras = $resultCompras->fetch_assoc();

            $costo = isset($rowCompras['ingresos']) ? (float) $rowCompras['ingresos'] : 0;
            $costos[] = $costo;
            $rentabilidad[] = $ventas[$index] - $costo; // Rentabilidad = ventas - costo
        }

        $data = array(
            "productos" => $productos,
            "ventas" => $ventas,
            "costos" => $costos,
            "rentabilidad" => $rentabilidad
        );

        return $data;
    }

}
?>