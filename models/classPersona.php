<?php
//mi clase para cargar, actualizar, leer y eliminar usuarios

class Personas
{
    private $id_persona;
    private $id_contacto; // de mi tabla personas
    private $nombre; // de mi tabla personas
    private $apellido;// de mi tabla personas

    public function __construct(
        $id_persona,
        $id_contacto,
        $nombre,
        $apellido
    ) {
        $this->id_persona = $id_persona;
        $this->id_contacto = $id_contacto;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public function cargarPersona($id_contacto, $nombre, $apellido, $conexion){
        $query = "INSERT INTO personas (id_contacto, nombre, apellido) VALUES ('$id_contacto', '$nombre', '$apellido')";
        $resultado = $conexion->ejecutarConsulta($query);
        if($resultado){
            $id_persona = $this->ultimoIdPersona($conexion);
            echo 'se cargó la persona';
            return $id_persona;
        }
    }

    public function ultimoIdPersona($conexion){
        $query = "SELECT MAX(id_persona) as id_persona FROM personas";
        $resultado = $conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_persona
        $id_persona = $fila['id_persona'];    // Devolver el valor de id_persona
        return $id_persona;
    }
}
?>