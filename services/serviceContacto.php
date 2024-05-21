<?php
require_once ('./models/classContacto.php');
class ServiceContacto
{
    // return ['success' => $estado, 'message' => $message];
    private $conexion;
    private $modeloContacto;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->modeloContacto = new Contactos($this->conexion);
    }

    public function cargarContacto($contacto)
    {
        $cargarContacto = $this->modeloContacto->cargarContacto($contacto);
        if ($cargarContacto) {
            return True;
        } else {
            return False;
        }
    }

    public function buscarContacto($id, $contacto)
    {
        $resultado = $this->modeloContacto->buscarContacto($id, $contacto);
        return $resultado;
    }

    public function ultimoIdContacto()
    {
        $idContacto = $this->modeloContacto->ultimoIdContacto();
        return $idContacto;
    }

    public function modificarContacto($idContacto, $contacto)
    {
        $modificarContacto = $this->modeloContacto->modificarContacto($idContacto, $contacto);
        if ($modificarContacto) {
            return True;
        } else {
            return False;
        }
    }
}
?>