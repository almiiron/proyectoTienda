<?php
class Pagination
{
    private $conexion;
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    public function getTotalRows($table, $where_clause = '')
    {
        $query = "SELECT COUNT(*) as TotalRows FROM $table $where_clause";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $totalRows = $resultado->fetch_assoc();
        return $totalRows['TotalRows'];
    }
}

?>