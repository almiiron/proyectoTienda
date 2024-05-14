<?php
//mi clase para las categorias de productos

class Categorias
{
    private $id_categoria;
    private $nombre_categoria;

    public function __construct($id_categoria, $nombre_categoria)
    {
        $this->id_categoria = $id_categoria;
        $this->nombre_categoria = $nombre_categoria;
    }

    public function cargarCategoria($nombre_categoria, $conexion)
    {
        //se ejecuta si la categoria no existe en la bd
        $query = "INSERT INTO categorias (nombre_categoria, estado) VALUES ('$nombre_categoria', 'Activo')";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function buscarCategoria($id, $nombre_categoria, $conexion)
    {
        //para verificar que exista la categoria, si mysqli_num_rows devuelve mayor a 0 existe esa categoria
        if (!empty($id) && !empty($nombre_categoria)) {
            // Si tanto $id como $nombre_categoria no están vacíos
            $query = "SELECT * FROM categorias WHERE id_categoria = '$id' AND nombre_categoria = '$nombre_categoria'";
            $resultado = $conexion->ejecutarConsulta($query);
            if (mysqli_num_rows($resultado) > 0) {
                return True;
            } else {
                return False;
            }
        } elseif (!empty($id)) {
            // Si $id no está vacío
            $query = "SELECT * FROM categorias WHERE id_categoria = '$id'";
            $resultado = $conexion->ejecutarConsulta($query);
            if (mysqli_num_rows($resultado) > 0) {
                return True;
            } else {
                return False;
            }
        } elseif (!empty($nombre_categoria)) {
            // Si $nombre_categoria no está vacío
            $query = "SELECT * FROM categorias WHERE nombre_categoria = '$nombre_categoria'";
            $resultado = $conexion->ejecutarConsulta($query);
            if (mysqli_num_rows($resultado) > 0) {
                return True;
            } else {
                return False;
            }
        }

    }

    public function listarCategorias($start, $size, $conexion)
    {

        // aca hago una consulta para traer todas mis categorias de la bd
        // Construye la consulta SQL con los filtros
        $query = "SELECT * FROM categorias LIMIT " . $start . ',' . $size;
        $resultado = $conexion->ejecutarConsulta($query);

        //creo un array para guardar las categorias
        //creo el array por que no puedo retornar ni el $resultado, ni el $row
        //entonces devuelvo todo el $row en mi array $categorias
        //luego recorro el array con un foreach

        $categorias = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $categorias[] = $row; // Agrega el resultado al array
        }
        return $categorias;
    }
    public function totalFilasListarCategorias($conexion)
    {
        $query = "SELECT count(*) as TotalRows FROM categorias;";
        $resultado = $conexion->ejecutarConsulta($query);
        $totalRows = $resultado->fetch_assoc();
        return $totalRows;
    }
    public function productoConCategoria($id, $conexion)
    {
        //busco algun producto con esa categoria
        $query = "SELECT * FROM productos WHERE id_categoria = '$id'";
        $resultado = $conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            return True;
        } else {
            return False;
        }
    }
    public function listaFiltradaCategorias($where_clause, $start, $size, $conexion)
    {
        // Construye la consulta SQL con los filtros y ordenamientos
        $query = "SELECT * FROM categorias $where_clause LIMIT " . $start . "," . $size;
        $resultado = $conexion->ejecutarConsulta($query);

        // Crea un array para guardar las categorías
        $categorias = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $categorias[] = $row; // Agrega el resultado al array
        }
        return $categorias;
    }
    public function totalFilaslistaFiltradaCategorias($where_clause, $conexion)
    {
        $query = "SELECT count(*) as TotalRows FROM categorias ".$where_clause;
        $resultado = $conexion->ejecutarConsulta($query);
        $totalRows = $resultado->fetch_assoc();
        return $totalRows;
    }
    public function prepararFiltrosCategorias($filtro)
    {

        $where_clause = "WHERE id_categoria LIKE '%$filtro%' OR nombre_categoria LIKE '%$filtro%' OR estado LIKE '%$filtro%'";

        return $where_clause;
    }

    public function cambiarEstadoCategoria($id, $nuevoEstado, $conexion)
    {
        $query = "UPDATE categorias SET estado='$nuevoEstado' WHERE id_categoria = '$id'";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function listarUnaCategoria($id, $nombre_categoria, $conexion)
    {
        // Construir la consulta base
        $query = "SELECT * FROM categorias WHERE ";

        // Añadir las condiciones a la consulta según los parámetros proporcionados
        if (!empty($id) && !empty($nombre_categoria)) {
            $query .= "id_categoria = '$id' AND nombre_categoria = '$nombre_categoria'";
        } elseif (!empty($id)) {
            $query .= "id_categoria = '$id'";
        } elseif (!empty($nombre_categoria)) {
            $query .= "nombre_categoria = '$nombre_categoria'";
        }
        // Ejecutar la consulta
        $resultado = $conexion->ejecutarConsulta($query);

        // Almacenar la categoría en un array
        $categoria = mysqli_fetch_assoc($resultado);

        // Devolver la categoría
        return $categoria;
    }

    public function procesarModificarCategoria($id, $nombre_categoria, $conexion)
    {
        $query = "UPDATE categorias SET nombre_categoria = '$nombre_categoria' WHERE id_categoria = '$id'; ";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
}
?>