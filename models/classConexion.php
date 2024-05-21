<?php
//mi clase conexion

class Conexion
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db = 'tienda';
    private $conexion;

    public function __construct()
    {
        //asi se crea la conexion
        $this->conexion = new mysqli($this->host, $this->user, $this->password, $this->db);
    }

    //asi se obtiene la conexion
    public function obtenerConexion()
    {
        return $this->conexion;
    }

    // metodo para ejecutar una consulta SQL
    public function ejecutarConsulta($query)
    {
        return $this->conexion->query($query);
    }

}
?>