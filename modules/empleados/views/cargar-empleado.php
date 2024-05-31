<!-- Modal -->
<?php
$serviceUser = new ServiceUser($conexion);
$rolesUsuarios = $serviceUser->listarRolesUsuarios();
?>
<div class="modal fade" id="cargarEmpleado" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo Empleado</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="http://localhost/proyectoTienda/page/procesarCargarEmpleado" method="post"
                class="form ajax-form">
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="nombreEmpleado">Nombre del Empleado</label>
                        <input type="text" class="form-control" id="nombreEmpleado" placeholder="Nombre del Empleado..."
                            required name="nombreEmpleado" oncopy="return false" onpaste="return false"
                            onkeypress="return sololetras(event)">
                    </div>
                    <div class="form-group mb-4">
                        <label for="apellidoEmpleado">Apellido del Empleado</label>
                        <input type="text" class="form-control" id="apellidoEmpleado"
                            placeholder="Apellido del Empleado..." required name="apellidoEmpleado"
                            oncopy="return false" onpaste="return false" onkeypress="return sololetras(event)">
                    </div>

                    <div class="form-group mb-2">
                        <label for="contactoEmpleado">Numero de contacto del Empleado</label>
                        <input type="text" class="form-control" id="contactoEmpleado" name="contactoEmpleado"
                            placeholder="Numero de contacto del Empleado" oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)">
                    </div>
                    <div class="form-group mb-4">
                        <label for="IdRolUsuario" class="col-6">Rol del Empleado</label>
                        <select class="form-control col-12 w-100" id="IdRolUsuario" name="IdRolUsuario" required>
                            <option value="" disabled selected>Selecciona un rol de usuario...</option>
                            <?php foreach ($rolesUsuarios as $rol): ?>
                                <option value="<?php echo $rol['id_rol_usuario']; ?>">
                                    <?php echo $rol['rol']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="usuarioEmpleado">Nombre de Usuario del Empleado</label>
                        <input type="text" class="form-control" id="usuarioEmpleado"
                            placeholder="Usuario del Empleado..." required name="usuarioEmpleado" oncopy="return false"
                            onpaste="return false" onkeypress="return sololetras(event)">
                    </div>
                    <div class="form-group mb-4">
                        <label for="passwordEmpleado">Contraseña del Empleado</label>
                        <input type="password" class="form-control" id="passwordEmpleado"
                            placeholder="Contraseña del Empleado..." required name="passwordEmpleado"
                            oncopy="return false" onpaste="return false" onkeypress="return validaambos(event)">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="input-submit">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>