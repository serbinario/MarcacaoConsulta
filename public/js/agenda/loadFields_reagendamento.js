/**
 * Created by Fabio Aguiar on 22/12/2016.
 */

//Função para listar os especialistas
function especialistas(id) {
    jQuery.ajax({
        type: 'GET',
        url: '/index.php/serbinario/especialista/byespecialidade/' + especialidadeId,
        datatype: 'json'
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#especialista option').remove();
        $('#especialista').append(option);
    });
}

//Carregando os dias do calendário
$(document).on('change', "#especialista", function () {

    var idEspecialista  = $(this).val();

    if(idEspecialista) {

        // Busca a especialidade do especialista por relacionamento especialista_especialidade
        jQuery.ajax({
            type: 'POST',
            url: '/serbinario/especialista/especialidadesEspecificas',
            datatype: 'json',
            data    : {'idEspecialista' : idEspecialista, 'idEspecialidade' : especialidadeId}
        }).done(function (json) {

            // De acordo com a especialidade encontrada, é feito o carregamento dos dias do calendário
            jQuery.ajax({
                type: 'POST',
                url: '/serbinario/calendario/calendarioEspecialista',
                datatype: 'json',
                data    : {'idEspecialista' : idEspecialista, 'idEspecialidade' : json[0]['id']}
            }).done(function (json) {
                var option = '';

                option += '<option value="">Selecione</option>';
                for (var i = 0; i < json.length; i++) {
                    option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + " - " + json[i]['localidade'] + '</option>';
                }

                $('#calendario-reagendar option').remove();
                $('#calendario-reagendar').append(option);
            });

            $('#especialidade-reagendar').val(json[0]['id']);
        });

    }

});


//Carregando os mapas
$(document).on('change', "#calendario-reagendar", function () {

    var idCalendario = $(this).val();
    var idEspecialidade = $("#especialidade-reagendar").val();

    if(idCalendario) {

        jQuery.ajax({
            type: 'POST',
            url: '/serbinario/calendario/getCalendario',
            datatype: 'json',
            data    : {'id' : idCalendario, 'especialidadeId' : idEspecialidade}
        }).done(function (json) {
            var option = '';

            option += '<option value="">Selecione</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['horario'] + '</option>';
            }


            $('#mapa-reagendar option').remove();
            $('#mapa-reagendar').append(option);
        });

    } else {

    }

});

//Buscando as vagas disponíveis
$(document).on('change', "#mapa-reagendar", function () {

    var mapa         = $(this).val();
    var idCalendario = $("#calendario-reagendar").val();

    if(mapa && idCalendario) {

        var dados = {
            'mapa' : mapa,
            'idCalendario' : idCalendario
        };

        jQuery.ajax({
            type: 'POST',
            url: '/index.php/serbinario/calendario/getVagasByMapa',
            datatype: 'json',
            data    : dados
        }).done(function (json) {

            $('#total-vagas').val(json['totalVagas']);
            $('#vagas-restantes').val(json['vagasRestantes']);

            // Preenchendo as variáveis globais
            totalVagas = json['totalVagas'];
            vagasRestantes = json['vagasRestantes'];

            if (vagasRestantes < idsPacientes.length) {

                // Desabilitando o botão de agendar de acordo com o perfil do usuário
                if (perfil == '1') {
                    $('#reagendar').prop('disabled', false);
                } else if (perfil == '2') {
                    $('#reagendar').prop('disabled', true);
                }

                // Deixando oculto a mensagem de alerta para limite de vagas
                $('.msg').show();
            } else {
                // Desabilitando o botão de reagendas
                $('#reagendar').prop('disabled', false);

                // Deixando oculto a mensagem de alerta para limite de vagas
                $('.msg').hide();
            }

        });

    }

});