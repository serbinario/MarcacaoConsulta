/**
 * Created by Fabio Aguiar on 22/12/2016.
 */

//Função para listar os especialistas
function especialistas(id) {
    jQuery.ajax({
        type: 'GET',
        url: '/serbinario/especialista/byespecialidade/' + especialidadeId,
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

    if (idEspecialista) {

        // De acordo com a especialidade encontrada, é feito o carregamento dos dias do calendário
        jQuery.ajax({
            type: 'POST',
            url: '/serbinario/especialista/especialidades',
            datatype: 'json',
            data: {'idEspecialista': idEspecialista}
        }).done(function (json) {
            var option = '';

            option += '<option value="">Selecione</option>';
            for ( var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }

            $('#especialidade option').remove();
            $('#especialidade').append(option);
        });

    }

});

//Carregando os dias do calendário
$(document).on('change', "#especialidade", function () {

    var idEspecialidade  = $(this).val();
    var idEspecialista   = $("#especialista").val();

    if (idEspecialidade) {

        // De acordo com a especialidade encontrada, é feito o carregamento dos dias do calendário
        jQuery.ajax({
            type: 'POST',
            url: '/serbinario/calendario/calendarioEspecialista',
            datatype: 'json',
            data: {'idEspecialista': idEspecialista, 'idEspecialidade': idEspecialidade}
        }).done(function (json) {
            var option = '';

            option += '<option value="">Selecione</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">'  + json[i]['localidade'] + '</option>';
            }

            $('#localidade option').remove();
            $('#localidade').append(option);
        });

    }

});


//Carregando os mapas
$(document).on('change', "#localidade", function () {

    var idLocalidade = $(this).val();
    var idEspecialidade = $("#especialidade").val();

    if(idLocalidade && idEspecialidade) {

        jQuery.ajax({
            type: 'POST',
            url: '/serbinario/calendario/getCalendario',
            datatype: 'json',
            data    : {'id' : idLocalidade}
        }).done(function (json) {
            var option = '';

            option += '<option value="">Selecione</option>';

            if (json[0]['especialidade_id_um'] == idEspecialidade) {
                option += '<option value="' + json[0]['hora'] + '">' + json[0]['hora'] + '</option>';
            }

            if (json[0]['especialidade_id_dois'] == idEspecialidade) {
                option += '<option value="' + json[0]['hora2'] + '">' + json[0]['hora2'] + '</option>';
            }

            $('#horario option').remove();
            $('#horario').append(option);
        });

    }

});