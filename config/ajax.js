var host = '192.168.100.13';
// var host = 'localhost';

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
            var url = 'http://' + host + '/proyectoTienda/page/procesarCambiarEstado' + metodo; // Concatenando la variable método a la URL

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
    //los select con buscador, para que se carguen los select al abrir el modal
    $("#IdProveedorProducto").select2({
        dropdownParent: $("#cargarProducto")

    });
    $("#IdCategoriaProducto").select2({
        dropdownParent: $("#cargarProducto")
    });

    // si no esta en un modal, lo cargo asi 
    $("#IdProveedorProductoModificar").select2();
    $("#IdCategoriaProductoModificar").select2();
    ////////////////////////////////////////////
    $("#IdRolUsuario").select2({
        dropdownParent: $("#cargarEmpleado")
    });
    $("#IdRolUsuarioModificar").select2();
    ////////////////////////////////////////
    $("#IdClienteVenta").select2();
    $("#IdEmpleadoVenta").select2();
    $("#IdProductoVenta").select2();
    $("#IdMetodoPagoVenta").select2();
    $("#interesVenta").select2();
});

$(document).ready(function () {
    'use strict'
    // para el login 
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
});

$(document).ready(function () {
    $('#buttonIniciarSesion').click(function (e) {
        e.preventDefault();
        var alertLogin = document.getElementById('alert-login');
        var form = $(this).closest('form');
        var url = form.attr('action');
        var formData = form.serialize();
        var user = $(this).closest('form').find('input[name="user"]').val();
        var password = $(this).closest('form').find('input[name="password"]').val();
        console.log(user);
        console.log(password);
        console.log(url);
        console.log(formData);

        // Llama a la función para enviar el formulario de forma asíncrona.
        enviarFormulario(url, formData, function (response) {
            if (response.success) {
                location.href = "http://" + host + "/proyectoTienda/page/home";
            } else {
                alertLogin.classList.remove('invalid-feedback');
            }
        });
    });
});
function addClassAlertLogin() {
    var alertLogin = document.getElementById('alert-login');
    alertLogin.classList.add('invalid-feedback');
}


$(function () {
    var tabCounter = 2; // Define un contador de pestañas
    var tabs = $("#tabs").tabs(); // Inicializa las pestañas utilizando jQuery UI

    // Función para restaurar pestañas desde localStorage
    function restoreTabs() {
        var savedTabs = JSON.parse(localStorage.getItem("tabs") || "[]"); // Obtiene las pestañas guardadas o un array vacío si no hay ninguna
        savedTabs.forEach(function (tab) {
            addTab(tab.url, tab.name, tab.icon, false); // Agrega cada pestaña guardada, pasando también el icono
        });
        highlightCurrentTab(); // Resaltar la pestaña actual después de restaurar
    }

    // Función para agregar una nueva pestaña
    function addTab(url, name, icon, save = true) {
        var existingTab = $(".tab-" + name); // Busca si ya existe una pestaña con la clase 'tab-name'

        if (existingTab.length > 0) {
            // Si ya existe, redirecciona a la URL de la nueva pestaña
            redireccionar(url);
            return;
        }

        var label = name || "Tab " + tabCounter,
            id = "tabs-" + tabCounter,
            li = $("<li class='d-flex align-items-center justify-content-center '></li>");

        // Crea el botón con redireccionamiento
        var button = $("<button class='btn btn-secondary tab-" + name + " d-flex align-items-center justify-content-center rounded-1'></button>") // Agrega la clase 'tab-name' al botón
            .text(label)
            .attr("onclick", "redireccionar('" + url + "')")
            .append('&nbsp;&nbsp;<i class="fs-4 ' + icon + '"></i>');

        // Crea el icono de cierre
        var closeIcon = $("<span class='cursor-pointer ui-icon ui-icon-close' role='presentation' onclick='removeTab(" + tabCounter + ", \"" + url + "\")'></span>");

        // Agrega el botón y el icono de cierre al elemento li
        li.append(button).append(closeIcon);

        // Agrega el elemento li a la navegación de pestañas
        tabs.find(".ui-tabs-nav").append(li);

        // Refresca el widget de pestañas para reconocer la nueva pestaña
        tabs.tabs("refresh");
        tabCounter++;

        if (save) {
            saveTab(url, name, icon); // Guarda la pestaña, pasando también el icono
            redireccionar(url); // Redirecciona a la URL de la nueva pestaña
        }
    }

    // Función para guardar una pestaña en localStorage
    function saveTab(url, name, icon) {
        var savedTabs = JSON.parse(localStorage.getItem("tabs") || "[]"); // Obtiene las pestañas guardadas o un array vacío si no hay ninguna
        savedTabs.push({ url: url, name: name, icon: icon }); // Guarda la pestaña con la URL, nombre e icono
        localStorage.setItem("tabs", JSON.stringify(savedTabs)); // Almacena las pestañas en localStorage
    }

    // Función para eliminar una pestaña
    function removeTab(tabId, url) {
        // Elimina la pestaña
        $("#tabs-" + tabId).remove();

        // Elimina el botón de la pestaña correspondiente
        tabs.find(".ui-tabs-nav li").eq(tabId - 1).remove();

        // Refresca el widget de pestañas
        tabs.tabs("refresh");

        // Elimina la pestaña de localStorage
        var savedTabs = JSON.parse(localStorage.getItem("tabs") || "[]");
        savedTabs = savedTabs.filter(tab => tab.url !== url);
        localStorage.setItem("tabs", JSON.stringify(savedTabs));

        // Si hay pestañas restantes, redirecciona a la última pestaña abierta
        if ($("#tabs .ui-tabs-nav li").length > 0) {
            var lastTab = $("#tabs .ui-tabs-nav li:last-child button");
            redireccionar(lastTab.attr("onclick").match(/'([^']+)'/)[1]);
        } else {
            // Si no quedan pestañas, redirecciona a la página de inicio
            redireccionar('home');
        }
    }

    // Función para redireccionar a una URL y resaltar la pestaña actual
    function redireccionar(url) {
        if (url != 'noAction') {
            location.href = 'http://' + host + '/proyectoTienda/page/' + url;
            highlightCurrentTab();
        }
    }

    // Función para resaltar la pestaña actual
    // Función para resaltar la pestaña actual
    function highlightCurrentTab() {
        var currentUrl = window.location.href.toLowerCase(); // Convertir la URL actual a minúsculas para comparar
        $("#tabs .ui-tabs-nav button").each(function () {
            var buttonUrl = $(this).attr("onclick").match(/'([^']+)'/)[1].toLowerCase(); // Convertir la URL de la pestaña a minúsculas para comparar
            if (currentUrl.includes(buttonUrl)) {
                $(this).removeClass("btn-secondary").addClass("btn-primary");
            } else {
                $(this).removeClass("btn-primary").addClass("btn-secondary");
            }
        });
    }


    // Expone las funciones addTab, removeTab y redireccionar al ámbito global
    window.addTab = addTab;
    window.removeTab = removeTab;
    window.redireccionar = redireccionar;

    // Restaura las pestañas al cargar la página
    restoreTabs();
});



