<?php
// para cargar los contactos

class Contactos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function cargarContacto($telefono)
    {
        $query = "INSERT INTO contactos (telefono,estado) VALUES ('$telefono','Activo')";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function ultimoIdContacto()
    {
        $query = "SELECT MAX(id_contacto) as id_contacto FROM contactos";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_contacto
        $id_contacto = $fila['id_contacto'];    // Devolver el valor de id_contacto
        return $id_contacto;
    }
    public function buscarContacto($idContacto, $contacto)
    {
        if (!empty($idContacto) && !empty($contacto)) {
            // Si tanto el ID como el contacto tienen valor
            $query = "SELECT * FROM contactos WHERE id_contacto = '$idContacto' AND telefono ='$contacto'";
        } elseif (!empty($idContacto)) {
            // Si solo el ID tiene valor
            $query = "SELECT * FROM contactos WHERE id_contacto = '$idContacto'";
        } elseif (!empty($contacto)) {
            // Si solo el contacto tiene valor
            $query = "SELECT * FROM contactos WHERE telefono ='$contacto'";
        } else {
            // Si ninguno tiene valor
            return False;
        }

        $resultado = $this->conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            return True;
        } else {
            return False;
        }
    }

    public function modificarContacto($idContacto, $contacto)
    {
        $query = "UPDATE contactos SET telefono='$contacto' WHERE id_contacto = '$idContacto';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
}

?>