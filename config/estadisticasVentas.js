// const host = '192.168.100.23';
// var host = 'localhost';

// si la URL contiene 'controlVentas' llamo a las funciones
if (window.location.href.indexOf('panelControl') !== -1) {
    ProductosMasVendidos();
    CategoriasConMasVentas();
    TotalVentasCadaMesDelAño();
    IngresosUltimosSieteDias();
    IngresosUltimasCuatroSemanas();
}


function ProductosMasVendidos() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/productosMasVendidos`,
        type: 'POST',
        success: function (data) {
            const productosData = JSON.parse(data);

            const ctx = document.getElementById('productos-mas-vendidos-chart').getContext('2d');
            const barChart = new Chart(ctx, {
                type: 'bar', // tipo de grafico 'bar'
                data: {
                    labels: productosData.productos,
                    datasets: [
                        {
                            label: 'Ingresos totales por producto',
                            data: productosData.ingresos,
                            backgroundColor: ['blue', 'green', 'orange', 'red'],
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0, // limite minimo en 0
                            suggestedMax: Math.max(...productosData.ingresos) + 50, // limite máximo
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16, // tamaño del texto del eje Y
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos', // titulo del eje Y
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Productos', // titulo del eje X
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                                // margin: {
                                //     top: 500,
                                // },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                maxHeight: 100,
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,

                        },
                    },
                },
            });
        },
    });
}


function CategoriasConMasVentas() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/categoriasConMasVentas`,
        type: 'POST',
        success: function (data) {
            const categoriasData = JSON.parse(data);

            const ctx = document.getElementById('categorias-con-mas-ventas-chart').getContext('2d');
            const pieChart = new Chart(ctx, {
                type: 'doughnut', // tipo de grafico 'pie'
                data: {
                    labels: categoriasData.categorias,
                    datasets: [
                        {
                            label: 'Ingresos totales por categoria',
                            data: categoriasData.ingresos,
                            backgroundColor: [
                                'blue', 'green', 'orange', 'red', 'purple', 'yellow', 'pink', 'gray', 'brown', 'cyan'
                            ],
                        },
                    ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 16, // tamaño del texto del titulo
                                },
                            },
                            title: {
                                display: true,
                                text: 'Categorias con más ventas', // titulo del gráfico
                                font: {
                                    size: 20, // tamaño del texto del titulo
                                },
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
    });
}

function TotalVentasCadaMesDelAño() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/totalVentasCadaMesDelAnio`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('total-ventas-cada-mes-del-año-chart').getContext('2d');
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.meses,
                    datasets: [
                        {
                            label: 'Ingresos cada mes del año',
                            data: data.ingresos,
                            backgroundColor: [
                                'blue', 'green', 'orange', 'red', 'purple', 'yellow', 'pink', 'gray', 'brown', 'cyan', 'magenta', 'teal'
                            ]
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Meses',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}

function IngresosUltimosSieteDias() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/ingresosUltimosSieteDias`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('ingresos-ultimos-siete-dias-chart').getContext('2d');
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.fechas,
                    datasets: [
                        {
                            label: 'Ingresos ultimos 7 dias',
                            data: data.ingresos,
                            backgroundColor: [
                                'blue', 'green', 'orange', 'red', 'purple', 'yellow', 'brown', 'cyan'
                            ]
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fechas',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}

function IngresosUltimasCuatroSemanas() {
    $.ajax({
        url: `http://${host}/proyectoTienda/page/ingresosUltimasCuatroSemanas`,
        type: 'POST',
        dataType: 'json',  // Especificar que esperamos JSON como respuesta
        success: function (data) {
            // 'data' ya es un objeto JSON válido
            const ctx = document.getElementById('ingresos-ultimas-cuatro-semanas-chart').getContext('2d');
            const barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.semanas,
                    datasets: [
                        {
                            label: 'Ingresos ultimas 4 semanas',
                            data: data.ingresos,
                            backgroundColor: [
                                'blue', 'green', 'orange', 'red', 'purple', 'yellow', 'brown', 'cyan'
                            ]
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data.ingresos) + 50,
                            ticks: {
                                callback: function (value, index, values) {
                                    return '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: value % 1 === 0 ? 0 : 2
                                    }).format(value);
                                },
                                font: {
                                    size: 16,
                                },
                            },
                            title: {
                                display: true,
                                text: 'Ingresos',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fechas',
                                font: {
                                    size: 20,
                                },
                            },
                        },
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label;
                                    var value = '$ ' + new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'ARS',
                                        minimumFractionDigits: 0,
                                    }).format(context.raw);
                                    return label + ': ' + value;
                                },
                            },
                        },
                        legend: {
                            display: true,
                            labels: {
                                color: 'black',
                                font: {
                                    size: 20,
                                },
                                boxWidth: 0,
                            },
                            title: {
                                display: false,
                            },
                            onClick: false,
                        },
                    },
                },
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener los datos:', textStatus, errorThrown);
        }
    });
}
