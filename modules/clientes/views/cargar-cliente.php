<!-- Modal -->
<div class="modal fade" id="cargarCliente" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nuevo Cliente</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="http://localhost/proyectoTienda/page/procesarCargarCliente" method="post"
                class="form ajax-form">
                <div class="modal-body">

                    <div class="form-group mb-4">
                        <label for="nombreCategoria">Nombre del Cliente</label>
                        <input type="text" class="form-control" id="nombreCliente" name="nombreCliente"
                            placeholder="Nombre del Cliente..." required oncopy="return false"
                            onpaste="return false" onkeypress="return sololetras(event)">
                    </div>
                    <div class="form-group mb-4">
                        <label for="nombreCategoria">Apellido del Cliente</label>
                        <input type="text" class="form-control" id="apellidoCliente" name="apellidoCliente"
                            placeholder="Apellido del Cliente..." required oncopy="return false"
                            onpaste="return false" onkeypress="return sololetras(event)">
                    </div>
                    <div class="form-group mb-4">
                        <label for="nombreCategoria">Telefono del Cliente</label>
                        <input type="text" class="form-control" id="telefonoCliente" name="telefonoCliente"
                            placeholder="Telefono del Cliente..." required oncopy="return false"
                            onpaste="return false" onkeypress="return solonumeros(event)">
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