////////////////////////////
// para enviar el form de venta 
$(document).ready(function () {
    $('form.ajax-form-mostrarVenta').submit(function (e) {
        e.preventDefault();

        if ($('#tablaProductos tbody tr').length === 0) {
            swal({
                title: 'Error',
                text: 'Debes seleccionar al menos un producto para la venta.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        swal({
            title: '¿Seguro de cargar la venta?',
            text: 'Compruebe los datos y cargue la venta.',
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Cancelar',
                    value: null,
                    visible: true,
                    className: 'btn btn-secondary',
                    closeModal: true,
                },
                confirm: {
                    text: 'Cargar',
                    value: true,
                    visible: true,
                    className: 'btn btn-primary',
                    closeModal: true
                }
            }
        }).then(function (confirm) {
            if (confirm) {
                var form = $('form.ajax-form-mostrarVenta');
                var url = form.attr('action');
                var formData = form.serialize();
                var totalVenta = form.find('#inputTotal').val(); // Obtener totalVenta correctamente desde formData
                console.log('Total Venta:', totalVenta);

                var metodoPago = $('#IdMetodoPagoVenta').val();
                if (metodoPago == '2') { // ID de Transferencia
                    mostrarConfirmacionQR(totalVenta);
                } else {
                    enviarFormulario(url, formData, function (response) {
                        handleResponse(response);
                    });
                }
            }
        });
    });

    function mostrarConfirmacionQR(totalVenta) {
        swal({
            title: '¿Desea crear un QR para pagar la venta o cargar directamente la venta?',
            icon: 'info',
            buttons: {
                qr: {
                    text: 'Crear QR para pagar',
                    className: 'btn btn-primary',
                    value: 'qr'
                },
                cargar: {
                    text: 'Cargar directamente la venta',
                    className: 'btn btn-success',
                    value: 'cargar'
                },
                cancel: {
                    text: 'Cancelar',
                    className: 'btn btn-secondary',
                    value: null
                }
            }
        }).then(function (option) {
            if (option === 'qr') {
                generarQrMercadoPago(totalVenta);
            } else if (option === 'cargar') {
                cargarVentaDirectamente(totalVenta);
            }
        });
    }

    function generarQrMercadoPago(totalVenta) {
        let url = 'http://' + host + '/proyectoTienda/plugins/ventas/mercadoPago/obtenerVentaQR.php';
        $.ajax({
            url: url,
            type: 'POST',
            data: { total_amount: totalVenta },
            success: function (response) {
                var qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(response);

                swal({
                    title: 'Escaneá y pagá',
                    content: {
                        element: "img",
                        attributes: {
                            src: qrApiUrl
                        }
                    },
                    buttons: {
                        cancelar: {
                            text: 'Cancelar',
                            className: 'btn btn-secondary'
                        },
                        cargarVenta: {
                            text: 'Listo, cargar venta',
                            className: 'btn btn-success'
                        }
                    }
                }).then(function (option) {
                    if (option === 'cargarVenta') {
                        cargarVentaDirectamente(totalVenta);
                    } else if (option === 'cancelar') {
                        location.reload(); // Recargar la página si se cancela
                    }
                });
            },
            error: function () {
                swal({
                    title: 'Error',
                    text: 'Hubo un error en la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }


    function cargarVentaDirectamente(totalVenta) {
        var form = $('form.ajax-form-mostrarVenta');
        var url = form.attr('action');
        var formData = form.serialize();

        enviarFormulario(url, formData, function (response) {
            handleResponse(response);
        });
    }
    function handleResponse(response) {
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
    }
});

// como para cambiar de estado una notificacion no debo mostrar todo un swal alert, solo simplifico el ajax y agrego una animacion
$(document).ready(function () {
    $('.marcar-leido-notififacion').click(function (e) {
        e.preventDefault();
        var button = $(this);
        var icon = button.find('i');
        var id = button.closest('form').find('input[name="idEstado"]').val();
        var estadoActual = button.closest('form').find('input[name="estadoActual"]').val();
        var metodoEstado = button.closest('form').find('input[name="metodoEstado"]').val();

        marcarLeidoNotificacion(id, estadoActual, metodoEstado, button, icon);
    });
});

function marcarLeidoNotificacion(id, estadoActual, metodoEstado, button, icon) {
    var host = window.location.hostname; // Asegúrate de que la variable 'host' esté definida
    var url = 'http://' + host + '/proyectoTienda/page/procesarCambiarEstado' + metodoEstado;

    console.log('URL:', url);
    var formData = {
        id: id,
        metodo: metodoEstado,
        estadoActual: estadoActual
    };

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        success: function (response) {
            console.log('Respuesta del servidor:', response);

            // Eliminar todas las clases posibles del ícono antes de agregar las nuevas
            icon.removeClass('bi-check-square-fill text-primary text-secondary text-success bi-exclamation-square text-danger animate__animated animate__bounceIn animate__shakeX');

            // Manejo de clases según la respuesta del servidor
            if (response.success) {
                if (estadoActual == 'Activo') {
                    icon.addClass('bi-check-square-fill text-success animate__animated animate__bounceIn');
                } else {
                    icon.addClass('bi-check-square-fill text-secondary animate__animated animate__bounceIn');
                }
                button.addClass('animate__animated animate__bounceIn');
                setTimeout(function () {
                    location.reload();
                }, 500);
            } else {
                icon.addClass('bi-exclamation-square text-danger animate__animated animate__shakeX');
                button.addClass('animate__animated animate__bounceIn');
                setTimeout(function () {
                    location.reload();
                }, 500);
            }
        },
        error: function () {
            // En caso de error, eliminar las clases y agregar las de error
            icon.removeClass('bi-check-square-fill text-primary text-secondary text-success bi-exclamation-square text-danger animate__animated animate__bounceIn animate__shakeX');
            icon.addClass('bi-exclamation-square text-danger animate__animated animate__shakeX');

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

// para mostrar una campana llena o vacia dependiendo si hay notificaciones sin leer, ademas muestro el total de notifacones sin leer //
$(document).ready(function () {
    function actualizarNotificaciones() {
        console.log('se llama a la funcion bien');
        $.ajax({
            type: 'POST',
            url: `http://${host}/proyectoTienda/page/obtenerNotificacionesNoLeidas`,
            success: function (response) {
                console.log('notificaciones sin leer: ', response);
                var notificaciones = JSON.parse(response);
                console.log('depur', notificaciones);
                var icon = $('#notificaciones-icon');
                var iconTab = $('.notificaciones-icon');
                var count = $('#notificaciones-count');

                if (notificaciones > 0) {
                    icon.removeClass('bi-bell').addClass('bi-bell-fill');
                    iconTab.removeClass('bi-bell').addClass('bi-bell-fill');
                    count.text('+' + notificaciones);
                } else {
                    icon.removeClass('bi-bell-fill').addClass('bi-bell');
                    iconTab.removeClass('bi-bell-fill').addClass('bi-bell');
                    count.text('');
                }
            },
            error: function () {
                console.error('Hubo un error al obtener las notificaciones.');
            }
        });
    }

    actualizarNotificaciones();
    setInterval(actualizarNotificaciones, 60000); // Actualizar cada minuto
});
