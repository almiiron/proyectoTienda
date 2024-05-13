<div class="containerForm">
    <form action="procesarCargarProveedor" class="form" method="post">
        <div class="form-group mb-4">
            <label for="nombreProveedor">Nombre del Proveedor</label>
            <input type="text" class="form-control" id="nombreProveedor" placeholder="Nombre del Proveedor..." required
                name="nombreProveedor" oncopy="return false" onpaste="return false"
                onkeypress="return sololetras(event)">
        </div>

        <div class="form-group mb-2">
            <label for="contactoProveedor">Numero de contacto del Proveedor</label>
            <input type="text" class="form-control" id="contactoProveedor" name="contactoProveedor"
                placeholder="Numero de contacto del Proveedor" oncopy="return false" onpaste="return false"
                onkeypress="return solonumeros(event)">
        </div>
        <input type="submit" value="Guardar Proveedor" id="input-submit"  class="btn btn-primary col-12">
    </form>
</div>