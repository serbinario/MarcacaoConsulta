// Variável global para ir do paciente
var idPaciente;

// Função de execução
function runModalInserirObsAtendimento(idPaciente, observavao)
{

    $('#observacao').val(observavao);

    // Exibindo o modal
    $('#modal-inserir-obs-atendimento').modal({'show' : true});
}

// Evento do click no botão para salvar a observação
// Está sendo usado a mesma rota para definição de atendimento, porém por meio dessa ação
// Será salva apenas a observação de acordo com a defini
$(document).on('click', '#salvarObservacao', function (event) {

    // Recuperando os valores dos campos do fomulário
    var situacao      = "";
    var paciente      = idPaciente;
    var observacao    = $('#observacao').val();

    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!observacao || !paciente) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    //Setando o json para envio
    var dados = {
        'situacao'   : situacao,
        'paciente'   : paciente,
        'observacao' : observacao
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "index.php/serbinario/agendados/alterarSituacao",
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Observação dos pacientes alterada com sucesso!", "Click no botão abaixo!", "success");
        table.ajax.reload();
        $('#modal-inserir-obs-atendimento').modal('toggle');
    });
});


//Evento do click no botão adicionar período
$(document).on('click', '#inserirNaFila', function (event) {

    //Recuperando os valores dos campos do fomulário
    var paciente     = idPaciente;

    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!paciente) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    //Setando o json para envio
    var dados = {
        'paciente' : paciente
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/agendados/inserirNaFila",
        data: dados,
        datatype: 'json'
    }).done(function (json) {

        // Verifica se a situação de criação da nova fila, se sucesso
        if(json['success']) {

            swal("Situação dos pacientes alterada com sucesso!", "Click no botão abaixo!", "success");
            table.ajax.reload();
            $('#modal-inserir-obs-atendimento').modal('toggle');

        } else {
            swal("Este paciente já se encontra na fila de espera!", "Click no botão abaixo!", "warning");
        }

    });

});



