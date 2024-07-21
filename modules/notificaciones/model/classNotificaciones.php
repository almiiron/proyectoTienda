<?php
class ClassNotificaciones
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

    public function listarNotificaciones($start, $size)
    {

        // aca hago una consulta para traer todas mis notificaciones de la bd
        // Construye la consulta SQL con los filtros
        $query = "SELECT * FROM notificaciones LIMIT " . $start . ',' . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las notificaciones
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $notificaciones
        //luego recorro el array con un foreach

        $notificaciones = array(); // Array para almacenar las notificaciones
        while ($row = mysqli_fetch_assoc($resultado)) {
            $notificaciones[] = $row; // Agrega el resultado al array
        }
        return $notificaciones;
    }

    public function cargarNotificacion($mensaje, $tipo)
    {
        // tipos de notificaciones: Éxito, Información, Advertencia, Error //
        $query = "INSERT INTO notificaciones(mensaje, tipo, fecha, hora, estado) 
        VALUES ('$mensaje','$tipo','$this->fecha','$this->hora','Activo')";
        $sql = $this->conexion->ejecutarConsulta($query);

        $resultado = ($sql == true) ? true : false;
        return $resultado;
    }

    public function cambiarEstadoNotificacion($id, $nuevoEstado)
    {
        $query = "UPDATE notificaciones SET estado = ? WHERE id_notif = ?";
        $tipos = 'si'; // i para enteros (id_cliente, id_empleado, id_metodo_pago), d para dobles (sub_total_venta, total_venta)

        // Usar la función ejecutarConsultaPreparada
        $resultado = $this->conexion->ejecutarConsultaPreparada(
            $query,
            $tipos,
            $nuevoEstado,
            $id
        );

        if ($resultado !== false) {
            return true; // Retorna true si la inserción fue exitosa
        } else {
            return false; // Retorna false si hubo un error en la inserción
        }
        // return $resultado;
    }

    public function obtenerNotificacionesNoLeidas()
    {
        // para obtener el total de notificaciones sin leer //
        $query = "SELECT * FROM notificaciones WHERE estado = 'Activo'";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $cantidadNot = mysqli_num_rows($resultado);
        return $cantidadNot;
    }

    public function prepararFiltrosNotificaciones($filtro)
    {

        $where_clause = "WHERE id_notif LIKE '%$filtro%' OR mensaje LIKE '%$filtro%' OR tipo LIKE '%$filtro%'
        OR fecha LIKE '%$filtro%' OR hora LIKE '%$filtro%' OR estado = '%$filtro%' ";

        return $where_clause;
    }

    public function listaFiltradaNotificaciones($where_clause, $start, $size)
    {
        // Construye la consulta SQL con los filtros y ordenamientos
        $query = "SELECT * FROM notificaciones $where_clause LIMIT " . $start . "," . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);

        $notificaciones = array();
        while ($row = mysqli_fetch_assoc($resultado)) {
            $notificaciones[] = $row; 
        }
        return $notificaciones;
    }
}
?>