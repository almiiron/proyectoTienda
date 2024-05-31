<?php
require_once ('./modules/pagination/model/classPagination.php');

class ControllerPagination
{
    private $paginationModel;
    public $size;
    public function __construct($conexion, $size)
    {
        $this->paginationModel = new Pagination($conexion);
        $this->size = $size;
    }

    public function getTotalRows($table, $where_clause = '')
    {
        return $this->paginationModel->getTotalRows($table, $where_clause);
    }

    public function getTotalPages($totalRows, $size)
    {
        return ceil($totalRows / $size);
    }
}


?>