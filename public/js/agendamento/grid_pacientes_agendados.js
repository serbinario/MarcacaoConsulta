/**
 * Created by Fabio on 30/05/2017.
 */

// Variáveis globais
var table, idsPacientes;

// Carregaando a grid
table = $('#agendados-grid').DataTable({
    retrieve: true,
    processing: true,
    serverSide: true,
    iDisplayLength: 25,
    bLengthChange: false,
    bFilter: false,
    autoWidth: false,
    ajax: {
        url: "/serbinario/agendados/grid",
        method: 'POST',
        data: function (d) {
            d.data_inicio = $('input[name=data_inicio]').val();
            d.data_fim = $('input[name=data_fim]').val();
            d.exame = $('select[name=exame] option:selected').val();
            d.prioridade = $('select[name=prioridade] option:selected').val();
            d.psf = $('select[name=psf] option:selected').val();
            d.situacao = $('select[name=situacao] option:selected').val();
            d.globalSearch = $('input[name=globalSearch]').val();
        }
    },
    columns: [
        {data: 'nome', name: 'cgm.nome'},
        {data: 'especialidade', name: 'operacoes.nome'},
        {data: 'data', name: 'calendario.data'},
        {data: 'hora', name: 'agendamento.hora'},
        {data: 'especialista', name: 'cgm_especialista.nome'},
        {data: 'psf', name: 'posto_saude.nome'},
        {data: 'status', name: 'status_agendamento.nome'}
        /* {data: 'action', name: 'action', orderable: false, searchable: false}*/
    ]
});

// Selecionar as tr da grid
$(document).on('click', '#agendados-grid tbody tr', function () {
    // Aplicando o estilo css
    if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
    } else {
        $(this).addClass("selected");
    }
});

// Evento para quando clicar na tr da table de pacientes
$(document).on('click', '#agendados-grid tbody tr', function () {

    // Array que armazenará os ids dos pacientes
    var arrayId = [];

    // Varrendo as linhas
    $("#agendados-grid tbody tr.selected").each(function (index, value) {

        arrayId[index] = table.row($(value).index()).data().id;

    });

    // Habilitando e desabilitando o botão de reagendamento
    if (arrayId.length > 0) {
        $('#definirAtendimento').prop('disabled', false);
    } else {
        $('#definirAtendimento').prop('disabled', true);
    }

    // Armazenando os ids dos paciente em um array global
    idsPacientes = arrayId;

});


//Função do submit do search da grid principal
$('#search').click(function (e) {
    table.draw();
    e.preventDefault();
});

