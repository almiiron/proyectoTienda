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

        $sql = "SELECT SUM(precio_total) AS ingresosHoy FROM ventas WHERE fecha = '$this->fecha';";

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
                WHERE v.fecha = '$this->fecha';
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
                WHERE fecha = '$this->fecha';
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

        $sql = "SELECT FORMAT(AVG(precio_total), 2) AS promedioVentasHoy FROM ventas WHERE fecha = '$this->fecha'; ";

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
            LEFT JOIN ventas v ON MONTH(v.fecha) = meses.mes_numero AND YEAR(v.fecha) = YEAR(CURDATE())
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
                    WHERE fecha BETWEEN '$fechaHace7Dias' AND '$fechaActual'
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
          WHERE fecha BETWEEN '$fechaHace8Semanas' AND '$fechaActual'
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

}
?>