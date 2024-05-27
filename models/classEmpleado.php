<?php
class Empleado{
    private $conexion;
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function listarEmpleados($start, $size){
        $query ="SELECT em.id_empleado, pe.nombre, pe.apellido, us.nombre_usuario, c.telefono, em.estado FROM empleados em 
        INNER JOIN personas pe ON pe.id_persona = em.id_persona 
        INNER JOIN usuarios us ON em.id_usuario = us.id_usuario
        INNER JOIN contactos c ON c.id_contacto = pe.id_contacto
        LIMIT ". $start. ", ". $size;
        $resultado = $this->conexion->ejecutarConsulta($query);
        return $resultado;
    }
}
?>