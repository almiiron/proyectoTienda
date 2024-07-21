<?php
class Productos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function cargarProducto($idCategoria, $idProveedor, $nombreProducto, $precioCompra, $precioVenta, $stock)
    {
        $query = "INSERT INTO productos(id_categoria, id_proveedor, nombre_producto, precio_compra, precio_venta, stock, estado) 
        VALUES ('$idCategoria','$idProveedor','$nombreProducto','$precioCompra', '$precioVenta','$stock', 'Activo');";
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

        $query = "SELECT 
                    prod.id_producto,
                    prod.nombre_producto,
                    c.nombre_categoria,
                    prov.nombre as nombre_proveedor,
                    prod.precio_compra,
                    prod.precio_venta,
                    prod.stock,
                    prod.estado
                    FROM
                    productos prod
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
        $query = "SELECT 
        prod.id_producto,
        prod.nombre_producto,
        prod.id_categoria,
        prod.id_proveedor,
        c.nombre_categoria,
        prov.nombre,
        prod.precio_compra,
        prod.precio_venta,
        prod.stock
        FROM
        productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor
        WHERE prod.id_producto = '$id'
         ";
        $resultado = $this->conexion->ejecutarConsulta($query);
        $producto = mysqli_fetch_assoc($resultado);
        return $producto;
    }

    public function modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProductoCompra, $precioProductoVenta, $stockProducto)
    {
        $query = "UPDATE productos SET 
        id_categoria='$IdCategoriaProducto',
        id_proveedor='$IdProveedorProducto',
        nombre_producto='$nombreProducto',
        precio_compra='$precioProductoCompra',
        precio_venta='$precioProductoVenta',
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
        $where_clause = "WHERE 
        prod.id_producto LIKE '%$filtro%' OR
        prod.nombre_producto LIKE '%$filtro%' OR
        c.nombre_categoria LIKE '%$filtro%' OR
        prov.nombre LIKE '%$filtro%' OR
        prod.precio_compra LIKE '%$filtro%' OR
        prod.precio_venta LIKE '%$filtro%' OR
        prod.stock LIKE '%$filtro%' OR
        prod.estado LIKE '%$filtro%'";
        return $where_clause;
    }
    public function listaFiltradaProductos($where_clause, $start, $size)
    {
        $query = "SELECT 
        prod.id_producto,
        prod.nombre_producto,
        c.nombre_categoria,
        prov.nombre as nombre_proveedor, 
        prod.precio_compra,
        prod.precio_venta,
        prod.stock,
        prod.estado
        FROM
        productos prod
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
        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio_venta, prod.stock, prod.estado FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor";
        $resultado = $this->conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }

    public function actualizarStock($productos, $accionStock)
    {
        // Preparar la consulta para actualizar el stock del producto
        $queryUpdateStock = '';
        if ($accionStock === 'sumar') {
        }
        switch ($accionStock) {
            case 'sumar':
                $queryUpdateStock = "UPDATE productos SET stock = stock + ? WHERE id_producto = ?";
                break;
            case 'restar':
                $queryUpdateStock = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
                break;
            default:
                $queryUpdateStock = false;
                break;
        }
        foreach ($productos as $producto) {
            $idProducto = $producto['id'];
            $cantidadProducto = $producto['cantidad'];
            $tiposUpdateStock = 'ii';

            // Ejecutar la consulta preparada para actualizar el stock del producto
            $resultadoUpdateStock = $this->conexion->ejecutarConsultaPreparada($queryUpdateStock, $tiposUpdateStock, $cantidadProducto, $idProducto);

            // Verificar si la actualización del stock fue exitosa
            if (!$resultadoUpdateStock) {
                return false; // Salir del método si hay un error
            }
        }
        return true;
    }

    public function mostrarTodosProductosCompra()
    {
        $query = "SELECT prod.id_producto, prod.nombre_producto, c.nombre_categoria, prov.nombre, prod.precio_compra, prod.stock, prod.estado FROM productos prod
        INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor";
        $resultado = $this->conexion->ejecutarConsulta($query);

        $productos = array(); // Array para almacenar las categorías
        while ($row = mysqli_fetch_assoc($resultado)) {
            $productos[] = $row; // Agrega el resultado al array
        }
        return $productos;
    }

    public function obtenerCantidadProductosBajoStock($stockMinimo)
    {
        $query = "SELECT count(*) as cantidad FROM productos WHERE stock <= $stockMinimo AND estado = 'Activo';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $fila = $sql->fetch_assoc();      
        $cantidad = $fila['cantidad'];    
        return $cantidad;
    }
    public function obtenerCantidadProductosSinStock()
    {
        $query = "SELECT count(*) as cantidad FROM productos WHERE stock = 0 AND estado = 'Activo';";
        $sql = $this->conexion->ejecutarConsulta($query);
        $fila = $sql->fetch_assoc();      
        $cantidad = $fila['cantidad'];    
        return $cantidad;
    }
   
}
?>