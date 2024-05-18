<!-- Modal -->
<div class="modal fade" id="cargarProveedor" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo Proveedor</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="http://localhost/proyectoTienda/page/procesarCargarProveedor" method="post" class="form ajax-form">
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="nombreProveedor">Nombre del Proveedor</label>
                        <input type="text" class="form-control" id="nombreProveedor"
                            placeholder="Nombre del Proveedor..." required name="nombreProveedor" oncopy="return false"
                            onpaste="return false" onkeypress="return sololetras(event)">
                    </div>

                    <div class="form-group mb-2">
                        <label for="contactoProveedor">Numero de contacto del Proveedor</label>
                        <input type="text" class="form-control" id="contactoProveedor" name="contactoProveedor"
                            placeholder="Numero de contacto del Proveedor" oncopy="return false" onpaste="return false"
                            onkeypress="return solonumeros(event)">
                    </div>
                    <input type="hidden" name="metodo" id="metodo" value="procesarCargarProveedor">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="input-submit">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</div>