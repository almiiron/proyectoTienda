<?php
class Proveedores
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function cargarProveedor($idContacto, $nombreProveedor)
    {
        $query = "INSERT INTO proveedores (id_contacto, nombre, estado) VALUES ('$idContacto','$nombreProveedor', 'Activo');";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function buscarProveedor($idProveedor, $nombreProveedor)
    {
        if (!empty($idProveedor) && !empty($nombreProveedor)) {
            // Si tanto el ID como el nombre tienen valor
            $query = "SELECT * FROM proveedores WHERE id_proveedor = '$idProveedor' AND nombre = '$nombreProveedor'";
        } elseif (!empty($idProveedor)) {
            // Si solo el ID tiene valor
            $query = "SELECT * FROM proveedores WHERE id_proveedor = '$idProveedor'";
        } elseif (!empty($nombreProveedor)) {
            // Si solo el nombre tiene valor
            $query = "SELECT * FROM proveedores WHERE nombre = '$nombreProveedor'";
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


    public function listarProveedores($start, $size)
    {

        // aca hago una consulta para traer todas mis proveedores de la bd
        // Construye la consulta SQL con los filtros
        $query = "SELECT p.id_proveedor, p.nombre, c.telefono, p.estado FROM proveedores p INNER JOIN contactos c ON c.id_contacto = p.id_contacto LIMIT " . $start . ',' . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las proveedores
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $proveedores
        //luego recorro el array con un foreach

        $proveedores = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $proveedores[] = $row; // Agrega el resultado al array
        }
        return $proveedores;
    }

    public function productoConProveedor($id, $conexion)
    {
        $query = "SELECT * FROM productos WHERE id_proveedor = '$id';";
        $resultado = $conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            return True;
        } else {
            return False;
        }
    }

    public function cambiarEstadoProveedor($id, $nuevoEstado)
    {
        $query = "UPDATE proveedores SET estado='$nuevoEstado' WHERE id_proveedor = '$id';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function listarUnProveedor($id)
    {
        $query = "SELECT p.id_proveedor, p.id_contacto, p.nombre, c.telefono FROM proveedores p INNER JOIN contactos c ON c.id_contacto = p.id_contacto WHERE id_proveedor = '$id';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $proveedor = mysqli_fetch_assoc($resultado);
        return $proveedor;
    }

    public function modificarProveedor($idProveedor, $nombreProveedor)
    {
        $query = "UPDATE proveedores SET nombre='$nombreProveedor' WHERE id_proveedor = '$idProveedor';";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function listaFiltradaProveedores($where_clause, $start, $size)
    {
        $query = "SELECT p.id_proveedor, p.nombre, c.telefono, p.estado FROM proveedores p INNER JOIN contactos c ON c.id_contacto = p.id_contacto $where_clause 
        LIMIT " . $start . "," . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);
        $proveedores = array();
        while ($row = mysqli_fetch_assoc($resultado)) {
            $proveedores[] = $row; // Agrega el resultado al array
        }
        return $proveedores;
    }


    public function prepararFiltrosProveedores($filtro)
    {
        $where_clause = "WHERE p.id_proveedor LIKE '%$filtro%' OR p.nombre LIKE '%$filtro%' OR c.telefono LIKE '%$filtro%' OR p.estado LIKE '%$filtro%'";

        return $where_clause;
    }

    public function mostrarProveedores()
    {

        // aca hago una consulta para traer todas mis proveedores de la bd
        // Construye la consulta SQL con los filtros
        $query = "SELECT p.id_proveedor, p.nombre, c.telefono, p.estado FROM proveedores p INNER JOIN contactos c ON c.id_contacto = p.id_contacto ";
        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las proveedores
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $proveedores
        //luego recorro el array con un foreach

        $proveedores = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $proveedores[] = $row; // Agrega el resultado al array
        }
        return $proveedores;

    }
}
?>