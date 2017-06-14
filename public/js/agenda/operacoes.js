/**
 * Created by Fabio on 30/05/2017.
 */

var idCalendario = "";
var idEspecialista = "";

// Tratar habilitação do mapa 2
$('#mapa').click(function () {
    if ($('#mapa').is(":checked")) {
        $('#hora2').prop('readonly', false);
        $('#vagas_mapa2').prop('readonly', false);
        $('#especialidade_dois').prop('disabled', false);
        especialidadesDois("", idEspecialista);
    } else {
        $('#hora2').prop('readonly', true);
        $('#hora2').val("");
        $('#vagas_mapa2').prop('readonly', true);
        $('#vagas_mapa2').val("");
        $('#especialidade_dois').prop('disabled', true);
        $('#especialidade_dois option').remove();
    }
});

//Salvar agenda
$("#save").click(function (event) {
    event.preventDefault();

    // Pegando os valores do formulário
    var mapa = $('#mapa').is(":checked") == true ? '1' : '0';
    var localidade = $('#localidades').val();
    var especialista = $('#especialista_id').val();
    var qtd_vagas = $('#qtd_vagas').val();
    var data = $('#data').val();
    var hora = $('#hora').val();
    var hora2 = $('#hora2').val();
    var vagas_mapa1 = $('#vagas_mapa1').val();
    var vagas_mapa2 = $('#vagas_mapa2').val();
    var especialidade_um = $('#especialidade_um').val();
    var especialidade_dois = $('#especialidade_dois').val();

    // Setando os valores para preenchimento dos mapas
    if($('#mapa').is(":checked")) {
        var dadosDoMapa = [
            {'horario': hora, 'vagas': vagas_mapa1, 'especialidade_id': especialidade_um},
            {'horario': hora2, 'vagas': vagas_mapa2, 'especialidade_id': especialidade_dois}
        ];
    } else {
        var dadosDoMapa = [
            {'horario': hora, 'vagas': vagas_mapa1, 'especialidade_id': especialidade_um}
        ];
    }

    // Preenchendo o array de dados para requisição do formulário
    var dados = {
        'localidade_id': localidade,
        'especialista_id': especialista,
        'qtd_vagas': qtd_vagas,
        'data': data,
        'mais_mapa': mapa,
        'mapas' : dadosDoMapa
    };

    if (!$('#mapa').is(":checked") && (!localidade || !especialista || !qtd_vagas
        || !data || !hora || !especialidade_um || !vagas_mapa1)) {
        console.log(localidade, especialista, qtd_vagas, data, hora, especialidade_um, vagas_mapa1);
        swal("O preenchimento de todos os campos são obrigatórios");

    } else if ($('#mapa').is(":checked") && (!localidade || !especialista || !qtd_vagas || !data
        || !hora || !especialidade_um || !vagas_mapa1 || !hora2 || !especialidade_dois || !vagas_mapa2)) {

        swal("O preenchimento de todos os campos são obrigatórios");
    } else if ( (parseInt(vagas_mapa1)  +  parseInt(vagas_mapa2)) > qtd_vagas) {

        swal("A quantidade de vaga dos mapas devem ser menor ou igual a quantidade de vagas total do médico para entendimento nesse dia!");
    } else {
        $.ajax({
            url: '/serbinario/calendario/store',
            data: {calendario: dados},
            dataType: "json",
            type: "POST",
            success: function (data) {
                swal('Cadastro realizado com sucesso!', "Click no botão abaixo!", 'success');
                location.href = "/serbinario/calendario/index/" + idEspecialista;
            }
        });
    }
});

