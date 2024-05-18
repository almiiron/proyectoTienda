<!-- Modal -->
<div class="modal fade" id="cargarCategoria" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Nueva Categoria</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="http://localhost/proyectoTienda/page/procesarCargarCategoria" method="post"
                class="form ajax-form">
                <div class="modal-body">

                    <div class="form-group mb-4">
                        <label for="nombreCategoria">Nombre de la Categoria</label>
                        <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria"
                            placeholder="Nombre de la Categoria..." required oncopy="return false"
                            onpaste="return false" onkeypress="return sololetras(event)">
                    </div>
                    <input type="hidden" name="metodo" id="metodo" value="procesarCargarCategoria">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="input-submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>