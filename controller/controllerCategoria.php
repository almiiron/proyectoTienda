<?php
require_once ('./model/classCategoria.php');

class ControllerCategoria
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function mostrarCargarCategoria()
    {
        require_once ('./views/layouts/header.php');
        require_once ('./views/cargar/cargar-categoria.php');
        require_once ('./views/layouts/footer.php');

    }
    public function procesarCargarCategoria($nombreCategoria)
    {
        // Este método es para cargar una nueva categoría.
        // Se instancia un nuevo objeto de la clase Categorias que es el modelo.
        $nuevaCategoria = new Categorias(null, $nombreCategoria);
        $id = "";
        $categoriaCargada = $nuevaCategoria->buscarCategoria($id, $nombreCategoria, $this->conexion);
        if ($categoriaCargada == False) {
            //significa que la categoria no existe en la bd
            $cargarCategoria = $nuevaCategoria->cargarCategoria($nombreCategoria, $this->conexion);
            if ($cargarCategoria) {
                //se cargó la categoria
                // Devuelve la respuesta como un JSON.
                $message = "Se cargó correctamente la categoria";
                header('Content-Type: application/json');
                echo json_encode(array('success' => $cargarCategoria, 'message' => $message));
            } else {
                $message = "Hubo un error al cargar la categoria";
                // Devuelve la respuesta como un JSON.
                header('Content-Type: application/json');
                echo json_encode(array('success' => $cargarCategoria, 'message' => $message));
            }
        } else {
            //significa La categoria cargada ya existe
            // Devuelve la respuesta como un JSON.
            $estado = False;
            $message = 'La categoria cargada ya existe.';
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));
        }
    }


    public function listarCategorias()
    {
        ///////////////////////////
        $categoria = new Categorias(null, null);
        $lista = $categoria->listarCategorias($this->conexion);
        if ($lista) {
            //si hay categorias para mostrar, ejecuta esto

            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_categoria']; // Agregar cada ID al array
            }

            // Ahora puedes pasar tanto la lista como los IDs a la vista
            $contenedor = "Categoria";
            $titulo = "Categoria";
            $limpiarFiltros = False;
            $tituloTabla = "Categorias";
            $encabezados = array("ID Categoria", "Nombre de la Categoria");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        } else {
            //si hay categorias para mostrar, ejecuta esto



            // Ahora puedes pasar tanto la lista como los IDs a la vista
            $contenedor = "Categoria";
            $titulo = "Categoria";
            $tituloTabla = "Categorias";
            $limpiarFiltros = False;
            $encabezados = array("ID Categoria", "Nombre de la Categoria");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        }
    }

    public function mostrarCategorias()
    {
        $categoria = new Categorias(null, null);
        $lista = $categoria->listarCategorias($this->conexion);
        if ($lista) {
            // Si hay categorías, devuelve la lista
            return $lista;
        } else {
            // Si no hay categorías, devuelve un array vacío
            return array();
        }
    }

    public function procesarCambiarEstadoCategoria($id, $estadoActual)
    {
        $categoria = new Categorias($id, null);
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }
        $cambiarEstadoCategoria = $categoria->cambiarEstadoCategoria($id, $nuevoEstado, $this->conexion);
        if ($cambiarEstadoCategoria) {
            //se eliminó la categoria
            // echo 'se eliminó';
            // Devuelve la respuesta como un JSON.
            $message = '¡La categoría se modificó correctamente!';
            header('Content-Type: application/json');
            echo json_encode(array('success' => $cambiarEstadoCategoria, 'message' => $message));
        } else {
            //se intentó eliminar pero hubo un error
            // Devuelve la respuesta como un JSON.
            $message = 'Hubo un error al intentar modificar la categoría.';
            header('Content-Type: application/json');
            echo json_encode(array('success' => $cambiarEstadoCategoria, 'message' => $message));
        }

    }

    public function mostrarModificarCategoria($id)
    {
        $nombreCategoria = "";
        $Categoria = new Categorias($id, $nombreCategoria);
        $buscarCategoria = $Categoria->listarUnaCategoria($id, $nombreCategoria, $this->conexion);
        require_once ('./views/layouts/header.php');
        require_once ('./views/modificar/modificar-categoria.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarModificarCategoria($id, $nombre_categoria)
    {
        $idVacio = ""; //para buscar si la categoria existe, si existe no modifico

        $Categoria = new Categorias($id, $nombre_categoria);
        $categoriaCargada = $Categoria->buscarCategoria($idVacio, $nombre_categoria, $this->conexion);
        if ($categoriaCargada == False) {
            $modificarCategoria = $Categoria->procesarModificarCategoria($id, $nombre_categoria, $this->conexion);
            if ($modificarCategoria) {
                $message = '¡La categoria se modificó con éxito!';
                header('Content-Type: application/json');
                echo json_encode(array('success' => $modificarCategoria, 'message' => $message));
            }
        } else {
            $estado = False;
            $message = '¡La categoria cargada ya existe!';
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));
        }
    }


    public function filtrarListarCategorias($filtro)
    {
        $categoria = new Categorias(null, null);

        // Preparar los filtros
        $where_clause = $categoria->prepararFiltrosCategorias($filtro);


        // Llamar al método listaFiltradaCategorias con los filtros y ordenamientos
        $lista = $categoria->listaFiltradaCategorias($where_clause, $this->conexion);

        if ($lista) {
            // Si hay categorías para mostrar, ejecuta esto

            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_categoria']; // Agregar cada ID al array
            }
            $estados = [];
            foreach ($lista as $fila) {
                $estados[] = $fila['estado'];
            }

            // Ahora puedes pasar tanto la lista como los IDs a la vista
            $contenedor = "Categoria";
            $titulo = "Categoria";
            $tituloTabla = "Categorias";
            $encabezados = array("ID Categoria", "Nombre de la Categoria");
            $limpiarFiltros = True;
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        } else {
            // Si no hay categorías para mostrar, ejecuta esto

            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_categoria']; // Agregar cada ID al array
            }

            // Ahora puedes pasar tanto la lista como los IDs a la vista
            $contenedor = "Categoria";
            $titulo = "Categoria";
            $tituloTabla = "Categorias";
            $limpiarFiltros = True;
            $encabezados = array("ID Categoria", "Nombre de la Categoria");
            require_once ('./views/layouts/header.php');
            require_once ('./views/listar/listar-table.php');
            require_once ('./views/layouts/footer.php');
        }
    }
}

?>