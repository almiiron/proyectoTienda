<?php
require_once ('./model/classPagination.php');

class ControllerPagination
{
    private $paginationModel;
    public $size;
    public function __construct()
    {
        $this->paginationModel = new Pagination;
        $this->size = 30;
    }

    public function getTotalRows($table, $conexion, $where_clause = '')
    {
        return $this->paginationModel->getTotalRows($table, $conexion, $where_clause);
    }

    public function getTotalPages($totalRows, $size)
    {
        return ceil($totalRows / $size);
    }
}


?>