//Editar agenda
$("#edit").click(function (event) {
    event.preventDefault();
    var mapa = $('#mapa').is(":checked") == true ? '1' : '0';

    // Pegando os valores do formulário
    var mapa = $('#mapa').is(":checked") == true ? '1' : '0';
    var localidade          = $('#localidades').val();
    var especialista        = $('#especialista_id').val();
    var qtd_vagas           = $('#qtd_vagas').val();
    var data                = $('#data').val();
    var hora                = $('#hora').val();
    var hora2               = $('#hora2').val();
    var vagas_mapa1         = $('#vagas_mapa1').val();
    var vagas_mapa2         = $('#vagas_mapa2').val();
    var especialidade_um    = $('#especialidade_um').val();
    var especialidade_dois  = $('#especialidade_dois').val();
    var id_mapa1            = $('#id_mapa1').val();
    var id_mapa2            = $('#id_mapa2').val();

    // Setando os valores para preenchimento dos mapas
    if($('#mapa').is(":checked")) {
        var dadosDoMapa = [
            {'horario': hora, 'vagas': vagas_mapa1, 'especialidade_id': especialidade_um, 'id' : id_mapa1},
            {'horario': hora2, 'vagas': vagas_mapa2, 'especialidade_id': especialidade_dois, 'id' : id_mapa2}
        ];
    } else {
        var dadosDoMapa = [
            {'horario': hora, 'vagas': vagas_mapa1, 'especialidade_id': especialidade_um, 'id' : id_mapa1}
        ];
    }

    // Preenchendo o array de dados para requisição do formulário
    var dados = {
        'localidade_id': localidade,
        'especialista_id': especialista,
        'qtd_vagas': qtd_vagas,
        'data': data,
        'mais_mapa': mapa,
        'mapas' : dadosDoMapa
    };

    if (!$('#mapa').is(":checked") && (!localidade || !especialista || !qtd_vagas
        || !data || !hora || !especialidade_um || !vagas_mapa1)) {
        console.log(localidade, especialista, qtd_vagas, data, hora, especialidade_um, vagas_mapa1);
        swal("O preenchimento de todos os campos são obrigatórios");

    } else if ($('#mapa').is(":checked") && (!localidade || !especialista || !qtd_vagas || !data
        || !hora || !especialidade_um || !vagas_mapa1 || !hora2 || !especialidade_dois || !vagas_mapa2)) {

        swal("O preenchimento de todos os campos são obrigatórios");
    } else if ( (parseInt(vagas_mapa1)  +  parseInt(vagas_mapa2)) > qtd_vagas) {

        swal("A quantidade de vaga dos mapas devem ser menor ou igual a quantidade de vagas total do médico para entendimento nesse dia!");
    } else {
        $.ajax({
            url: "/serbinario/calendario/update/" + idCalendario,
            data: {calendario: dados},
            dataType: "json",
            type: "POST",
            success: function (data) {
                swal('Dia editado com sucesso!', "Click no botão abaixo!", 'success');
                location.href = "/serbinario/calendario/index/" + idEspecialista;
            }
        });
    }
});

// Fechar uma data da agenda
$(document).on('click', '#fechar', function (event) {
    event.preventDefault();
    swal({
        title: "Alerta",
        text: "Tem certeza que deseja fechar o dia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim!",
    }).then(function () {

        $.ajax({
            url: '/serbinario/calendario/fechar/' + idCalendario,
            dataType: "json",
            type: "GET",
            success: function (data) {
                swal('Dia fechado com sucesso!', "Click no botão abaixo!", 'success');
                location.href = "/serbinario/calendario/index/" + idEspecialista;
            }
        });
    });
});

// Bloquear uma data da agenda
$(document).on('click', '#bloquear', function (event) {
    event.preventDefault();
    swal({
        title: "Alerta",
        text: "Tem certeza que deseja bloquear o dia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim!",
    }).then(function () {

        $('#modal-bloqueio').modal({'show' : true});


    });
});

// Bloquear uma data da agenda
$(document).on('click', '#confirmarBloqueio', function (event) {
    event.preventDefault();

    var descricao = $('#descricao-bloqueio').val();

    if(descricao) {

        $.ajax({
            url: '/serbinario/calendario/bloquear',
            dataType: "json",
            type: "POST",
            data: {'id' : idCalendario, 'descricao' : descricao},
            success: function (data) {
                $('#modal-bloqueio').modal({'show': false});
                swal('Dia bloqueado com sucesso!', "Click no botão abaixo!", 'success');
                location.href = "/serbinario/calendario/index/" + idEspecialista;
            }
        });

    } else {
        swal('Informe o motivo do bloqueio!', "Click no botão abaixo!", 'success');
    }


});

//converter data
function toDate(dateStr) {
    from = dateStr.split("-");
    f = new Date(from[2], from[1] - 1, from[0]);
    return from[2] + '/' + from[1] + '/' + from[0]
}