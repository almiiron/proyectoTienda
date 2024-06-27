<?php
require_once ('./modules/productos/model/classProducto.php');
require_once './modules/notificaciones/service/serviceNotificaciones.php';

class ServiceProducto
{
    private $conexion;
    private $modeloProductos;
    private $paginationController;
    private $serviceNotificaciones;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->paginationController = new ControllerPagination($this->conexion, 30);
        $this->modeloProductos = new Productos($this->conexion);
        $this->serviceNotificaciones = new ServiceNotificaciones($conexion);

    }

    public function cargarProducto($nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $buscarProducto = $this->modeloProductos->buscarProducto(null, $nombreProducto);

        if ($buscarProducto == False) { //no hay productos en la bd con ese nombre, por lo que la funcion devuelve False
            $cargarProducto = $this->modeloProductos->cargarProducto($IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto);
            if ($cargarProducto) {
                //si la funcion devuelve true es porque se cargó el producto
                $estado = True;
                $message = "¡Se cargó correctamente el producto!";
                $mensajeNotificacion = 'Se cargó correctamente el producto: ' . $nombreProducto;
                $tipoNotificacion = 'Información';
            } else {
                $estado = False;
                $message = "¡Hubo un error al cargar el producto!";
                $mensajeNotificacion = 'Hubo un error al cargar el producto: ' . $nombreProducto;
                $tipoNotificacion = 'Error';
            }
        } else {
            //hay una coincidencia en la bd con ese nombre, muestra un mensaje
            $estado = False;
            $message = "¡El producto ya existe!";
        }
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }

    public function modificarProducto($IdProducto, $nombreProducto, $IdCategoriaProducto, $IdProveedorProducto, $precioProducto, $stockProducto)
    {
        $buscarProducto = $this->modeloProductos->buscarProducto($IdProducto, $nombreProducto);

        if ($buscarProducto == False) {
            //no hay productos en la bd con ese id producto y nombre, por lo que la funcion devuelve False
            //por lo que significa que el nombre del producto fue modificado
            //ahora tengo que buscar un producto con ese mismo nombre, para no duplicar
            $busquedaProducto = $this->modeloProductos->buscarproducto(null, $nombreProducto);
            if ($busquedaProducto == False) {
                //significa que se modificó todos los datos del producto
                //si devuelve False es porque en la tabla no hay otro producto con ese nombre
                //puedo modificar
                $modificarProducto = $this->modeloProductos->modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto);
                if ($modificarProducto) {
                    //si la funcion devuelve true es porque se cargó el producto
                    $estado = True;
                    $message = "¡Se modificó correctamente el producto!";
                    $mensajeNotificacion = 'Se modificó correctamente el producto de ID ' . $IdProducto;
                    $tipoNotificacion = 'Información';
                } else {
                    $estado = False;
                    $message = "¡Hubo un error al modificar el producto!";
                    $mensajeNotificacion = 'Hubo un error al modificar el producto de ID ' . $IdProducto;
                    $tipoNotificacion = 'Error';
                }
            } else {
                $estado = False;
                $message = "¡Ya existe un producto con ese nombre!";
            }
        } else {
            //significa que se modificó todos los datos del producto menos el nombre
            //si es True es porque hay una fila en la tabla productos con mismo id y nombre
            //significa que no se modificó el nombre del producto
            //por lo que puedo modificar sin problemas, porque no se va a duplicar el nombre del producto en la tabla

            $modificarProducto = $this->modeloProductos->modificarProducto($IdProducto, $IdCategoriaProducto, $IdProveedorProducto, $nombreProducto, $precioProducto, $stockProducto);
            if ($modificarProducto) {
                //si la funcion devuelve true es porque se cargó el producto
                $estado = True;
                $message = "¡El producto fue modificado correctamente!";
                $mensajeNotificacion = 'Se modificó correctamente el producto de ID ' . $IdProducto;
                $tipoNotificacion = 'Información';
            } else {
                $estado = False;
                $message = "¡Hubo un error al modificar el producto!";
                $mensajeNotificacion = 'Hubo un error al modificar el producto de ID ' . $IdProducto;
                $tipoNotificacion = 'Error';
            }
        }
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }

    public function cambiarEstadoProducto($id, $estadoActual)
    {

        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }
        $cambiarEstadoProducto = $this->modeloProductos->cambiarEstadoProducto($id, $nuevoEstado);
        if ($cambiarEstadoProducto) {
            $estado = True;
            $message = "¡Se modificó correctamente el Producto!";
            $mensajeNotificacion = 'Se modificó correctamente el producto de ID ' . $id;
            $mensajeNotificacion .= ', de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Información';
        } else {
            $estado = False;
            $message = "¡Hubo un error al modificar el Producto!";
            $mensajeNotificacion = 'Hubo un error al modificar el producto de ID ' . $id;
            $mensajeNotificacion .= ', de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Error';
        }
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }

    public function listarProductos($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = "  INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor ";
        $totalRows = $this->paginationController->getTotalRows('productos prod' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas

        $lista = $this->modeloProductos->listarProductos($start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay productos para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_producto']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function filtrarListarProductos($filtro, $numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;


        $where_clause = $this->modeloProductos->prepararFiltrosProductos($filtro);
        $where_clause_Pagination = "  INNER JOIN categorias c ON c.id_categoria = prod.id_categoria
        INNER JOIN proveedores prov ON prod.id_proveedor = prov.id_proveedor " . $where_clause;
        $totalRows = $this->paginationController->getTotalRows('productos prod', $where_clause_Pagination); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas
        $lista = $this->modeloProductos->listaFiltradaProductos($where_clause, $start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) {   //si hay productos para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_producto']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function listarUnProducto($id)
    {
        $resultado = $this->modeloProductos->listarUnProducto($id);
        return $resultado;
    }

    public function mostrarTodosProductosVenta()
    {
        $resultado = $this->modeloProductos->mostrarTodosProductosVenta();
        return $resultado;
    }

    public function actualizarStock($productos, $accionStock)
    {
        $resultado = $this->modeloProductos->actualizarStock($productos, $accionStock);
        return $resultado;
    }
}

?>