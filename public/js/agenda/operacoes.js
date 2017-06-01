/**
 * Created by Fabio on 30/05/2017.
 */

var idCalendario = "";
var idEspecialista = "";

// Tratar habilitação do mapa 2
$('#mapa').click(function () {
    if ($('#mapa').is(":checked")) {
        $('#hora2').prop('readonly', false);
        $('#especialidade_dois').prop('disabled', false);
        especialidadesDois("", idEspecialista);
    } else {
        $('#hora2').prop('readonly', true);
        $('#hora2').val("");
        $('#especialidade_dois').prop('disabled', true);
        $('#especialidade_dois option').remove();
    }
});

//Salvar agenda
$("#save").click(function (event) {
    event.preventDefault();
    var mapa = $('#mapa').is(":checked") == true ? '1' : '0';

    var dados = {
        'localidade_id': $('#localidades').val(),
        'especialista_id': $('#especialista_id').val(),
        'qtd_vagas': $('#qtd_vagas').val(),
        'data': $('#data').val(),
        'hora': $('#hora').val(),
        'hora2': $('#hora2').val(),
        'mais_mapa': mapa,
        'especialidade_id_um': $('#especialidade_um').val(),
        'especialidade_id_dois': $('#especialidade_dois').val()
    };

    if (!$('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val()
        || !$('#data').val() || !$('#hora').val() || !$('#especialidade_um').val())) {
        swal("O preenchimento de todos os campos são obrigatórios");
    } else if ($('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val() || !$('#data').val()
        || !$('#hora').val() || !$('#especialidade_um').val() || !$('#hora2').val() || !$('#especialidade_dois').val())) {
        swal("O preenchimento de todos os campos são obrigatórios")
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
    console.log(idCalendario);
    var dados = {
        'localidade_id': $('#localidades').val(),
        'especialista_id': $('#especialista_id').val(),
        'qtd_vagas': $('#qtd_vagas').val(),
        'data': $('#data').val(),
        'hora': $('#hora').val(),
        'hora2': $('#hora2').val(),
        'mais_mapa': mapa,
        'id': $('#id').val(),
        'especialidade_id_um': $('#especialidade_um').val(),
        'especialidade_id_dois': $('#especialidade_dois').val()
    };

    if (!$('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val()
        || !$('#data').val() || !$('#hora').val() || !$('#especialidade_um').val())) {
        swal("O preenchimento de todos os campos são obrigatórios")
    } else if ($('#mapa').is(":checked") && (!$('#localidades').val() || !$('#especialista_id').val() || !$('#qtd_vagas').val() || !$('#data').val()
        || !$('#hora').val() || !$('#especialidade_um').val() || !$('#hora2').val() || !$('#especialidade_dois').val())) {
        swal('O preenchimento de todos os campos são obrigatórios');
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

        $.ajax({
            url: '/serbinario/calendario/bloquear/' + idCalendario,
            dataType: "json",
            type: "GET",
            success: function (data) {
                swal('Dia bloqueado com sucesso!', "Click no botão abaixo!", 'success');
                location.href = "/serbinario/calendario/index/" + idEspecialista;
            }
        });
    });
});

//converter data
function toDate(dateStr) {
    from = dateStr.split("-");
    f = new Date(from[2], from[1] - 1, from[0]);
    return from[2] + '/' + from[1] + '/' + from[0]
}