<?php
require_once ('./modules/clientes/model/classCliente.php');
// require_once ('./modules/clienteservices/serviceCliente.php');
require_once ('./modules/personas/service/servicePersona.php');
require_once ('./modules/contactos/service/serviceContacto.php');
class ServiceCliente
{
    private $conexion;
    private $modeloCliente;
    private $paginationController;
    private $servicePersona;
    private $serviceContacto;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->modeloCliente = new Clientes($this->conexion);
        $this->paginationController = new ControllerPagination($this->conexion, 30);
        $this->servicePersona = new ServicePersona($this->conexion);
        $this->serviceContacto = new ServiceContacto($this->conexion);
    }

    public function listarClientes($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = " INNER JOIN personas p ON p.id_persona = cl.id_persona INNER JOIN contactos co ON co.id_contacto = p.id_contacto ";

        $totalRows = $this->paginationController->getTotalRows('clientes cl' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas
        $lista = $this->modeloCliente->listarClientes($start, $this->paginationController->size); //los datos a mostrar

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay categorias para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_cliente']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function cargarCliente($nombreCliente, $apellidoCliente, $telefonoCliente)
    {
        $buscarPersona = $this->servicePersona->buscarPersona(null, $nombreCliente, $apellidoCliente);
        $buscarContacto = $this->serviceContacto->buscarContacto(null, $telefonoCliente);

        if ($buscarPersona && $buscarContacto) {
            $estado = False;
            $message = '¡La persona y contacto ya existen!';
            return ['success' => $estado, 'message' => $message];
        }

        if ($buscarPersona) {
            $estado = False;
            $message = '¡La persona ya existe!';
            return ['success' => $estado, 'message' => $message];
        }
        if ($buscarContacto) {
            $estado = False;
            $message = '¡El contacto ya existe!';
            return ['success' => $estado, 'message' => $message];
        }

        $cargarContacto = $this->serviceContacto->cargarContacto($telefonoCliente);
        if ($cargarContacto) {
            $idContacto = $this->serviceContacto->ultimoIdContacto();
            $cargarPersona = $this->servicePersona->cargarPersona($idContacto, $nombreCliente, $apellidoCliente);
            if ($cargarPersona) {
                $idPersona = $this->servicePersona->ultimoIdPersona();
                $cargarCliente = $this->modeloCliente->cargarCliente($idPersona);
                if ($cargarCliente) {
                    $estado = True;
                    $message = '¡Se cargó correctamente el cliente!';
                    return ['success' => $estado, 'message' => $message];
                } else {
                    $estado = False;
                    $message = '¡Hubo un error al cargar el cliente!';
                    return ['success' => $estado, 'message' => $message];
                }
            } else {
                $estado = False;
                $message = '¡Hubo un error al cargar la persona!';
                return ['success' => $estado, 'message' => $message];
            }
        } else {
            $estado = False;
            $message = '¡Hubo un error al cargar el contacto!';
            return ['success' => $estado, 'message' => $message];
        }
    }

    public function cambiarEstadoCliente($id, $estadoActual)
    {
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = 'Inactivo';
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = 'Activo';
        }
        $cliente = $this->modeloCliente->obtenerDatosSimplesCliente($id);
        $idPersona = $cliente['id_persona'];

        $persona = $this->servicePersona->obtenerDatosSimplePersona($idPersona);
        $idContacto = $persona['id_contacto'];
        $cambiarEstadoContacto = $this->serviceContacto->cambiarEstadoContacto($idContacto, $nuevoEstado);
        $cambiarEstadoPersona = $this->servicePersona->cambiarEstadoPersona($idPersona, $nuevoEstado);
        $cambiarEstadoCliente = $this->modeloCliente->cambiarEstadoCliente($id, $nuevoEstado);

        if ($cambiarEstadoContacto && $cambiarEstadoPersona && $cambiarEstadoCliente) {
            $estado = True;
            $message = '¡Se modificó correctamente el cliente!';
        } else {
            $estado = False;
            $message = '¡Hubo un error al modificar el cliente!';
        }
        return ['success' => $estado, 'message' => $message];
    }

    public function mostrarModificarCliente($id)
    {
        $cliente = $this->modeloCliente->obtenerDatosSimplesCliente($id); //obtengo los datos del contacto (id_cliente, id_persona, estado)
        $idPersona = $cliente['id_persona']; // guardo el id_persona
        $persona = $this->servicePersona->obtenerDatosSimplePersona($idPersona); //busco la peronsa y sus datos
        $nombrePersona = $persona['nombre'];
        $apellidoPersona = $persona['apellido'];
        //----------//
        $idContacto = $persona['id_contacto'];
        $contacto = $this->serviceContacto->obtenerDatosSimpleContacto($idContacto);
        $telefono = $contacto['telefono'];

        return [$idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono];
    }

    public function procesarModificarCliente($idCliente, $idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono)
    {
        $buscarPersona = $this->servicePersona->buscarPersona($idPersona, $nombrePersona, $apellidoPersona);
        $buscarContacto = $this->serviceContacto->buscarContacto($idContacto, $telefono);
        if ($buscarPersona && $buscarContacto) {
            //significa que no se modificó nada, porque SI existe un registro de persona con mismo id_persona, nombre y apellido
            //y tambien un registro de contacto con mismo id_contacto y telefono
            $estado = True;
            $message = '¡El cliente se modificó correctamente!';
            return ['success' => $estado, 'message' => $message];
        }

        if (!$buscarPersona && !$buscarContacto) {
            //significa que ambos se modificó porque NO existe un registro de persona con mismo id_persona, nombre y apellido
            //y tampoco un registro de contacto con mismo id_contacto y telefono 
            $buscarPersona = $this->servicePersona->buscarPersona(null, $nombrePersona, $apellidoPersona);
            $buscarContacto = $this->serviceContacto->buscarContacto(null, $telefono);
            if (!$buscarPersona && !$buscarContacto) {
                //significa que en la bd no existen registros identicos a los enviados desde el formulario
                $modificarPersona = $this->servicePersona->modificarPersona($idPersona, $nombrePersona, $apellidoPersona);
                $modificarContacto = $this->serviceContacto->modificarContacto($idContacto, $telefono);
                if ($modificarPersona && $modificarContacto) {
                    $estado = True;
                    $message = '¡El cliente se modificó correctamente!';
                    return ['success' => $estado, 'message' => $message];

                }
                if (!$modificarPersona) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el nombre y apellido del Cliente!';
                    return ['success' => $estado, 'message' => $message];
                }
                if (!$modificarContacto) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el contacto del Cliente!';
                    return ['success' => $estado, 'message' => $message];
                }
            }

            if ($buscarPersona) {
                //se modificó nombre y apellido desde el formulario, pero en la bd existe un registro igual, entonces no modifico para no duplicar y muestro mensaje
                $estado = False;
                $message = '¡La persona ya existe!';
                return ['success' => $estado, 'message' => $message];
            }
            if ($buscarContacto) {
                //se modificó telefono desde el formulario, pero en la bd existe un registro igual, entonces no modifico para no duplicar y muestro mensaje
                $estado = False;
                $message = '¡El contacto ya existe!';
                return ['success' => $estado, 'message' => $message];
            }
        }

        if (!$buscarPersona) {
            //se modificó solo nombre y apellido
            $buscarPersona = $this->servicePersona->buscarPersona(null, $nombrePersona, $apellidoPersona);
            if (!$buscarPersona) {
                //significa que en la bd no existen registros identicos a los enviados desde el formulario
                $modificarPersona = $this->servicePersona->modificarPersona($idPersona, $nombrePersona, $apellidoPersona);
                if ($modificarPersona) {
                    $estado = True;
                    $message = '¡El nombre y/o apellido del cliente se modificó correctamente!';
                    return ['success' => $estado, 'message' => $message];

                }
                if (!$modificarPersona) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el nombre y apellido del Cliente!';
                    return ['success' => $estado, 'message' => $message];
                }
            }

            if ($buscarPersona) {
                //se modificó nombre y apellido desde el formulario, pero en la bd existe un registro igual, entonces no modifico para no duplicar y muestro mensaje
                $estado = False;
                $message = '¡La persona ya existe!';
                return ['success' => $estado, 'message' => $message];
            }
        }
        if (!$buscarContacto) {
            //se modificó solo telefono
            $buscarContacto = $this->serviceContacto->buscarContacto(null, $telefono);
            if (!$buscarContacto) {
                //significa que en la bd no existen registros identicos a los enviados desde el formulario

                $modificarContacto = $this->serviceContacto->modificarContacto($idContacto, $telefono);
                if ($modificarContacto) {
                    $estado = True;
                    $message = '¡El telefono del cliente se modificó correctamente!';
                    return ['success' => $estado, 'message' => $message];

                }
                if (!$modificarContacto) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el contacto del Cliente!';
                    return ['success' => $estado, 'message' => $message];
                }
            }
            if ($buscarContacto) {
                //se modificó telefono desde el formulario, pero en la bd existe un registro igual, entonces no modifico para no duplicar y muestro mensaje
                $estado = False;
                $message = '¡El contacto ya existe!';
                return ['success' => $estado, 'message' => $message];
            }
        }
    }

    public function filtrarListarClientes($filtro, $numPage)
    {

        $start = $numPage * $this->paginationController->size - $this->paginationController->size;
        $where_clause = $this->modeloCliente->prepararFiltrosCliente($filtro);
        $where_clause_Pagination = "  INNER JOIN personas p ON p.id_persona = cl.id_persona INNER JOIN contactos co ON co.id_contacto = p.id_contacto  " . $where_clause;
        $totalRows = $this->paginationController->getTotalRows('clientes cl', $where_clause_Pagination); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas

        // Llamar al método listaFiltradaCategorias con los filtros y ordenamientos
        $lista = $this->modeloCliente->listaFiltradaClientes($where_clause, $start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) {
            // Si hay proveedores para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_cliente']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }

    public function mostrarTodosClientes()
    {
        $mostrarTodosClientes = $this->modeloCliente->mostrarTodosClientes();
        return $mostrarTodosClientes;
    }
}



?>