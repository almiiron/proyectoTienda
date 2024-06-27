<?php
require_once ('./modules/empleados/model/classEmpleado.php');
require_once ('./modules/pagination/controller/controllerPagination.php');
require_once ('./modules/personas/service/servicePersona.php');
require_once ('./modules/contactos/service/serviceContacto.php');
require_once ('./modules/users/service/serviceUser.php');
require_once './modules/notificaciones/service/serviceNotificaciones.php';

class ServiceEmpleado
{
    private $modeloEmpleado;
    private $paginationController;
    private $servicePersona;
    private $serviceContacto;
    private $serviceUser;
    private $serviceNotificaciones;

    public function __construct($conexion)
    {
        $this->modeloEmpleado = new Empleado($conexion);
        $this->paginationController = new controllerPagination($conexion, 30);
        $this->servicePersona = new ServicePersona($conexion);
        $this->serviceContacto = new ServiceContacto($conexion);
        $this->serviceUser = new ServiceUser($conexion);
        $this->serviceNotificaciones = new ServiceNotificaciones($conexion);

    }

    public function listarEmpleados($numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;

        $innerJoin = " INNER JOIN personas pe ON pe.id_persona = em.id_persona 
        INNER JOIN usuarios us ON em.id_usuario = us.id_usuario
        INNER JOIN contactos c ON c.id_contacto = pe.id_contacto ";
        $totalRows = $this->paginationController->getTotalRows('empleados em' . $innerJoin); // el total de filas para la paginación
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //la cantidad de paginas

        $lista = $this->modeloEmpleado->listarEmpleados($start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) { //si hay productos para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_empleado']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }
    public function cargarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $usuarioEmpleado, $passwordEmpleado)
    {
        $buscarPersona = $this->servicePersona->buscarPersona(null, $nombreEmpleado, $apellidoEmpleado);
        $buscarContacto = $this->serviceContacto->buscarContacto(null, $contactoEmpleado);
        $buscarUser = $this->serviceUser->buscarUser(null, null, $usuarioEmpleado, null);

        if ($buscarPersona && $buscarContacto && $buscarUser) {
            $estado = False;
            $message = '¡La persona, contacto y nombre de usuario ya existen!';
            return ['success' => $estado, 'message' => $message];
        } elseif ($buscarPersona && $buscarContacto) {
            $estado = False;
            $message = '¡La persona y contacto ya existen!';
            return ['success' => $estado, 'message' => $message];
        } elseif ($buscarPersona && $buscarUser) {
            $estado = False;
            $message = '¡La persona y nombre de usuario ya existen!';
            return ['success' => $estado, 'message' => $message];
        } elseif ($buscarContacto && $buscarUser) {
            $estado = False;
            $message = '¡El contacto y nombre de usuario ya existen!';
            return ['success' => $estado, 'message' => $message];
        } elseif ($buscarPersona) {
            $estado = False;
            $message = '¡La persona ya existe!';
            return ['success' => $estado, 'message' => $message];
        } elseif ($buscarContacto) {
            $estado = False;
            $message = '¡El contacto ya existe!';
            return ['success' => $estado, 'message' => $message];
        } elseif ($buscarUser) {
            $estado = False;
            $message = '¡El nombre de usuario ya existe!';
            return ['success' => $estado, 'message' => $message];
        }

        // ¡puedo cargar el empleado!
        $cargarContacto = $this->serviceContacto->cargarContacto($contactoEmpleado); //carga el contacto
        $idContacto = $this->serviceContacto->ultimoIdContacto(); //obtengo el id del contaacto recien cargado
        $cargarPersona = $this->servicePersona->cargarPersona($idContacto, $nombreEmpleado, $apellidoEmpleado); //cargo la persona
        $cargarUsuario = $this->serviceUser->cargarUser($idRol, $usuarioEmpleado, $passwordEmpleado); //cargo el usuario
        if (!$cargarContacto || !$cargarPersona || !$cargarUsuario) {
            $estado = False;
            $message = "¡Hubo un error al cargar el contacto, la persona o el usuario!";
            return ['success' => $estado, 'message' => $message];
        }
        $idPersona = $this->servicePersona->ultimoIdPersona();
        $idUsuario = $this->serviceUser->ultimoIdUser();
        $cargarEmpleado = $this->modeloEmpleado->cargarEmpleado($idPersona, $idUsuario);
        if ($cargarEmpleado) {
            $estado = True;
            $message = "¡El empleado fue cargado correctamente!";
            $mensajeNotificacion = 'Se cargó correctamente el empleado: ' . $nombreEmpleado . ' ' . $apellidoEmpleado;
            $tipoNotificacion = 'Información';
        } else {
            $estado = False;
            $message = "¡Hubo un error al cargar el empleado!";
            $mensajeNotificacion = 'Hubo un error al cargar el empleado: ' . $apellidoEmpleado . ' ' . $apellidoEmpleado;
            $tipoNotificacion = 'Error';
        }
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
        return ['success' => $estado, 'message' => $message];
    }

    public function cambiarEstadoEmpleado($id, $estadoActual)
    {
        $nuevoEstado = "";
        if ($estadoActual == 'Activo') {
            $nuevoEstado = 'Inactivo';
        } else if ($estadoActual == 'Inactivo') {
            $nuevoEstado = 'Activo';
        }

        $empleado = $this->modeloEmpleado->obtenerDatosSimplesEmpleado($id); //obtengo los datos del empleado
        $idEmpleado = $empleado['id_empleado']; //obtengo el id_persona del empleado
        $idPersona = $empleado['id_persona']; //obtengo el id_persona del empleado
        $idUsuario = $empleado['id_usuario']; //obtengo el id_usuario del empleado

        $persona = $this->servicePersona->obtenerDatosSimplePersona($idPersona);
        $idContacto = $persona['id_contacto'];

        $cambiarEstadoContacto = $this->serviceContacto->cambiarEstadoContacto($idContacto, $nuevoEstado);
        $cambiarEstadoPersona = $this->servicePersona->cambiarEstadoPersona($idPersona, $nuevoEstado);
        $cambiarEstadoUsuario = $this->serviceUser->cambiarEstadoUser($idUsuario, $nuevoEstado);
        $cambiarEstadoEmpleado = $this->modeloEmpleado->cambiarEstadoEmpleado($id, $nuevoEstado);

        if (!$cambiarEstadoContacto || !$cambiarEstadoPersona || !$cambiarEstadoUsuario || !$cambiarEstadoEmpleado) {
            $estado = False;
            $message = "¡Hubo un error al modificar el empleado!";
            $mensajeNotificacion = 'Hubo un error al modificar el empleado: ' . $persona['nombre'] . ' ' . $persona['apellido'];
            $mensajeNotificacion .= ', de ' . $estadoActual . ' a ' . $nuevoEstado;
            $tipoNotificacion = 'Error';
        }
        $estado = True;
        $message = "¡Se modificó correctamente el empleado!";
        $mensajeNotificacion = 'Se modificó correctamente el empleado: ' . $persona['nombre'] . ' ' . $persona['apellido'];
        $mensajeNotificacion .= ', de ' . $estadoActual . ' a ' . $nuevoEstado;
        $tipoNotificacion = 'Información';
        $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);

        return ['success' => $estado, 'message' => $message];
    }

