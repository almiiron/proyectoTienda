<?php
require_once ('./model/classProveedor.php');
require_once ('./model/classContacto.php');

class ControllerProveedor
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function mostrarCargarProveedor()
    {
        require_once ('./views/layouts/header.php');
        require_once ('./views/cargar/cargar-proveedor.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarCargarProveedor($nombreProveedor, $contactoProveedor)
    {

        $contacto = new Contactos(null, $contactoProveedor);
        $buscarContacto = $contacto->buscarContacto(null, $contactoProveedor, $this->conexion);

        if ($buscarContacto == False) {
            //el contacto cargado no existe, entonces se procede a cargar el contacto
            $cargarContacto = $contacto->cargarContacto($contactoProveedor, $this->conexion);

            if ($cargarContacto) {
                // si es que se cargó el contacto
                $idContacto = $contacto->ultimoIdContacto($this->conexion);
                $proveedor = new Proveedores(null, $idContacto, $nombreProveedor);
                $buscarProveedor = $proveedor->buscarProveedor(null, $nombreProveedor, $this->conexion);
                if ($buscarProveedor == False) {
                    // el nombre de proveedor cargado no existe en la bd
                    $cargarProveedor = $proveedor->cargarProveedor($idContacto, $nombreProveedor, $this->conexion);
                    if ($cargarProveedor) {
                        $estado = True;
                        $message = "¡El proveedor se cargó con éxito!";
                        header('Content-Type: application/json');
                        echo json_encode(array('success' => $cargarProveedor, 'message' => $message));
                    } else {
                        $estado = False;
                        $message = "¡Hubo un error al cargar el Proveedor!";
                        header('Content-Type: application/json');
                        echo json_encode(array('success' => $cargarProveedor, 'message' => $message));
                    }
                } else {
                    $estado = False;
                    $message = "¡El proveedor cargado ya existe!";
                    header('Content-Type: application/json');
                    echo json_encode(array('success' => $estado, 'message' => $message));
                }
            }

        } else {
            //el contacto cargado si existe
            $estado = False;
            $message = "¡El contacto cargado ya existe!";
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));
        }
    }

    public function listarProveedores($numPage, $paginationController)
    {
        ///////////////////////////
        $proveedor = new Proveedores(null, null, null);
        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://localhost/proyectoTienda/page/listarProveedores/1');
            //si en mi url el numPage es letra o numero menor a 0, entonces me redirecciona
        } else {
            $start = $numPage * $paginationController->size - $paginationController->size;
        }
        $innerJoin = " INNER JOIN contactos c ON c.id_contacto = p.id_contacto";
        $totalRows = $paginationController->getTotalRows('proveedores p' . $innerJoin, $this->conexion); // el total de filas para la paginación
        $pages = $paginationController->getTotalPages($totalRows, $paginationController->size); //la cantidad de paginas
        $lista = $proveedor->listarProveedores($start, $paginationController->size, $this->conexion);

        if ($lista) {   //si hay proveedores para mostrar, ejecuta esto
            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_proveedor']; // Agregar cada ID al array
            }
        }
        $contenedor = "Proveedor";
        $base_url = 'http://localhost/proyectoTienda/page/listarProveedores';
        $titulo = "Proveedor";
        $tituloTabla = "Proveedores";
        $mostrarBuscadorEnNavbar = true;
        $limpiarFiltros = False;
        $encabezados = array("ID Proveedor", "Nombre Proveedor", "Contacto");
        require_once ('./views/layouts/header.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');
    }

    public function mostrarProveedores()
    {
        $proveedor = new Proveedores(null, null, null);
        $lista = $proveedor->listarProveedores('0', '1000000', $this->conexion);
        if ($lista) {
            // Si hay proveedores, devuelve la lista
            return $lista;
        } else {
            // Si no hay proveedores, devuelve un array vacío
            return array();
        }
    }

    public function procesarCambiarEstadoProveedor($id, $estadoActual)
    {
        $proveedor = new Proveedores($id, null, null);
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }
        //si es falso es porque no hay productos asociados a ese proveedor
        $cambiarEstadoProveedor = $proveedor->cambiarEstadoProveedor($id, $nuevoEstado, $this->conexion);
        if ($cambiarEstadoProveedor) {
            //se eliminó correctamente el proveedor
            $estado = True;
            $message = "¡Se modificó correctamente el Proveedor!";
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));

        } else {
            $estado = False;
            $message = "¡Hubo un error al modificar el Proveedor!";
            header('Content-Type: application/json');
            echo json_encode(array('success' => $estado, 'message' => $message));
        }
    }

    public function mostrarModificarProveedor($id)
    {
        $proveedor = new Proveedores($id, null, null);
        $buscarProveedor = $proveedor->listarUnProveedor($id, $this->conexion);
        require_once ('./views/layouts/header.php');
        require_once ('./views/modificar/modificar-proveedor.php');
        require_once ('./views/layouts/footer.php');
    }

    public function procesarModificarProveedor($idProveedor, $idContacto, $nombreProveedor, $contactoProveedor)
    {

        // $estado = false; // Definición inicial de $estado
        // $message = ""; // Definición inicial de $message

        $proveedor = new Proveedores($idProveedor, $idContacto, $nombreProveedor);
        $contacto = new Contactos($idContacto, $contactoProveedor);
        $buscarContacto = $contacto->buscarContacto($idContacto, $contactoProveedor, $this->conexion);
        $buscarProveedor = $proveedor->buscarProveedor($idProveedor, $nombreProveedor, $this->conexion);

        if ($buscarContacto == True && $buscarProveedor == True) {
            //si ambas funciones devuelven true es porque existe en la bd:
            //un registro de contacto con el mismo id y telefono, 
            // y existe un registro de proveedor con el mismo id y nombre
            //significa que no se modificó ninguno
            //devuelvo solo un mensaje
            $estado = True;
            $message = "¡Se modificó correctamente el Proveedor!";
        } else if ($buscarContacto == False && $buscarProveedor == False) {
            //si ambas funciones devuelven False, significa que hubo cambios, eso porque:
            //no hay ningun registro que coincida con el mismo id y contacto en la tabla contactos
            //y tampoco hay ningun registro que coincida con el mismo id y nombre en la tabla proveedores

            //por lo que tengo que buscar en la bd algun registro que coincida con el mismo nombre de proveedor para no duplicar
            $busquedaProveedor = $proveedor->buscarProveedor(null, $nombreProveedor, $this->conexion);
            //si esa consulta devuelve un Truee, significa que ese nombre de Proveedor ya existe en la bd


            //significa que el contacto si se modificó desde el formulario, porque no encontró un registro en la bd con mismo id y mismo telefono
            //ahora tengo que buscar en la bd algun registro que coincida con ese telefono para no duplicar
            $busquedaContacto = $contacto->buscarContacto(null, $contactoProveedor, $this->conexion);
            //si esa consulta devuelve un Truee, significa que ese contacto ya existe en la bd

            if ($busquedaContacto == False && $busquedaProveedor == False) {
                //si ambas funciones son falsas, significa que no esta cargado ni el nombre ni el contacto, por lo que puedo modificar
                $modificarContacto = $contacto->modificarContacto($idContacto, $contactoProveedor, $this->conexion);
                $modificarProveedor = $proveedor->modificarProveedor($idProveedor, $nombreProveedor, $this->conexion);
                if ($modificarContacto == True && $modificarProveedor == True) {
                    //si ambas funciones son True, es que se modificó correctamente todo
                    $estado = True;
                    $message = "¡Se modificó correctamente los datos del Proveedor!";
                } else if ($modificarContacto == False) {
                    $estado = False;
                    $message = "¡Hubo un error al modificar el contacto del Proveedor!";
                } else if ($modificarProveedor == False) {
                    $estado = False;
                    $message = "¡Hubo un error al modificar el nombre del Proveedor!";
                }
            } else if ($busquedaContacto == True && $busquedaProveedor == True) {
                $estado = False;
                $message = "¡El nombre y contacto cargados ya existen!";
            } else if ($busquedaContacto == True) {
                $estado = False;
                $message = "¡El contacto cargado ya existe!";
            } else if ($busquedaProveedor == True) {
                $estado = False;
                $message = "¡El nombre de Proveedor cargado ya existe!";
            }

        } else if ($buscarContacto == False) {
            //solo hubo cambios en el contacto


            //significa que el contacto si se modificó desde el formulario, porque no encontró un registro en la bd con mismo id y mismo telefono
            //ahora tengo que buscar en la bd algun registro que coincida con ese telefono para no duplicar
            $busquedaSoloContacto = $contacto->buscarContacto(null, $contactoProveedor, $this->conexion);
            if ($busquedaSoloContacto == False) {
                //si devuelve False es porque no encontró ningun registro en la bd que tenga ese mismo contacto
                $modificarSoloContacto = $contacto->modificarContacto($idContacto, $contactoProveedor, $this->conexion);
                if ($modificarSoloContacto) {
                    $estado = True;
                    $message = "¡Se modificó correctamente el contacto del Proveedor!";
                }
            } else {
                $estado = False;
                $message = "¡El contacto del proveedor ya fue cargado!";
            }

        } else if ($buscarProveedor == False) {
            //solo hubo cambios en el nombre


            //si devuelve false, es porque si se modificó el nombre del proveedor dsede el formulario, porque no encontró ningun registro con el mismo id y mismo nombre
            //por lo que tengo que buscar en la bd algun registro que coincida con el mismo nombre de proveedor
            $busquedaSoloProveedor = $proveedor->buscarProveedor(null, $nombreProveedor, $this->conexion);
            //si esa consulta devuelve un Truee, significa que ese nombre de Proveedor ya existe en la bd
            if ($busquedaSoloProveedor == False) {
                //si es False tengo que modificar el proveedor
                $modificarSoloProveedor = $proveedor->modificarProveedor($idProveedor, $nombreProveedor, $this->conexion);
                if ($modificarSoloProveedor) {
                    //si devuelve True, es porque se modificó correctamente el nombre del proveedor
                    //si llego hasta aca, significa que no se modificó el contacto pero si el nombre del proveedor, por lo que tuve que hacer una consulta sql...
                    //que devolvió True porque se hizo correctamente la modificación del nombre del proveedor
                    $estado = True;
                    $message = "¡Se modificó correctamente el nombre del Proveedor!";
                } else {
                    $estado = False;
                    $message = "¡Hubo un error al modificar el Proveedor!";
                }
            } else {
                $estado = False;
                $message = "¡El nombre de proveedor ya fue cargado!";
            }

        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////


        // Respuesta JSON
        header('Content-Type: application/json');
        echo json_encode(array('success' => $estado, 'message' => $message));
    }



    public function filtrarListarProveedores($filtro, $numPage, $paginationController)
    {
        $proveedor = new Proveedores(null, null, null);
        if ($numPage == "" || $numPage <= 0) {
            $start = 0;
            header('location:http://localhost/proyectoTienda/page/filtrarListarProveedores/1');
        } else {
            $start = $numPage * $paginationController->size - $paginationController->size;
        }
        $where_clause = $proveedor->prepararFiltrosProveedores($filtro);
        $where_clause_Pagination = " INNER JOIN contactos c ON c.id_contacto = p.id_contacto " . $where_clause;
        $totalRows = $paginationController->getTotalRows('proveedores p', $this->conexion, $where_clause_Pagination); //obtengo el total de filas con el filtro para paginar
        $pages = $paginationController->getTotalPages($totalRows, $paginationController->size); //obtengo el numero total de paginas

        // Llamar al método listaFiltradaCategorias con los filtros y ordenamientos
        $lista = $proveedor->listaFiltradaProveedores($where_clause, $start, $paginationController->size, $this->conexion);

        if ($lista) {
            // Si hay proveedores para mostrar, ejecuta esto
            $ids = []; // Inicializar un array para almacenar los IDs
            foreach ($lista as $fila) {
                $ids[] = $fila['id_proveedor']; // Agregar cada ID al array
            }
        }
        // Si no hay proveedores para mostrar, ejecuta esto

        // Ahora puedes pasar tanto la lista como los IDs a la vista
        $contenedor = "Proveedor";
        $titulo = "Proveedor";
        $base_url = 'http://localhost/proyectoTienda/page/filtrarListarProveedores';
        $tituloTabla = "Proveedores";
        $mostrarBuscadorEnNavbar = true;
        $limpiarFiltros = True;
        $encabezados = array("ID Proveedor", "Nombre Proveedor", "Contacto");
        require_once ('./views/layouts/header.php');
        require_once ('./views/listar/listar-table.php');
        require_once ('./views/layouts/footer.php');

    }
}
?>