/**
 * Created by Fabio on 30/05/2017.
 */

//Função para listar as localidades
function localidade(id) {
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/localidade/all",
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione uma unidade de atendimento</option>';
        for (var i = 0; i < json['localidades'].length; i++) {
            if (json['localidades'][i]['id'] == id) {
                option += '<option selected value="' + json['localidades'][i]['id'] + '">' + json['localidades'][i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json['localidades'][i]['id'] + '">' + json['localidades'][i]['nome'] + '</option>';
            }
        }

        $('#localidades option').remove();
        $('#localidades').append(option);
    });
}

//Função para listar as especialidades do mapa 1
function especialidadesUm(id, idEspecialista) {
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/especialista/especialidades",
        datatype: 'json',
        data: {'idEspecialista': idEspecialista}
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione uma especialidade</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#especialidade_um option').remove();
        $('#especialidade_um').append(option);
    });
}

//Função para listar as especialidades do mapa 2
function especialidadesDois(id, idEspecialista) {
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/especialista/especialidades",
        datatype: 'json',
        data: {'idEspecialista': idEspecialista}
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione uma especialidade</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#especialidade_dois option').remove();
        $('#especialidade_dois').append(option);
    });
}

//Função para listar as especialidades do mapa 1
function especialidadesSearchGrid(id, idEspecialista) {
    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/especialista/especialidades",
        datatype: 'json',
        data: {'idEspecialista': idEspecialista}
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione uma especialidade</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#especialidade-grid option').remove();
        $('#especialidade-grid').append(option);
    });
}