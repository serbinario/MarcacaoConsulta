// Carregando a table


// Função de execução
function runModalAgendarPacientes(especialidadeId, idsPacientes)
{

    // Carregando os especialistas
    especialistas(especialidadeId);

    // Desabilitando o botão de reagendar
    $('#agendar').prop('disabled', true);

    // Deixando oculto a mensagem de alerta para limite de vagas
    $('.msg').hide();

    // Exibindo o modal
    $('#modal-agendamento').modal({'show' : true});
}

// Id do telefone
var idEspecialidade;

//Evento do click no botão para agendar
$(document).on('click', '#agendar', function (event) {

    //Recuperando os valores dos campos do fomulário
    var especialista    = $('#especialista').val();
    var calendario      = $('#calendario-agendar').val();
    var mapa            = $('#mapa-agendar').val();
    var pacientes       = idsPacientes;
    var vagaRestante    = vagasRestantes;

    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!especialista  || !calendario || !mapa || pacientes.length <= 0) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    // Validando se o mapa possui vagas suficientes
    if(vagaRestante < idsPacientes.length && perfil == '2') {
        swal("Oops...", "O mapa selecioando não possui vaga suficiente para este agendamento!", "error");
        return false;
    }

    //Setando o json para envio
    var dados = {
        'calendario_id' : calendario,
        'mapa' : mapa,
        'pacientes' : pacientes
    };

    // Requisição Ajax
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/calendario/agendamento",
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Paciente(s) agendado(s) com sucesso!", "Click no botão abaixo!", "success");
        table.ajax.reload();
        $('#modal-agendamento').modal('toggle');

        //Limpar os campos do formulário
        limparCamposFormulario();
    });
});

//Limpar os campos do formulário
function limparCamposFormulario()
{
    $('#calendario-agendar option').remove();
    $('#mapa-agendar option').remove();
    $('#total-vagas').val("");
    $('#vagas-restantes').val("");
}



