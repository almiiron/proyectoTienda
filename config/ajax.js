$(document).ready(function () {
    // Captura el evento de envío del formulario
    $('form.ajax-form').submit(function (e) {
        e.preventDefault(); // Evita que se envíe el formulario de manera predeterminada.

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize();

        // Llama a la función para enviar el formulario de forma asíncrona.
        enviarFormulario(url, formData, function (response) {
            if (response.success) {
                swal({
                    title: 'Éxito',
                    text: response.message || 'La operación se realizó correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result) {
                        location.reload(); // Recarga la página después de cerrar el Sweet Alert
                    }
                });
            } else {
                swal({
                    title: 'Error',
                    text: response.message || 'Hubo un error al procesar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});

// Función para enviar el formulario de forma asíncrona utilizando AJAX.
function enviarFormulario(url, formData, successCallback) {
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: successCallback,
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


// funcion generica para eliminar elementos 
function cambiarEstado(id, estadoActual) {
    // Mostrar confirmación antes de eliminar
    swal({
        title: '¿Está seguro?',
        text: '¿Realmente desea cambiar el estado?',
        icon: 'warning',
        buttons: ['Cancelar', 'Cambiar'],
        dangerMode: true,
    }).then(function (confirmDelete) {
        if (confirmDelete) {
            var metodo = $('#metodoEstado').val();
            var url = 'http://localhost/proyectoTienda/page/procesarCambiarEstado' + metodo; // Concatenando la variable método a la URL

            console.log('URL:', url);
            var formData = {
                id: id,
                metodo: metodo,
                estadoActual: estadoActual
            };

            $.ajax({
                type: 'POST',
                url: url, // Utilizando la URL dinámica
                data: formData,
                success: function (response) {
                    console.log('Respuesta del servidor:', response);
                    if (response.success) {
                        swal({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(function () {
                            // Recargar la página después de cerrar la alerta
                            location.reload();
                        });
                    } else {
                        swal({
                            title: '¡No se pudo cambiar el estado del elemento!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(function () {
                            // Recargar la página después de cerrar la alerta
                            location.reload();
                        });
                    }
                },
                error: function () {
                    console.error('Hubo un error al procesar la solicitud.');
                    swal({
                        title: '¡Error de servidor!',
                        text: 'Hubo un problema al comunicarse con el servidor.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });
}

$(document).ready(function () {
    $('.button-estado').click(function (e) {
        e.preventDefault();
        var id = $(this).closest('form').find('input[name="idEstado"]').val();
        var estadoActual = $(this).closest('form').find('input[name="estadoActual"]').val();
        cambiarEstado(id, estadoActual);
    });
});




function mostrar(value) {
    console.log(value)
}

function enviarFiltros(url, datos) {
    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function (response) {
            // Manejar la respuesta del servidor si es necesario
            console.log('datos enviados')
        },
        error: function (xhr, status, error) {
            // Manejar errores si es necesario
            console.log('datos no enviados')
        }
    });
}


$(document).ready(function () {
    // Función para filtrar opciones en los select
    $('#input-busqueda').click(function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var url = form.attr('action');
        var filtro = $(this).val();
        console.log(filtro);
        enviarFiltros(url, filtro);
    });
});

$(document).ready(function () {
    $("#IdProveedorProducto").select2({
        dropdownParent: $("#cargarProducto")
    });
    $("#IdCategoriaProducto").select2({
        dropdownParent: $("#cargarProducto")
    });
});