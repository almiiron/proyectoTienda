<?php
class Productos
{
    private $idProducto;
    private $idCategoria;
    private $idProveedor;
    private $nombreProducto;
    private $precio;
    private $stock;

    public function __construct($idProducto, $idCategoria, $idProveedor, $nombreProducto, $precio, $stock)
    {
        $this->idProducto = $idProducto;
        $this->idCategoria = $idCategoria;
        $this->idProveedor = $idProveedor;
        $this->nombreProducto = $nombreProducto;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function cargarProducto($idCategoria, $idProveedor, $nombreProducto, $precio, $stock, $conexion)
    {
        $query = "INSERT INTO productos(id_categoria, id_proveedor, nombre_producto, precio, stock, estado) 
        VALUES ('$idCategoria','$idProveedor','$nombreProducto','$precio','$stock', 'Activo');";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function buscarproducto($id, $nombreProducto, $conexion)
    {
        //para verificar que exista la categoria, si mysqli_num_rows devuelve mayor a 0 existe esa categoria
        if (!empty($id) && !empty($nombreProducto)) {
            // Si tanto $id como $nombreProducto no están vacíos
            $query = "SELECT * FROM productos WHERE id_producto = '$id' AND nombre_producto = '$nombreProducto'";
            $resultado = $conexion->ejecutarConsulta($query);
            if (mysqli_num_rows($resultado) > 0) {
                return True;
            } else {
                return False;
            }
        } elseif (!empty($id)) {
            // Si $id no está vacío
            $query = "SELECT * FROM productos WHERE id_categoria = '$id'";
            $resultado = $conexion->ejecutarConsulta($query);
            if (mysqli_num_rows($resultado) > 0) {
                return True;
            } else {
                return False;
            }
        } elseif (!empty($nombreProducto)) {
            // Si $nombreProducto no está vacío
            $query = "SELECT * FROM productos WHERE nombre_producto = '$nombreProducto'";
            $resultado = $conexion->ejecutarConsulta($query);
            if (mysqli_num_rows($resultado) > 0) {
                return True;
            } else {
                return False;
            }
        }

    }
    public function listarProductos($conexion)
    {

        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio, prod.stock, prod.estado FROM productos prod
         INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
         INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor
          ";

        $resultado = $conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }

    public function listarUnProducto($id, $conexion)
    {
        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio, prod.stock FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor
        WHERE prod.id_producto = '$id'
         ";

        $resultado = $conexion->ejecutarConsulta($query);

        $producto = mysqli_fetch_assoc($resultado);

        // Devolver la categoría
        return $producto;
    }

    public function modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto, $conexion)
    {
        $query = "UPDATE productos SET 
        id_categoria='$IdCategoriaProducto',
        id_proveedor='$IdProveedorProducto',
        nombre_producto='$nombreProducto',
        precio='$precioProducto',
        stock='$stockProducto'
        WHERE id_producto = '$IdProducto';";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function prepararFiltrosProductos($filtro)
    {
        $where_clause = "WHERE  prod.id_producto LIKE '%$filtro%' OR prod.nombre_producto LIKE '%$filtro%' OR c.nombre_categoria LIKE '%$filtro%'
        OR prov.nombre LIKE '%$filtro%' OR prod.precio LIKE '%$filtro%' OR prod.stock LIKE '%$filtro%' OR prod.estado LIKE '%$filtro%'";
        return $where_clause;
    }
    public function listaFiltradaProductos($where_clause, $conexion)
    {
        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio, prod.stock, prod.estado FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor
        $where_clause";
        $resultado = $conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }

    public function cambiarEstadoProducto($id, $nuevoEstado, $conexion)
    {
        $query = "UPDATE productos SET estado='$nuevoEstado' WHERE id_producto = '$id'";
        $resultado = $conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }
}
?>