// Carregando a table


// Função de execução
function runModalDefinirAtendimento(idsPacientes)
{

    // prenchendo o nome e CRM do especialista
    $('.qtdPacientes').text(idsPacientes.length);

    // Desabilitando o botão de reagendas
    $('#definir').prop('disabled', true);

    // Exibindo o modal
    $('#modal-definir-atendimento').modal({'show' : true});
}

// Id do telefone
var idEspecialidade;

//Evento do click no botão adicionar período
$(document).on('click', '#alterarSituacao', function (event) {

    //Recuperando os valores dos campos do fomulário
    var situacao        = $('#definir-situacao').val();
    var pacientes       = idsPacientes;

    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!situacao  || pacientes.length <= 0) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    //Setando o json para envio
    var dados = {
        'situacao'  : situacao,
        'pacientes' : pacientes
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/agendados/alterarSituacao",
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Situação dos pacientes alterada com sucesso!", "Click no botão abaixo!", "success");
        table.ajax.reload();
        $('#modal-definir-atendimento').modal('toggle');

    });
});




