$(document).ready(function () {

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/graficos/graficoTotalAtendidos",
        datatype: 'json'
    }).done(function (json) {
        graficoUm(json)
    });

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/graficos/graficoPacientesNaFila",
        datatype: 'json'
    }).done(function (json) {
        graficoLinhaPacientesNaFila(json)
    });

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/graficos/graficoPacientesAtendidas",
        datatype: 'json'
    }).done(function (json) {
        graficoLinhaPacientesAtendidos(json)
    });
});


// Gráfico de linha para pacientes atendidos por mês/ano
function graficoUm(json) {

    $(function () {
        Highcharts.chart('container-1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Gráfico Total de Atendidos (Mês/Ano)'
            },
            xAxis: {
                categories: json[0]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total de atendimento'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'Quantidade',
                data: json[1]
            }]
        });
    });
}

// Gráfico de linha para pacientes na fila por mês
function graficoLinhaPacientesNaFila(json) {

    $(function () {
        Highcharts.chart('container-2', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Gráfico de pacientes na fila (Mês)'
            },
            subtitle: {
                text: 'Por quantidade'
            },
            xAxis: {
                categories: json[0]
            },
            yAxis: {
                title: {
                    text: 'Quantidade de pacientes'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Quantidade',
                data: json[1]
            }]
        });
    });
}

// Gráfico de linha para pacientes atendidos por mês
function graficoLinhaPacientesAtendidos(json) {

    $(function () {
        Highcharts.chart('container-3', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Gráfico de pacientes atendidos (Mês)'
            },
            subtitle: {
                text: 'Por quantidade'
            },
            xAxis: {
                categories: json[0]
            },
            yAxis: {
                title: {
                    text: 'Quantidade de pacientes'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Quantidade',
                data: json[1]
            }]
        });
    });
}