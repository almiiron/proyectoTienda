<?php
class Pagination
{
    public function getTotalRows($table, $conexion, $where_clause = '')
    {
        $query = "SELECT COUNT(*) as TotalRows FROM $table $where_clause";
        $resultado = $conexion->ejecutarConsulta($query);
        $totalRows = $resultado->fetch_assoc();
        return $totalRows['TotalRows'];
    }
}

?>