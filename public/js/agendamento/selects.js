/**
 * Created by fabio on 04/04/16.
 */

//Função para listar as localidades
function localidade(id) {
    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/localidade/all",
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

//Função para listar as psfs
function psfs(id) {

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/serbinario/ps/all",
        datatype: 'json',
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione o posto de saúde</option>';
        for (var i = 0; i < json['psfs'].length; i++) {
            if (json['psfs'][i]['id'] == id) {
                option += '<option selected value="' + json['psfs'][i]['id'] + '">' + json['psfs'][i]['nome'] + '</option>';
            } else {
                option += '<option value="' + json['psfs'][i]['id'] + '">' + json['psfs'][i]['nome'] + '</option>';
            }
        }

        $('#psf option').remove();
        $('#psf').append(option);
    });
}

//Função para listar as especialista
function especialistas(idEspecialidade, id) {

    jQuery.ajax({
        type: 'POST',
        url: "/serbinario/especialista/byespecialidade",
        datatype: 'json',
        data: {
            'especialidade': idEspecialidade
        }
    }).done(function (json) {
        var option = '';

        option += '<option value="">Selecione o especialista</option>';
        for (var i = 0; i < json['especialistas'].length; i++) {
            if (json['especialistas'][i]['id'] == id) {
                option += '<option selected value="' + json['especialistas'][i]['id'] + '">' + json['especialistas'][i]['get_cgm']['nome'] + '</option>';
            } else {
                option += '<option value="' + json['especialistas'][i]['id'] + '">' + json['especialistas'][i]['get_cgm']['nome'] + '</option>';
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
            type: 'POST',
            url: "/index.php/serbinario/especialista/byespecialidade",
            datatype: 'json',
            data: {
                'especialidade': idEspecialidade
            }
        }).done(function (json) {
            var option = '';

            option += '<option value="">Selecione o especialista</option>';
            for (var i = 0; i < json['especialistas'].length; i++) {
                if (json['especialistas'][i]['id'] == id) {
                    option += '<option selected value="' + json['especialistas'][i]['id'] + '">' + json['especialistas'][i]['nome'] + '</option>';
                } else {
                    option += '<option value="' + json['especialistas'][i]['id'] + '">' + json['especialistas'][i]['nome'] + '</option>';
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
            'table': 'grupo_operacoes',
            'field_search': 'tipo_operacoes.id',
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

//consulta via select2 cgm
/*function cgm() {
    $("#cgm").select2({
        placeholder: 'Selecione um cgm',
        minimumInputLength: 3,
        width: 400,
        ajax: {
            type: 'POST',
            url: laroute.route('serbinario.util.select2Agenda'),
            dataType: 'json',
            delay: 250,
            crossDomain: true,
            data: function (params) {
                return {
                    'search': params.term, // search term
                    'tableName': 'cgm',
                    'fieldName': 'nome',
                    /!*'fieldWhere':  'nivel',
                     'valueWhere':  '3',*!/
                    'page': params.page
                };
            },
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
            processResults: function (data, params) {

                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            }
        }
    });
}*/

//tipoOperacoes();
//localidade();
especialidade();
psfs();
