<?php
class Productos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function cargarProducto($idCategoria, $idProveedor, $nombreProducto, $precio, $stock)
    {
        $query = "INSERT INTO productos(id_categoria, id_proveedor, nombre_producto, precio, stock, estado) 
        VALUES ('$idCategoria','$idProveedor','$nombreProducto','$precio','$stock', 'Activo');";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function buscarproducto($id, $nombreProducto)
    {
        //para verificar que exista la categoria, si mysqli_num_rows devuelve mayor a 0 existe esa categoria
        if (!empty($id) && !empty($nombreProducto)) { // Si tanto $id como $nombreProducto no están vacíos
            $query = "SELECT * FROM productos WHERE id_producto = '$id' AND nombre_producto = '$nombreProducto'";
        } elseif (!empty($id)) {// Si $id no está vacío
            $query = "SELECT * FROM productos WHERE id_categoria = '$id'";
        } elseif (!empty($nombreProducto)) { // Si $nombreProducto no está vacío
            $query = "SELECT * FROM productos WHERE nombre_producto = '$nombreProducto'";
        }

        $resultado = $this->conexion->ejecutarConsulta($query);
        if (mysqli_num_rows($resultado) > 0) {
            return True;
        } else {
            return False;
        }

    }
    public function listarProductos($start, $size)
    {

        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio, prod.stock, prod.estado FROM productos prod
         INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
         INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor 
         LIMIT " . $start . "," . $size;

        $resultado = $this->conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }

    public function listarUnProducto($id)
    {
        $query = "SELECT prod.id_producto, prod.nombre_producto, prod.id_categoria, prod.id_proveedor, c.nombre_categoria, prov.nombre, prod.precio, prod.stock FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor
        WHERE prod.id_producto = '$id'
         ";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $producto = mysqli_fetch_assoc($resultado);
        return $producto;
    }

    public function modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto)
    {
        $query = "UPDATE productos SET 
        id_categoria='$IdCategoriaProducto',
        id_proveedor='$IdProveedorProducto',
        nombre_producto='$nombreProducto',
        precio='$precioProducto',
        stock='$stockProducto'
        WHERE id_producto = '$IdProducto';";
        $resultado = $this->conexion->ejecutarConsulta($query);
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
    public function listaFiltradaProductos($where_clause, $start, $size)
    {
        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio, prod.stock, prod.estado FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor
        $where_clause LIMIT " . $start . "," . $size;
        $resultado = $this->conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }

    public function cambiarEstadoProducto($id, $nuevoEstado)
    {
        $query = "UPDATE productos SET estado='$nuevoEstado' WHERE id_producto = '$id'";
        $resultado = $this->conexion->ejecutarConsulta($query);
        if ($resultado) {
            return True;
        } else {
            return False;
        }
    }

    public function mostrarTodosProductosVenta()
    {
        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio, prod.stock, prod.estado FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor";
        $resultado = $this->conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }
}
?>