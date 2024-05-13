<?php
require ('../model/classConexion.php');
require ('../model/classPersona.php');
require ('../model/classContacto.php');


class ControllerPersona
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function guardarPersona()
    {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];

        $contacto = new Contactos(null, $telefono);
        $contacto->cargarContacto($telefono, $this->conexion);
        $id_contacto = $contacto->ultimoIdContacto($this->conexion);

        if ($id_contacto) {
            $persona = new Personas(null, $id_contacto, $nombre, $apellido);

            // Guardar la persona en la base de datos
            $persona->cargarPersona($id_contacto, $nombre, $apellido, $this->conexion); // Método para guardar la persona en la base de datos
            $id_persona = $persona->ultimoIdPersona($this->conexion);
            if ($id_persona) {
                echo "¡Persona registrada exitosamente!";
            }
        }
    }
}

?>