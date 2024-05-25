<div class="container my-4">
    <div class="row justify-content-center">
        <div class="containerForm col-md-6 col-sm-12">
            <form action="procesarModificarProveedor" class="form ajax-form" method="post">
                <div class="form-group mb-4">
                    <label for="nombreProveedor">Nombre del Proveedor</label>
                    <input type="text" class="form-control" id="nombreProveedor" placeholder="Nombre del Proveedor..."
                        required name="nombreProveedor" oncopy="return false" onpaste="return false"
                        onkeypress="return validaambos(event)" value="<?php echo $buscarProveedor['nombre'] ?>">
                </div>

                <div class="form-group mb-2">
                    <label for="contactoProveedor">Numero de contacto del Proveedor</label>
                    <input type="text" class="form-control" id="contactoProveedor" name="contactoProveedor"
                        placeholder="Numero de contacto del Proveedor" oncopy="return false" onpaste="return false"
                        onkeypress="return solonumeros(event)" value="<?php echo $buscarProveedor['telefono'] ?>">
                </div>
                <input type="hidden" name="id" value="<?php echo $buscarProveedor['id_proveedor'] ?>">
                <input type="hidden" name="idContacto" value="<?php echo $buscarProveedor['id_contacto'] ?>">
                <div class="row">
                    <div class="col-6 d-flex justify-content-center mb-2 mb-md-0">
                        <a href="/proyectoTienda/page/listarProveedores/1" class="btn w-75">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Cancelar</button>
                        </a>
                    </div>
                    <div class="col-6 d-flex justify-content-center btn">
                        <button type="submit" class="btn btn-primary w-75" id="input-submit">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>