{{--<script type="text/javascript">--}}
    /**
     * Created by fabio on 04/04/16.
     */

//Função para listar as localidades
    function localidade(id) {
        jQuery.ajax({
            type: 'POST',
            url: '/serbinario/localidade/all',
            datatype: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
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
            url: '/serbinario/especialidade/all',
            datatype: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
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
            url: '/serbinario/ps/all',
            datatype: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
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
    function especialistas(idLocalidade, id) {

        jQuery.ajax({
            type: 'POST',
            url: '{{ route('serbinario.especialista.byespecialidade')  }}',
            datatype: 'json',
            data: {'especialidade': idLocalidade},
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
        }).done(function (json) {
            console.log(json);
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

    localidade();
    especialidade();
    psfs();

{{--
</script>--}}
