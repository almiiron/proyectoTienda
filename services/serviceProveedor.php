<?php
require_once ('./models/classProveedor.php');
require_once ('./services/serviceContacto.php');
class ServiceProveedor
{
    private $conexion;
    private $serviceContacto;
    private $modeloProveedores;
    private $paginationController;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->serviceContacto = new serviceContacto($this->conexion);
        $this->modeloProveedores = new Proveedores($this->conexion);
        $this->paginationController = new ControllerPagination($this->conexion, 30);
    }

    public function cargarProveedor($nombreProveedor, $contactoProveedor)
    {
        $buscarProveedor = $this->modeloProveedores->buscarProveedor(null, $nombreProveedor);
        $buscarContacto = $this->serviceContacto->buscarContacto(null, $contactoProveedor);

        if ($buscarProveedor && $buscarContacto) {
            //el proveedor y contacto ya existen
            $estado = False;
            $message = "¡El proveedor y contacto ya existen!";
            return ['success' => $estado, 'message' => $message];
        }

        if ($buscarProveedor) {
            //el proveedor ya existe
            $estado = False;
            $message = "¡El proveedor ya existe!";
            return ['success' => $estado, 'message' => $message];
        }

        if ($buscarContacto) {
            //el contacto ya existe
            $estado = False;
            $message = "¡El contacto ya existe!";
            return ['success' => $estado, 'message' => $message];
        }

        $cargarContacto = $this->serviceContacto->cargarContacto($contactoProveedor);

        if ($cargarContacto) {  // si es que se cargó el contacto
            $idContacto = $this->serviceContacto->ultimoIdContacto();
            $cargarProveedor = $this->modeloProveedores->cargarProveedor($idContacto, $nombreProveedor);
            if ($cargarProveedor) {
                $estado = True;
                $message = "¡El proveedor se cargó con éxito!";
            } else {
                $estado = False;
                $message = "¡Hubo un error al cargar el Proveedor!";
            }
            return ['success' => $estado, 'message' => $message];
        } else {
            $estado = False;
            $message = "¡Hubo un error al cargar el Contacto!";
            return ['success' => $estado, 'message' => $message];
        }
    }

    public function mostrarProveedores()
    {
        $lista = $this->modeloProveedores->mostrarProveedores();
        if ($lista) {
            // Si hay proveedores, devuelve la lista
            return $lista;
        } else {
            // Si no hay proveedores, devuelve un array vacío
            return array();
        }
    }

    public function cambiarEstadoProveedor($id, $estadoActual)
    {
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = "Inactivo";
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = "Activo";
        }

        $cambiarEstadoProveedor = $this->modeloProveedores->cambiarEstadoProveedor($id, $nuevoEstado);
        if ($cambiarEstadoProveedor) {
            $estado = True;
            $message = "¡Se modificó correctamente el Proveedor!";
        } else {
            $estado = False;
            $message = "¡Hubo un error al modificar el Proveedor!";
        }
        return ['success' => $estado, 'message' => $message];
    }

    public function modificarProveedor($idProveedor, $idContacto, $nombreProveedor, $contactoProveedor)
    {

        $buscarContacto = $this->serviceContacto->buscarContacto($idContacto, $contactoProveedor);
        $buscarProveedor = $this->modeloProveedores->buscarProveedor($idProveedor, $nombreProveedor);

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
            $busquedaProveedor = $this->modeloProveedores->buscarProveedor(null, $nombreProveedor);
            //si esa consulta devuelve un Truee, significa que ese nombre de Proveedor ya existe en la bd


            //significa que el contacto si se modificó desde el formulario, porque no encontró un registro en la bd con mismo id y mismo telefono
            //ahora tengo que buscar en la bd algun registro que coincida con ese telefono para no duplicar
            $busquedaContacto = $this->serviceContacto->buscarContacto(null, $contactoProveedor);
            //si esa consulta devuelve un Truee, significa que ese contacto ya existe en la bd

            if ($busquedaContacto == False && $busquedaProveedor == False) {
                //si ambas funciones son falsas, significa que no esta cargado ni el nombre ni el contacto, por lo que puedo modificar
                $modificarContacto = $this->serviceContacto->modificarContacto($idContacto, $contactoProveedor);
                $modificarProveedor = $this->modeloProveedores->modificarProveedor($idProveedor, $nombreProveedor);
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
            $busquedaSoloContacto = $this->serviceContacto->buscarContacto(null, $contactoProveedor);
            if ($busquedaSoloContacto == False) {
                //si devuelve False es porque no encontró ningun registro en la bd que tenga ese mismo contacto
                $modificarSoloContacto = $this->serviceContacto->modificarContacto($idContacto, $contactoProveedor);
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
            $busquedaSoloProveedor = $this->modeloProveedores->buscarProveedor(null, $nombreProveedor);
            //si esa consulta devuelve un Truee, significa que ese nombre de Proveedor ya existe en la bd
            if ($busquedaSoloProveedor == False) {
                //si es False tengo que modificar el proveedor
                $modificarSoloProveedor = $this->modeloProveedores->modificarProveedor($idProveedor, $nombreProveedor);
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
        return ['success' => $estado, 'message' => $message];
    }

    public function listarProveedores($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;
        $innerJoin = " INNER JOIN contactos c ON c.id_contacto = p.id_contacto";
        $totalRows = $this->paginationController->getTotalRows('proveedores p' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modeloProveedores->listarProveedores($start, $this->paginationController->size);
        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) {   //si hay proveedores para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_proveedor']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function filtrarListarProveedores($filtro, $numPage)
    {

        $start = $numPage * $this->paginationController->size - $this->paginationController->size;
        $where_clause = $this->modeloProveedores->prepararFiltrosProveedores($filtro);
        $where_clause_Pagination = " INNER JOIN contactos c ON c.id_contacto = p.id_contacto " . $where_clause;
        $totalRows = $this->paginationController->getTotalRows('proveedores p', $where_clause_Pagination); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas

        // Llamar al método listaFiltradaCategorias con los filtros y ordenamientos
        $lista = $this->modeloProveedores->listaFiltradaProveedores($where_clause, $start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) {
            // Si hay proveedores para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_proveedor']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function listarUnProveedor($id)
    {
        $proveedor = $this->modeloProveedores->listarUnProveedor($id);
        return $proveedor;
    }
}
?>