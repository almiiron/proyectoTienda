<?php
require_once ('./model/classProducto.php');
require_once ('controllerCategoria.php');
require_once ('controllerProveedor.php');
class ControllerProducto
{
    private $conexion;
    private $proveedores;
    private $categorias;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->proveedores = new controllerProveedor($this->conexion);
        $this->categorias = new ControllerCategoria($this->conexion);
    }

    public function mostrarCargarProducto()
    {
        $listaProveedores = $this->proveedores->mostrarProveedores();
        $listaCategorias = $this->categorias->mostrarCategorias();
        require_once ('./views/layouts/header.php');
        require_once ('./views/cargar/cargar-producto.php');
        require_once ('./views/layouts/footer.php');

    }
    public function procesarCargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $Producto = new Productos(null, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto);
        $buscarProducto = $Producto->buscarProducto(null, $nombreProducto, $this->conexion);

        if ($buscarProducto == False) {
            //no hay productos en la bd con ese nombre, por lo que la funcion devuelve False
            $cargarProducto = $Producto->cargarProducto($IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto, $this->conexion);
            if ($cargarProducto) {
                //si la funcion devuelve true es porque se cargó el producto
                $estado = True;
                $message = "¡El producto fue cargado con éxito!";
            } else {
                $estado = False;
                $message = "¡Hubo un problema al cargar el producto!";
            }
        } else {
            //hay una coincidencia en la bd con ese nombre, muestra un mensaje
            $estado = False;
            $message = "¡El producto ya fue cargado!";
        }

        header('Content-Type: application/json');
        echo json_encode(array('success' => $estado, 'message' => $message));

    }

    public function listarProductos()
    {
        $Producto = new Productos(null, null, null, null, null, null);
        $lista = $Producto->listarProductos($this->conexion);

        if ($lista) {
            //si hay categorias para mostrar, ejecuta esto

            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_producto']; // Agregar cada ID al array
            }

            // Ahora puedes pasar tanto la lista como los IDs a la vista
            $contenedor = "Producto";
            $titulo = "Producto";
            $tituloTabla = "Productos";
            $limpiarFiltros = False;
            $encabezados = array("ID Producto", "Nombre del  Producto", "Categoria", "Proveedor", "Precio", "Stock");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        } else {
            //si no hay categorias que mostrar, ejecuta esto
            $contenedor = "Producto";
            $titulo = "Producto";
            $tituloTabla = "Productos";
            $limpiarFiltros = False;    
            $encabezados = array("ID Producto", "Nombre del Producto", "Categoria", "Proveedor", "Precio", "Stock");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        }
    }

    public function mostrarModificarProducto($id)
    {
        $Producto = new Productos(null, null, null, null, null, null);

        $listaProveedores = $this->proveedores->mostrarProveedores();
        $listaCategorias = $this->categorias->mostrarCategorias();

        $buscarProducto = $Producto->listarUnProducto($id, $this->conexion);
        $datosProducto = $buscarProducto;
        require_once ('./views/layouts/header.php');
        require_once ('./views/modificar/modificar-producto.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarModificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $Producto = new Productos($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto);
        $buscarProducto = $Producto->buscarProducto($IdProducto, $nombreProducto, $this->conexion);

        if ($buscarProducto == False) {
            //no hay productos en la bd con ese id producto y nombre, por lo que la funcion devuelve False
            //por lo que significa que el nombre del producto fue modificado
            //ahora tengo que buscar un producto con ese mismo nombre, para no duplicar
            $busquedaProducto = $Producto->buscarproducto(null, $nombreProducto, $this->conexion);
            if ($busquedaProducto == False) {
                //si devuelve False es porque en la tabla no hay otro producto con ese nombre
                //puedo modificar
                $modificarProducto = $Producto->modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto, $this->conexion);
                if ($modificarProducto) {
                    //si la funcion devuelve true es porque se cargó el producto
                    $estado = True;
                    $message = "¡El producto fue modificado con éxito!";
                } else {
                    $estado = False;
                    $message = "¡Hubo un problema al modificar el producto!";
                }
            } else {
                $estado = False;
                $message = "¡Ya existe un producto con ese nombre!";
            }
        } else {
            //si es True es porque hay una fila en la tabla productos con mismo id y nombre
            //significa que no se modificó el nombre del producto
            //por lo que puedo modificar sin problemas, porque no se va a duplicar el nombre del producto en la tabla

            $modificarProducto = $Producto->modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto, $this->conexion);
            if ($modificarProducto) {
                //si la funcion devuelve true es porque se cargó el producto
                $estado = True;
                $message = "¡El producto fue modificado con éxito!";
            } else {
                $estado = False;
                $message = "¡Hubo un problema al modificar el producto!";
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array('success' => $estado, 'message' => $message));
    }

    public function filtrarListarProductos($filtro)
    {
        $Producto = new Productos(null, null, null, null, null, null);
        $where_clause = $Producto->prepararFiltrosProductos($filtro);
        $lista = $Producto->listaFiltradaProductos($where_clause, $this->conexion);

        if ($lista) {
            //si hay categorias para mostrar, ejecuta esto

            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_producto']; // Agregar cada ID al array
            }

            // Ahora puedes pasar tanto la lista como los IDs a la vista
            $contenedor = "Producto";
            $titulo = "Producto";
            $tituloTabla = "Productos";
            $limpiarFiltros = True;
            $encabezados = array("ID Producto", "Nombre del  Producto", "Categoria", "Proveedor", "Precio", "Stock");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        } else {
            //si no hay categorias que mostrar, ejecuta esto
            $contenedor = "Producto";
            $titulo = "Producto";
            $tituloTabla = "Productos";
            $limpiarFiltros = True;
            $encabezados = array("ID Producto", "Nombre del Producto", "Categoria", "Proveedor", "Precio", "Stock");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        }
    }

    public function procesarCambiarEstadoProducto($id, $estadoActual)
    {
        $Producto = new Productos(null, null, null, null, null, null);
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }
        //si es falso es porque no hay productos asociados a ese proveedor
        $cambiarEstadoProducto = $Producto->cambiarEstadoProducto($id, $nuevoEstado, $this->conexion);
        if ($cambiarEstadoProducto) {
            //se eliminó correctamente el proveedor
            $estado = True;
            $message = "¡Se modificó correctamente el Producto!";
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));

        } else {
            $estado = False;
            $message = "¡Hubo un error al modificar el Producto!";
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));
        }
    }

}
?>