/**
 * Created by fabio on 04/04/16.
 */

//Função para listar as localidades
function localidade(id) {
    jQuery.ajax({
        type: 'POST',
        url: "index.php/serbinario/localidade/all",
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione a localidade</option>';
        for (var i = 0; i < json['localidades'].length; i++) {
            if (json['localidades'][i]['id'] == id) {
                option += '<option selected value="' + json['localidades'][i]['id'] + '">' + json['localidades'][i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json['localidades'][i]['id'] + '">' + json['localidades'][i]['nome'] + '</option>';
            }
        }

        $('#localidade option').remove();
        $('#localidade').append(option);
    });
}

//Função para listar as localidades
function especialidade(id) {
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/especialidade/all",
        datatype: 'json'
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione a especialidade</option>';
        for (var i = 0; i < json['especialidades'].length; i++) {
            if (json['especialidades'][i]['id'] == id) {
                option += '<option selected value="' + json['especialidades'][i]['id'] + '">' + json['especialidades'][i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json['especialidades'][i]['id'] + '">' + json['especialidades'][i]['nome'] + '</option>';
            }
        }

        $('#especialidade option').remove();
        $('#especialidade').append(option);
    });
}

//Função para listar as especialista
function especialistas(idEspecialidade, id) {

    jQuery.ajax({
        type: 'GET',
        url: "/index.php/serbinario/especialista/byespecialidade/"+idEspecialidade,
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione o especialista</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['get_cgm']['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['get_cgm']['nome'] + '</option>';
            }
        }

        $('#especialista option').remove();
        $('#especialista').append(option);
    });
}


//Carregando os especialistas
$(document).on('change', "#grupo_operacao", function () {
    //Removendo as Bairros
    $('#especialista option').remove();

    //Recuperando a cidade
    var idEspecialidade = $(this).val();

    if (idEspecialidade !== "") {

        jQuery.ajax({
            type: 'GET',
            url: "/index.php/serbinario/especialista/byespecialidade/"+idEspecialidade,
            datatype: 'json',
        }).done(function (json) {
            var option = '';

            option += '<option value="">Selecione o especialista</option>';
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
});

//Função para listar as especialista
function tipoOperacoes(id) {

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/agendamento/getTipoOperacao",
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione um tipo</option>';
        for (var i = 0; i < json['tipoOperacoes'].length; i++) {
            if (json['tipoOperacoes'][i]['id'] == id) {
                option += '<option selected value="' + json['tipoOperacoes'][i]['id'] + '">' + json['tipoOperacoes'][i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json['tipoOperacoes'][i]['id'] + '">' + json['tipoOperacoes'][i]['nome'] + '</option>';
            }
        }

        $('#tipo_operacao option').remove();
        $('#tipo_operacao').append(option);
    });
}

//Carregando as especialidades
$(document).on('change', "#tipo_operacao", function () {
    //Removendo as Bairros
    $('#grupo_operacao option').remove();

    //Recuperando a cidade
    var tipo = $(this).val();

    if (tipo !== "") {
        var dados = {
            'table': 'age_grupo_operacoes',
            'field_search': 'age_tipo_operacoes.id',
            'value_search': tipo,
            'tipo_search': "2"
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/serbinario/util/searchOperacoes",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            var option = "";

            option += '<option value="">Selecione uma especialidade</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<optgroup label="' + json[i]['text'] + '">';
                for (var j = 0; j < json[i]['children'].length; j++) {
                    option += '<option value="' + json[i]['children'][j]['id'] + '">' + json[i]['children'][j]['text'] + '</option>';
                }
                option += '</optgroup >';
            }

            $('#grupo_operacao optgroup').remove();
            $('#grupo_operacao').append(option);
        });
    }
});

//Função para listar os pacientes
function paciente(id, especialidade) {

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/agendamento/getPacientes",
        datatype: 'json',
        data: {'especialidade' : especialidade}
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione um paciente</option>';
        for (var i = 0; i < json['pacientes'].length; i++) {
            if (json['pacientes'][i]['id'] == id) {
                option += '<option selected value="' + json['pacientes'][i]['id'] + '">' + json['pacientes'][i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json['pacientes'][i]['id'] + '">' + json['pacientes'][i]['nome'] + '</option>';
            }
        }

        $('#paciente option').remove();
        $('#paciente').append(option);
    });
}

especialidade();
