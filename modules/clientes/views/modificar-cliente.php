
<div class="container my-4">
        <div class="row justify-content-center">
            <div class="containerForm col-md-6 col-sm-12">
                <h5 class="modal-title text-center">Modificar Cliente</h5>
                <form action="http://<?php echo IP_HOST; ?>/proyectoTienda/page/procesarModificarCliente" method="post" class="form ajax-form">
                    <div class="form-group mb-4">
                        <label for="nombreCliente">Nombre del Cliente</label>
                        <input type="text" class="form-control" id="nombreCliente" name="nombreCliente"
                            placeholder="Nombre del Cliente..." required oncopy="return false" onpaste="return false"
                            onkeypress="return sololetras(event)" value="<?php echo $nombrePersona; ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="apellidoCliente">Apellido del Cliente</label>
                        <input type="text" class="form-control" id="apellidoCliente" name="apellidoCliente"
                            placeholder="Apellido del Cliente..." required oncopy="return false" onpaste="return false"
                            onkeypress="return sololetras(event)" value="<?php echo $apellidoPersona; ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="telefonoCliente">Teléfono del Cliente</label>
                        <input type="text" class="form-control" id="telefonoCliente" name="telefonoCliente"
                            placeholder="Teléfono del Cliente..." required oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)" value="<?php echo $telefono; ?>">
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-center mb-2 mb-md-0">
                            <a href="/proyectoTienda/page/listarClientes/1" class="btn w-75">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Cancelar</button>
                            </a>
                        </div>
                        <input type="hidden" name="idCliente" value="<?php echo $id; ?>">
                        <input type="hidden" name="idPersona" value="<?php echo $idPersona; ?>">
                        <input type="hidden" name="idContacto" value="<?php echo $idContacto; ?>">
                        <div class="col-6 d-flex justify-content-center btn">
                            <button type="submit" class="btn btn-primary w-75" id="input-submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>