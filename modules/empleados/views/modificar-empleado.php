<!-- Modal -->
<?php
// $serviceUser = new ServiceUser($conexion);
// $rolesUsuarios = $serviceUser->listarRolesUsuarios();
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="containerForm col-md-6 col-sm-12">
            <h5 class="modal-title text-center">Modificar Empleado</h5>

            <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarModificarEmpleado" method="post"
                class="form ajax-form">
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="nombreEmpleado">Nombre del Empleado</label>
                        <input type="text" class="form-control" id="nombreEmpleado" placeholder="Nombre del Empleado..."
                            required name="nombreEmpleado" oncopy="return false" onpaste="return false"
                            onkeypress="return sololetras(event)" value="<?php echo $nombrePersona; ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="apellidoEmpleado">Apellido del Empleado</label>
                        <input type="text" class="form-control" id="apellidoEmpleado"
                            placeholder="Apellido del Empleado..." required name="apellidoEmpleado"
                            oncopy="return false" onpaste="return false" onkeypress="return sololetras(event)"
                            value="<?php echo $apellidoPersona; ?>">
                    </div>

                    <div class="form-group mb-2">
                        <label for="contactoEmpleado">Numero de contacto del Empleado</label>
                        <input type="text" class="form-control" id="contactoEmpleado" name="contactoEmpleado"
                            placeholder="Numero de contacto del Empleado" oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)" value="<?php echo $telefono; ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="IdRolUsuario" class="col-6">Rol del Empleado</label>
                        <select class="form-control col-6 w-100" id="IdRolUsuarioModificar" name="IdRolUsuarioModificar"
                            required>
                            <option value="" disabled selected>Selecciona un rol de usuario...</option>
                            <?php foreach ($roles as $rol): ?>
                                <?php if ($rol['id_rol_usuario'] == $idRol): ?>
                                    <option value="<?php echo $rol['id_rol_usuario']; ?>" selected>
                                        <?php echo $rol['rol']; ?>
                                    </option>
                                <?php else: ?>
                                    <option value="<?php echo $rol['id_rol_usuario']; ?>">
                                        <?php echo $rol['rol']; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="col-6 d-flex justify-content-center mb-2 mb-md-0">
                        <a href="/proyectoTienda/page/listarEmpleados/1" class="btn w-75">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Cancelar</button>
                        </a>
                    </div>
                    <input type="hidden" name="idEmpleado" value="<?php echo $id; ?>">
                    <input type="hidden" name="idPersona" value="<?php echo $idPersona; ?>">
                    <input type="hidden" name="idContacto" value="<?php echo $idContacto; ?>">
                    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
                    <div class="col-6 d-flex justify-content-center btn">
                        <button type="submit" class="btn btn-primary w-75" id="input-submit">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>