    public function filtrarListarEmpleados($filtro, $numPage)
    {
        $start = $numPage * $this->paginationController->size - $this->paginationController->size;


        $where_clause = $this->modeloEmpleado->prepararFiltrosEmpleados($filtro);
        $where_clause_Pagination = " INNER JOIN personas pe ON pe.id_persona = em.id_persona 
        INNER JOIN usuarios us ON em.id_usuario = us.id_usuario
        INNER JOIN contactos c ON c.id_contacto = pe.id_contacto " . $where_clause;
        $totalRows = $this->paginationController->getTotalRows('empleados em', $where_clause_Pagination); //obtengo el total de filas con el filtro para paginar
        $pages = $this->paginationController->getTotalPages($totalRows, $this->paginationController->size); //obtengo el numero total de paginas
        $lista = $this->modeloEmpleado->listaFiltradaEmpleados($where_clause, $start, $this->paginationController->size);

        $ids = []; // Inicializar un array para almacenar los IDs
        if ($lista) {   //si hay Empleados para mostrar, ejecuta esto
            foreach ($lista as $fila) {
                $ids[] = $fila['id_empleado']; // Agregar cada ID al array
            }
        }
        return [$lista, $pages, $ids];
    }
    public function mostrarModificarEmpleado($id)
    {
        $empleado = $this->modeloEmpleado->obtenerDatosSimplesEmpleado($id); //obtengo los datos del contacto (id_cliente, id_persona, estado)
        $idUsuario = $empleado['id_usuario'];
        $usuarioEmpleado = $this->serviceUser->obtenerDatosSimpleUser($idUsuario);
        $idRol = $usuarioEmpleado['id_rol_usuario'];
        $idPersona = $empleado['id_persona']; // guardo el id_persona
        $persona = $this->servicePersona->obtenerDatosSimplePersona($idPersona); //busco la peronsa y sus datos
        $nombrePersona = $persona['nombre'];
        $apellidoPersona = $persona['apellido'];
        //----------//
        $idContacto = $persona['id_contacto'];
        $contacto = $this->serviceContacto->obtenerDatosSimpleContacto($idContacto);
        $telefono = $contacto['telefono'];
        $roles = $this->serviceUser->listarRolesUsuarios();
        return [$idPersona, $nombrePersona, $apellidoPersona, $idContacto, $telefono, $roles, $idUsuario, $idRol];
    }

