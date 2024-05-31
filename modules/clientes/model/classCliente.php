<?php
class Clientes
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function listarClientes($start, $size)
    {
        // aca hago una consulta para traer todas mis clientes de la bd
        // Construye la consulta SQL con los filtros
        $query = "SELECT cl.id_cliente, p.nombre, p.apellido, co.telefono, cl.estado  FROM clientes cl INNER JOIN personas p ON p.id_persona = cl.id_persona INNER JOIN contactos co ON co.id_contacto = p.id_contacto  LIMIT " . $start . ',' . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las clientes
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $clientes
        //luego recorro el array con un foreach

        $clientes = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $clientes[] = $row; // Agrega el resultado al array
        }
        return $clientes;
    }

    public function cargarCliente($idPersona)
    {
        $query = "INSERT INTO clientes (id_persona, estado) VALUES ('$idPersona', 'Activo');";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function cambiarEstadoCliente($id, $nuevoEstado)
    {
        $query = "UPDATE clientes SET estado='$nuevoEstado' WHERE id_cliente = '$id'";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function obtenerDatosSimplesCliente($id)
    {
        $query = "SELECT * FROM clientes WHERE id_cliente = '$id';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $resultado = $sql->fetch_assoc();
        return $resultado;
    }

    public function prepararFiltrosCliente($filtro)
    {
        $where_clause = "WHERE cl.id_cliente LIKE '%$filtro%' OR p.nombre LIKE '%$filtro%' OR p.apellido LIKE '%$filtro%' 
        OR co.telefono LIKE '%$filtro%' OR cl.estado LIKE '%$filtro%'";

        return $where_clause;
    }

    public function listaFiltradaClientes($where_clause, $start, $size)
    {
  // aca hago una consulta para traer todas mis clientes de la bd
        // Construye la consulta SQL con los filtros
        $query = "SELECT cl.id_cliente, p.nombre, p.apellido, co.telefono, cl.estado  FROM clientes cl 
        INNER JOIN personas p ON p.id_persona = cl.id_persona INNER JOIN contactos co ON co.id_contacto = p.id_contacto  
        $where_clause LIMIT " . $start . ',' . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);

        //creo un array para guardar las clientes
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $clientes
        //luego recorro el array con un foreach

        $clientes = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $clientes[] = $row; // Agrega el resultado al array
        }
        return $clientes;
    }
}
?>