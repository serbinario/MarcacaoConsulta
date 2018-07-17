/**
 * Created by Fabio Aguiar on 22/12/2016.
 */

//Função para listar os especialistas
function cidades() {

    //Recuperando o estado
    var estado = $("#estado option:selected").val();

    if (estado !== "") {
        var dados = {
            'table' : 'gen_cidades',
            'field_search' : 'estados_id',
            'value_search': estado
        };

        jQuery.ajax({
            type: 'POST',
            url: '/index.php/serbinario/util/search',
            data: dados,
            datatype: 'json'
    }).done(function (json) {
            var option = "";

            option += '<option value="">Selecione uma cidade</option>';
            for (var i = 0; i < json.length; i++) {
                if(json[i]['id'] == '5281') {
                    option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                } else {
                    option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                }

            }

            $('#cidade option').remove();
            $('#cidade').append(option);
        });
    }
}

//Função para listar os especialistas 5281
function bairros() {

    //Recuperando o estado
    var cidade = '5281';

    if (cidade !== "") {
        var dados = {
            'table' : 'gen_bairros',
            'field_search' : 'cidades_id',
            'value_search': cidade
        };

        jQuery.ajax({
            type: 'POST',
            url: '/index.php/serbinario/util/search',
            data: dados,
            datatype: 'json'
    }).done(function (json) {
            var option = "";

            option += '<option value="">Selecione um bairro</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }

            $('#bairro option').remove();
            $('#bairro').append(option);
        });
    }
}

//Função para listar os especialistas 5281
function especialidades() {

    //Recuperando o estado
    var tipo = $("#tipo option:selected").val();

    if (tipo !== "") {
        var dados = {
            'table' : 'age_grupo_operacoes',
            'field_search' : 'age_tipo_operacoes.id',
            'value_search': tipo,
            'tipo_search': "2"
        };

        jQuery.ajax({
            type: 'POST',
            url: '/index.php/serbinario/util/searchOperacoes',
            data: dados,
            datatype: 'json'
    }).done(function (json) {
            var option = "";

            for (var i = 0; i < json.length; i++) {
                option += '<optgroup label="' + json[i]['text'] + '">';
                for (var j = 0; j < json[i]['children'].length; j++) {
                    option += '<option data="' + json[i]['children'][j]['operacao'] + '" value="' + json[i]['children'][j]['id'] + '">'+json[i]['children'][j]['text']+'</option>';
                }
                option += '</optgroup >';
            }

            $('#especialidade optgroup').remove();
            $('#especialidade').append(option);
        });
    }
}

cidades();
bairros();
especialidades();
