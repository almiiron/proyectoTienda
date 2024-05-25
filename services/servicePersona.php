<?php
require_once ('./models/classPersona.php');
class ServicePersona
{
    private $conexion;
    private $modeloPersona;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->modeloPersona = new Personas($this->conexion);
    }

    public function cargarPersona($idContacto, $nombreCliente, $apellidoCliente)
    {
        $resultado = $this->modeloPersona->cargarPersona($idContacto, $nombreCliente, $apellidoCliente);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function buscarPersona($idPersona, $nombrePersona, $apellidoPersona)
    {
        $resultado = $this->modeloPersona->buscarPersona($idPersona, $nombrePersona, $apellidoPersona);
        return $resultado;
    }

    public function ultimoIdPersona()
    {
        $resultado = $this->modeloPersona->ultimoIdPersona();
        return $resultado;
    }

    public function obtenerDatosSimplePersona($id)
    {
        $resultado = $this->modeloPersona->obtenerDatosSimplePersona($id);
        return $resultado;
    }

    public function cambiarEstadoPersona($idPersona, $nuevoEstado){
        $resultado = $this->modeloPersona->cambiarEstadoPersona($idPersona, $nuevoEstado);
        return $resultado;
    }

    public function modificarPersona($idPersona, $nombrePersona, $apellidoPersona){
        $resultado = $this->modeloPersona->modificarPersona($idPersona, $nombrePersona, $apellidoPersona);
        return $resultado;
    }
}


?>