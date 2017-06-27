/**
 * Created by Fabio on 01/06/2017.
 */

// Variáveis globais
var especialidadeId, idsPacientes, perfil;
var totalVagas, vagasRestantes;


function format(d) {

    var html = "";

    for (var i = 0; i < d['supoperacoes'].length; i++ ) {
        html += d['supoperacoes'][i]['nome'] + "<br />";
    }

    return html;
}

var table = $('#fila-grid').DataTable({
    processing: true,
    serverSide: true,
    bFilter: false,
    order: [[ 1, "asc" ]],
    language: {
        url: '//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json'
    },
    ajax: {
        url: "/serbinario/fila/grid",
        method: 'POST',
        data: function (d) {
            d.data_inicio = $('input[name=data_inicio]').val();
            d.data_fim = $('input[name=data_fim]').val();
            d.exame = $('select[name=exame] option:selected').val();
            d.prioridade = $('select[name=prioridade] option:selected').val();
            d.psf = $('select[name=psf] option:selected').val();
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
        {data: 'especialidade', name: 'operacoes.nome'},
        {data: 'prioridade', name: 'prioridade.nome'},
        {data: 'data_cadastro', name: 'fila.data'},
        {data: 'numero_sus', name: 'cgm.numero_sus'},
        {data: 'psf', name: 'posto_saude.nome'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});


// Add event listener for opening and closing details
$('#fila-grid tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
});

// Selecionar as tr da grid
$(document).on('click', '#fila-grid tbody tr', function () {
    // Aplicando o estilo css
    if($(this).hasClass("selected")) {
        $(this).removeClass("selected");
    } else {
        $(this).addClass("selected");
    }
});


// Evento para quando clicar na tr da table de pacientes
$(document).on('click', '#fila-grid tbody tr', function () {

    // Array que armazenará os ids dos pacientes
    var aux;
    var auxHabilitarBotaoAgendar;
    var arrayId = [];

    // Varrendo as linhas
    $("#fila-grid tbody tr.selected").each(function (index, value) {

        arrayId[index] = table.row($(value).index()).data().id;

        //Validando e pegando os paciente do mesmo exame
        if(arrayId.length == 1) {

            especialidadeId = table.row($(value).index()).data().exame; //Pegando o id da especialidade
            aux  = table.row($(value).index()).data().exame;
            auxHabilitarBotaoAgendar = true;

        } else if (arrayId.length > 1 && aux == table.row($(value).index()).data().exame) {

            especialidadeId = table.row($(value).index()).data().exame; //Pegando o id da especialidade
            aux = table.row($(value).index()).data().exame;
            auxHabilitarBotaoAgendar = true;

        } else if (arrayId.length > 1 && aux != table.row($(value).index()).data().exame) {
            auxHabilitarBotaoAgendar = false;
            swal("Oops...", "Pacientes com exames diferentes. Selecione pacientes com o mesmo exame!", "error");
            return false;
        }

    });

    // Habilitando e desabilitando o botão de agendamento
    if(arrayId.length > 0 && auxHabilitarBotaoAgendar) {
        $('#agendarPaciente').prop('disabled', false);
    } else {
        $('#agendarPaciente').prop('disabled', true);
    }

    // Armazenando os ids dos paciente em um array global
    idsPacientes = arrayId;

});

//Função do submit do search da grid principal
$('#search').click(function(e) {
    table.draw();
    e.preventDefault();
});
