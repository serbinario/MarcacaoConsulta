// Carregando a table


// Função de execução
function runModalReagendarPacientes(especialidadeId, idsPacientes, especialistaNome, CRM)
{

    // prenchendo o nome e CRM do especialista
    $('.Nome').text(especialistaNome);
    $('.CRM').text(CRM);
    $('.qtdPacientes').text(idsPacientes.length);

    // Carregando os especialistas
    especialistas(especialidadeId);

    // Desabilitando o botão de reagendas
    $('#reagendar').prop('disabled', true);

    // Deixando oculto a mensagem de alerta para limite de vagas
    $('.msg').hide();

    // Exibindo o modal
    $('#modal-reagendamento').modal({'show' : true});
}

// Id do telefone
var idEspecialidade;

//Evento do click no botão adicionar período
$(document).on('click', '#reagendar', function (event) {

    //Recuperando os valores dos campos do fomulário
    var especialista    = $('#especialista').val();
    var calendario      = $('#calendario-reagendar').val();
    var mapa            = $('#mapa-reagendar').val();
    var pacientes       = idsPacientes;
    var vagaRestante    = vagasRestantes;

    // Verificando se os campos de preenchimento obrigatório foram preenchidos
    if (!especialista  || !calendario || !mapa || pacientes.length <= 0) {
        swal("Oops...", "Há campos obrigatórios que não foram preenchidos!", "error");
        return false;
    }

    // Validando se o mapa possui vagas suficientes
    if(vagaRestante < idsPacientes.length) {
        swal("Oops...", "O mapa selecioando não possui vaga suficiente para este reagendamento!", "error");
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
        url: "/serbinario/calendario/reagendamento",
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        swal("Paciente(s) reagendado(s) com sucesso!", "Click no botão abaixo!", "success");
        tablePacientes.ajax.reload();
        $('#modal-reagendamento').modal('toggle');

        //Limpar os campos do formulário
        limparCamposFormulario();
    });
});

//Limpar os campos do formulário
function limparCamposFormulario()
{
    $('#calendario-reagendar option').remove();
    $('#mapa-reagendar option').remove();
    $('#total-vagas').val("");
    $('#vagas-restantes').val("");
}



