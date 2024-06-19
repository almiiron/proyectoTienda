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
    // método para ejecutar consultas preparadas
    public function ejecutarConsultaPreparada($query, $tipos, ...$params)
    {
        $stmt = $this->conexion->prepare($query);
        // if ($stmt === false) {
        //     die('Error en la preparación de la consulta: ' . $this->conexion->error);
        // }

        // Vincular los parámetros
        $stmt->bind_param($tipos, ...$params);

        // Ejecutar la consulta preparada
        $resultado = $stmt->execute();

        // Verificar si la ejecución fue exitosa
        // if ($resultado === false) {
        //     die('Error en la ejecución de la consulta: ' . $stmt->error);
        // }

        $stmt->close();

        return $resultado;
    }
}
?>