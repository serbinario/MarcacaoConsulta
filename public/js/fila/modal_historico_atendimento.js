
// Carregando a table
var tableHistoricoAtendimento;

function format(d) {

    var html = "";

    html += '<table class="table" width="100%">';
    html += '<thead>';
    html += '<tr>';
    html += '<th>Especialista</th>';
    html += '<th>Data</th>';
    html += '<th>Horário</th>';
    html += '<th>Situação</th>';
    html += '<th>Localidade</th>';
    html += '</tr>';
    html += '</thead>';
    html += '<tbody>';

     for (var i = 0; i < d['agendamentos'].length; i++ ) {

         html += '<tr>';
         html += '<td>'+ d['agendamentos'][i]['especialista'] +'</td>';
         html += '<td>'+ d['agendamentos'][i]['data'] +'</td>';
         html += '<td>'+ d['agendamentos'][i]['horario'] +'</td>';
         html += '<td>'+ d['agendamentos'][i]['status'] +'</td>';
         html += '<td>'+ d['agendamentos'][i]['localidade'] +'</td>';
         html += '</tr>';
     }

    html += '</tbody>';
    html += '</table>';

    return html;
}

function loadTableHistoricoAtendimento (idCGM) {

    // Carregaando a grid
    tableHistoricoAtendimento = $('#histotico-atendimento-grid').DataTable({
        retrieve: true,
        processing: true,
        serverSide: true,
        iDisplayLength: 5,
        bLengthChange: false,
        bFilter: false,
        autoWidth: false,
        order: [[ 1, "asc" ]],
        ajax: "/index.php/serbinario/fila/historicoAtendimento/"+idCGM,
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           'age_operacoes.nome',
                "defaultContent": ''
            },
            {data: 'especialidade', name: 'age_operacoes.nome'},
            {data: 'data_cadastro', name: 'fila.data'},
            {data: 'prioridade', name: 'age_prioridade.nome'},
            {data: 'psf', name: 'age_posto_saude.nome'}
        ]
    });

    // Add event listener for opening and closing details
    $('#histotico-atendimento-grid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableHistoricoAtendimento.row( tr );

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

    return tableHistoricoAtendimento;
}


// Função de execução
function runHistoricoAtendimento(idCGM)
{
    //Carregando as grids de situações
    if(tableHistoricoAtendimento) {
        loadTableHistoricoAtendimento(idCGM).ajax.url("/index.php/serbinario/fila/historicoAtendimento/"+idCGM).load();
    } else {
        loadTableHistoricoAtendimento(idCGM);
    }

    // Exibindo o modal
    $('#modal-historico-atendimento').modal({'show' : true});
}



