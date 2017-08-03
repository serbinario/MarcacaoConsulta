/**
 * Created by Fabio Aguiar on 22/12/2016.
 */

//Função para listar os tipos de telefones
function tipoOperacoes(id) {
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/especialista/getTipoOperacao",
        datatype: 'json'
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione um tipo</option>';
        for (var i = 0; i < json.length; i++) {
            if (json[i]['id'] == id) {
                option += '<option selected value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }
        }

        $('#tipoOperacao option').remove();
        $('#tipoOperacao').append(option);
    });
}

//Carregando as especialidades
$(document).on('change', "#tipoOperacao", function () {

    $('#especialidade optgroup').remove();

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

            for (var i = 0; i < json.length; i++) {
                option += '<optgroup label="' + json[i]['text'] + '">';
                for (var j = 0; j < json[i]['children'].length; j++) {
                    option += '<option value="' + json[i]['children'][j]['id'] + '">' + json[i]['children'][j]['text'] + '</option>';
                }
                option += '</optgroup >';
            }

            $('#especialidade optgroup').remove();
            $('#especialidade').append(option);
        });
    }
});