    public function procesarModificarEmpleado($nombreEmpleado, $apellidoEmpleado, $contactoEmpleado, $idRol, $idEmpleado, $idPersona, $idContacto, $idUsuario)
    {
        $buscarPersona = $this->servicePersona->buscarPersona($idPersona, $nombreEmpleado, $apellidoEmpleado);
        $buscarContacto = $this->serviceContacto->buscarContacto($idContacto, $contactoEmpleado);
        $buscarRolUser = $this->serviceUser->buscarUser($idUsuario, $idRol, null, null);
        if ($buscarPersona && $buscarContacto && $buscarRolUser) {
            //significa que no se modificó nada, porque SI existe un registro de persona con mismo id_persona, nombre y apellido
            //y tambien un registro de contacto con mismo id_contacto y telefono
            $estado = True;
            $message = '¡El empleado se modificó correctamente!';
            return ['success' => $estado, 'message' => $message];
        }

        if (!$buscarPersona && !$buscarContacto && !$buscarRolUser) {
            //significa que ambos se modificó porque NO existe un registro de persona con mismo id_persona, nombre y apellido
            //y tampoco un registro de contacto con mismo id_contacto y telefono
            $buscarPersona = $this->servicePersona->buscarPersona(null, $nombreEmpleado, $apellidoEmpleado);
            $buscarContacto = $this->serviceContacto->buscarContacto(null, $contactoEmpleado);
            if (!$buscarPersona && !$buscarContacto) {
                //significa que en la bd no existen registros identicos a los enviados desde el formulario
                $modificarPersona = $this->servicePersona->modificarPersona($idPersona, $nombreEmpleado, $apellidoEmpleado);
                $modificarContacto = $this->serviceContacto->modificarContacto($idContacto, $contactoEmpleado);
                $modificarRol = $this->serviceUser->modificarRolUser($idUsuario, $idRol);
                if ($modificarPersona && $modificarContacto && $modificarRol) {
                    $estado = True;
                    $message = 'Se modificó correctamente el empleado!';
                    $mensajeNotificacion = 'Se modificó correctamente el empleado de ID ' . $idEmpleado;
                    $tipoNotificacion = 'Error';
                    $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
                    return ['success' => $estado, 'message' => $message];
                } else {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el empleado!';
                    $mensajeNotificacion = 'Hubo un error al modificar el empleado de ID ' . $idEmpleado;
                    $tipoNotificacion = 'Error';
                    $this->serviceNotificaciones->cargarNotificacion($mensajeNotificacion, $tipoNotificacion);
                    return ['success' => $estado, 'message' => $message];
                }
                if (!$modificarPersona) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el nombre y apellido del empleado!';
                    return ['success' => $estado, 'message' => $message];
                }
                if (!$modificarContacto) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el contacto del empleado!';
                    return ['success' => $estado, 'message' => $message];
                }
                if (!$modificarRol) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el rol del empleado!';
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
                //se modificó telefonodesde el formulario, pero en la bd existe un registro igual, entonces no modifico para no duplicar y muestro mensaje
                $estado = False;
                $message = '¡El contacto ya existe!';
                return ['success' => $estado, 'message' => $message];
            }
        }

        if (!$buscarPersona) {
            //se modificó solo nombre y apellido
            $buscarPersona = $this->servicePersona->buscarPersona(null, $nombreEmpleado, $apellidoEmpleado);
            if (!$buscarPersona) {
                //significa que en la bd no existen registros identicos a los enviados desde el formulario
                $modificarPersona = $this->servicePersona->modificarPersona($idPersona, $nombreEmpleado, $apellidoEmpleado);
                if ($modificarPersona) {
                    $estado = True;
                    $message = '¡El nombre y/o apellido del empleado se modificó correctamente!';
                    return ['success' => $estado, 'message' => $message];

                }
                if (!$modificarPersona) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el nombre y apellido del empleado!';
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
            //se modificó solo conta$contactoEmpleado
            $buscarContacto = $this->serviceContacto->buscarContacto(null, $contactoEmpleado);
            if (!$buscarContacto) {
                //significa que en la bd no existen registros identicos a los enviados desde el formulario

                $modificarContacto = $this->serviceContacto->modificarContacto($idContacto, $contactoEmpleado);
                if ($modificarContacto) {
                    $estado = True;
                    $message = '¡El telefono del empleado se modificó correctamente!';
                    return ['success' => $estado, 'message' => $message];

                }
                if (!$modificarContacto) {
                    $estado = False;
                    $message = '¡Hubo un error al modificar el contacto del empleado!';
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
        if (!$buscarRolUser) {
            $modificarRol = $this->serviceUser->modificarRolUser($idUsuario, $idRol);
            if ($modificarRol) {
                $estado = True;
                $message = '¡El rol del empleado se modificó correctamente!';
                return ['success' => $estado, 'message' => $message];
            }
        }
    }

    public function mostrarTodosEmpleados()
    {
        $resultado = $this->modeloEmpleado->mostrarTodosEmpleados();
        return $resultado;
    }
}
?>