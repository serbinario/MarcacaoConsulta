/**
 * Created by Fabio on 30/05/2017.
 */

// Variáveis globais
var table, idsPacientes, especialidadeId, perfil;
var totalVagas, vagasRestantes;

function formatAgendados(d) {

    var html = "";

    if(d['sub_operacao']){
        html = "<b>Subespecialidade:</b> "+d['sub_operacao'];
    }

    return html;
}

// Carregaando a grid
table = $('#agendados-grid').DataTable({
    retrieve: true,
    processing: true,
    serverSide: true,
    iDisplayLength: 25,
    bLengthChange: false,
    bFilter: false,
    autoWidth: false,
    order: [[ 1, "asc" ]],
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
        {
            "className":      'details-control',
            "orderable":      false,
            "data":           'operacoes.nome',
            "defaultContent": ''
        },
        {data: 'nome', name: 'cgm.nome'},
        {data: 'numero_sus', name: 'cgm.numero_sus'},
        {data: 'especialidade', name: 'operacoes.nome'},
        {data: 'data', name: 'calendario.data'},
        {data: 'horario', name: 'mapas.horario'},
        {data: 'especialista', name: 'cgm_especialista.nome'},
        {data: 'psf', name: 'posto_saude.nome'},
        {data: 'status', name: 'status_agendamento.nome'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});


// Add event listener for opening and closing details
$('#agendados-grid tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }

    else {
        // Open this row
        row.child( formatAgendados(row.data()) ).show();
        tr.addClass('shown');
    }
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
    var aux;
    var auxHabilitarBotaoReagendar;
    var arrayId = [];

    // Varrendo as linhas
    $("#agendados-grid tbody tr.selected").each(function (index, value) {

        arrayId[index] = table.row($(value).index()).data().id;

        //Validando e pegando os paciente do mesmo exame
        if(arrayId.length == 1) {

            especialidadeId = table.row($(value).index()).data().exame; //Pegando o id da especialidade
            aux  = table.row($(value).index()).data().exame;
            auxHabilitarBotaoReagendar = true;

        } else if (arrayId.length > 1 && aux == table.row($(value).index()).data().exame) {

            especialidadeId = table.row($(value).index()).data().exame; //Pegando o id da especialidade
            aux = table.row($(value).index()).data().exame;
            auxHabilitarBotaoReagendar = true;

        } else if (arrayId.length > 1 && aux != table.row($(value).index()).data().exame) {
            auxHabilitarBotaoReagendar = false;
            swal("Oops...", "Pacientes com exames diferentes. Selecione pacientes com o mesmo exame!", "error");
            return false;
        }

    });

    // Habilitando e desabilitando o botão de reagendamento
    if(arrayId.length > 0 && auxHabilitarBotaoReagendar) {
        $('#reagendarPaciente').prop('disabled', false);
    } else {
        $('#reagendarPaciente').prop('disabled', true);
    }

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

