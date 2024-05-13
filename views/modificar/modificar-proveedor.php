<div class="containerForm">
    <form action="procesarModificarProveedor" class="form" method="post">
        <div class="form-group mb-4">
            <label for="nombreProveedor">Nombre del Proveedor</label>
            <input type="text" class="form-control" id="nombreProveedor" placeholder="Nombre del Proveedor..." required
                name="nombreProveedor" oncopy="return false" onpaste="return false"
                onkeypress="return sololetras(event)" value="<?php echo $buscarProveedor['nombre'] ?>">
        </div>

        <div class="form-group mb-2">
            <label for="contactoProveedor">Numero de contacto del Proveedor</label>
            <input type="text" class="form-control" id="contactoProveedor" name="contactoProveedor"
                placeholder="Numero de contacto del Proveedor" oncopy="return false" onpaste="return false"
                onkeypress="return solonumeros(event)" value="<?php echo $buscarProveedor['telefono'] ?>">
        </div>
        <input type="hidden" name="id" value="<?php echo $buscarProveedor['id_proveedor'] ?>">
        <input type="hidden" name="idContacto" value="<?php echo $buscarProveedor['id_contacto'] ?>">
        <input type="submit" value="Guardar Proveedor" id="input-submit" class="btn btn-primary col-12">
    </form>
</div>