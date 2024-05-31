<?php
class Empleado
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function listarEmpleados($start, $size)
    {
        $query = "SELECT em.id_empleado, pe.nombre, pe.apellido, us.nombre_usuario, c.telefono, em.estado FROM empleados em 
        INNER JOIN personas pe ON pe.id_persona = em.id_persona 
        INNER JOIN usuarios us ON em.id_usuario = us.id_usuario
        INNER JOIN contactos c ON c.id_contacto = pe.id_contacto
        LIMIT " . $start . ", " . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);
        return $resultado;
    }

    public function cargarEmpleado($idPersona, $idUser)
    {
        $query = "INSERT INTO empleados(id_persona, id_usuario, estado)
         VALUES ('$idPersona','$idUser','Activo')";
        $sql = $this->conexion->ejecutarConsulta($query);
        $resultado = ($sql) ? True : False;
        return $resultado;
    }

    public function obtenerDatosSimplesEmpleado($id)
    {
        $query = "SELECT * FROM empleados WHERE id_empleado = '$id';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $cliente = $resultado->fetch_assoc();
        return $cliente;
    }

    public function cambiarEstadoEmpleado($id, $nuevoEstado)
    {
        $query = "UPDATE empleados SET estado='$nuevoEstado' WHERE id_empleado = '$id';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $resultado = ($sql) ? True : False;
        return $resultado;
    }

    public function prepararFiltrosEmpleados($filtro)
    {
        $where_clause = "WHERE em.id_empleado LIKE '%$filtro%' OR pe.nombre LIKE '%$filtro%' OR pe.apellido LIKE '%$filtro%' OR us.nombre_usuario LIKE '%$filtro%' 
        OR c.telefono LIKE '%$filtro%' OR em.estado LIKE '%$filtro%'";
        return $where_clause;
    }

    public function listaFiltradaEmpleados($where_clause, $start, $size)
    {
        $query = "SELECT em.id_empleado, pe.nombre, pe.apellido, us.nombre_usuario, c.telefono, em.estado FROM empleados em 
        INNER JOIN personas pe ON pe.id_persona = em.id_persona 
        INNER JOIN usuarios us ON em.id_usuario = us.id_usuario
        INNER JOIN contactos c ON c.id_contacto = pe.id_contacto 
        $where_clause 
        LIMIT " . $start . ", " . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);
        $empleados = array(); // Array para almacenar 
        while ($row = mysqli_fetch_assoc($resultado)) {
            $empleados[] = $row; // Agrega el resultado al array
        }
        return $empleados;
    }
}
?>