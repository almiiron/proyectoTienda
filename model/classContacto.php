<?php
// para cargar los contactos

class Contactos
{
    private $id_contacto;
    private $telefono;

    public function __construct($id_contacto, $telefono)
    {
        $this->id_contacto = $id_contacto;
        $this->telefono = $telefono;
    }

    public function cargarContacto($telefono, $conexion)
    {
        $query = "INSERT INTO contactos (telefono) VALUES ('$telefono')";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function ultimoIdContacto($conexion)
    {
        $query = "SELECT MAX(id_contacto) as id_contacto FROM contactos";
        $resultado = $conexion->ejecutarConsulta($query);
        $fila = $resultado->fetch_assoc();      // Extraer el valor de id_contacto
        $id_contacto = $fila['id_contacto'];    // Devolver el valor de id_contacto
        return $id_contacto;
    }
    public function buscarContacto($idContacto, $contacto, $conexion)
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
        
        $resultado = $conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            return True;
        } else {
            return False;
        }
    }
    
    public function modificarContacto($idContacto, $contacto, $conexion)
    {
        $query = "UPDATE contactos SET telefono='$contacto' WHERE id_contacto = '$idContacto';";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
}

?>