<?php
//mi clase para cargar, actualizar, leer y eliminar usuarios

class Personas
{
    private $conexion;
    public function __construct(
        $conexion
    ) {
        $this->conexion = $conexion;
    }

    public function cargarPersona($id_contacto, $nombre, $apellido)
    {
        $query = "INSERT INTO personas (id_contacto, nombre, apellido, estado) VALUES ('$id_contacto', '$nombre', '$apellido', 'Activo')";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function ultimoIdPersona()
    {
        $query = "SELECT MAX(id_persona) as id_persona FROM personas";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_persona
        $id_persona = $fila['id_persona'];    // Devolver el valor de id_persona
        return $id_persona;
    }
    public function buscarPersona($idPersona, $nombrePersona, $apellidoPersona)
    {
        if (!empty($idPersona) && !empty($nombrePersona) && !empty($apellidoPersona)) {
            $query = "SELECT * FROM personas WHERE id_persona = '$idPersona' AND nombre = '$nombrePersona' AND apellido = '$apellidoPersona' ";
        } else if (!empty($idPersona)) {
            $query = "SELECT * FROM personas WHERE id_persona = '$idPersona' ";
        } else if (!empty($nombrePersona) && !empty($apellidoPersona)) {
            $query = "SELECT * FROM personas WHERE nombre = '$nombrePersona' AND apellido = '$apellidoPersona' ";
        }
        $resultado = $this->conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            return True;
        } else {
            return False;
        }
    }

    public function obtenerDatosSimplePersona($id){
        $query = "SELECT * FROM personas WHERE id_persona = '$id';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $resultado = $sql->fetch_assoc();
        return $resultado;
    }

    public function cambiarEstadoPersona($idPersona, $nuevoEstado){
        $query = "UPDATE personas SET estado='$nuevoEstado' WHERE id_persona = '$idPersona';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
    public function modificarPersona($idPersona, $nombre, $apellido){
        $query = "UPDATE personas SET nombre='$nombre', apellido = '$apellido' WHERE id_persona = '$idPersona';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
}
?>