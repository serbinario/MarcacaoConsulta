<div class="row">
	<div class="col-md-11">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('cgm_id', 'Cidadão ') !!}
                    {!! Form::select('cgm_id', ['' => 'Selecione um paciente'] + $loadFields['cgm']->toArray(), Session::getOldInput('cgm_id'), array('class' => 'form-control', 'id' => 'paciente')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('especialidade_id', 'Exame solicitado') !!}
                    @if(isset($model->especialidade->id))
                        {!! Form::select('especialidade_id',array($model->especialidade->id => $model->especialidade->operacao->nome), $model->especialidade->id, array('class' => 'form-control', 'id' => 'especialidade')) !!}
                    @else
                        {!! Form::select('especialidade_id', array(), Session::getOldInput('especialidade_id'), array('class' => 'form-control', 'id' => 'especialidade')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('prioridade', 'Prioridade') !!}
                    {!! Form::select('prioridade_id', $loadFields['prioridade'], null, array('class' => 'form-control', 'id' => 'prioridade')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('data', 'Data do cadastro') !!}
                    {!! Form::text('data', Session::getOldInput('data')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('cgm[nome]', 'Cidadão') !!}
                    {!! Form::text('cgm[nome]', Session::getOldInput('cgm[nome]')  , array('class' => 'form-control', 'id' => 'nome')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('cgm[nome]', 'SUS') !!}
                    {!! Form::text('cgm[numero_sus]', Session::getOldInput('cgm[numero_sus]')  , array('class' => 'form-control', 'id' => 'numero_sus')) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('cgm[data_nascimento]', 'Data de nascimento') !!}
                    {!! Form::text('cgm[data_nascimento]', Session::getOldInput('cgm[data_nascimento]')  , array('class' => 'form-control', 'id' => 'data_nascimento')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('cgm[idade]', 'Idade') !!}
                    {!! Form::text('cgm[idade]', Session::getOldInput('cgm[idade]')  , array('class' => 'form-control', 'id' => 'idade')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('logradouro', 'Endereco') !!}
                    {!! Form::text('cgm[endereco][logradouro]', Session::getOldInput('endereco[logradouro]]')  , array('class' => 'form-control', 'id' => 'logradouro')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('numero', 'Numero') !!}
                    {!! Form::text('cgm[endereco][numero]', Session::getOldInput('endereco[numero]')  , array('class' => 'form-control', 'id' => 'numero')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('cgm[fone]', 'Telefone') !!}
                    {!! Form::text('cgm[fone]', Session::getOldInput('cgm[fone]')  , array('class' => 'form-control', 'id' => 'fone')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('estado', 'UF ') !!}
                    @if(isset($model->cgm->endereco->bairros->cidade->estado->id))
                        {!! Form::select('estado', $loadFields['estado'], $model->cgm->endereco->bairros->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                    @else
                        {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('cidade', 'Cidade ') !!}
                    @if(isset($model->cgm->endereco->bairros->cidade->id))
                        {!! Form::select('cidade', array($model->cgm->endereco->bairros->cidade->id => $model->cgm->endereco->bairros->cidade->nome), $model->cgm->endereco->bairros->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @else
                        {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('bairro', 'Bairro ') !!}
                    @if(isset($model->cgm->endereco->bairros->id))
                        {!! Form::select('cgm[endereco][bairro]', array($model->cgm->endereco->bairros->id => $model->cgm->endereco->bairros->nome), $model->cgm->endereco->bairros->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                    @else
                        {!! Form::select('cgm[endereco][bairro]', array(), Session::getOldInput('cgm[endereco][bairro]'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                    @endif
                </div>
            </div>
        </div>
	</div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('serbinario.fila.index') }}" class="btn btn-primary btn-block"><i
                            class="fa fa-long-arrow-left"></i> Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript">

        //consulta via cgm
        $("#paciente").select2({
            placeholder: 'Selecione um paciente',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('serbinario.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search':     params.term, // search term
                        'tableName':  'cgm',
                        'fieldName':  'nome',
                        //'fieldWhere':  'nivel',
                        //'valueWhere':  '3',
                        'page':       params.page
                    };
                },
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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

        //consulta via especialidade
        $("#especialidade").select2({
            placeholder: 'Selecione uma especialidade',
            minimumInputLength: 3,
            width: 220,
            ajax: {
                type: 'POST',
                url: "{{ route('serbinario.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search':     params.term, // search term
                        'tableName':  'especialidade',
                        'fieldName':  'nome',
                        'joinTable':  'operacoes',
                        'joinName':  'operacao_id',
                        'page':       params.page
                    };
                },
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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

        //Carregando as cidades
        $(document).on('change', "#estado", function () {
            //Removendo as cidades
            $('#cidade option').remove();

            //Removendo as Bairros
            $('#bairro option').remove();

            //Recuperando o estado
            var estado = $(this).val();

            if (estado !== "") {
                var dados = {
                    'table' : 'cidades',
                    'field_search' : 'estados_id',
                    'value_search': estado,
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.search')  }}',
                    data: dados,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione uma cidade</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#cidade option').remove();
                    $('#cidade').append(option);
                });
            }
        });

        //Carregando os bairros
        $(document).on('change', "#cidade", function () {
            //Removendo as Bairros
            $('#bairro option').remove();

            //Recuperando a cidade
            var cidade = $(this).val();

            if (cidade !== "") {
                var dados = {
                    'table' : 'bairros',
                    'field_search' : 'cidades_id',
                    'value_search': cidade,
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.search')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
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
        });


        //Buscando os dados dos pacientes
        $(document).on('change', "#paciente", function () {

            //Recuperando a cidade
            var paciente = $(this).val();

            if (paciente !== "") {

                var dados = {
                    'paciente' : paciente
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.fila.getDadosPaciente')  }}',
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {

                    $('#nome').val(json['paciente']['nome']);
                    $('#numero_sus').val(json['paciente']['numero_sus']);
                    $('#data_nascimento').val(json['paciente']['data_nascimento']);
                    $('#idade').val(json['paciente']['idade']);
                    $('#fone').val(json['paciente']['fone']);
                    $('#logradouro').val(json['paciente']['logradouro']);
                    $('#numero').val(json['paciente']['numero']);

                    $( "#estado option" ).each(function() {
                        if($(this).val() == json['paciente']['estado']) {
                            $(this).prop('selected', true);
                        }
                    });

                    if(json['paciente']['cidade_id']) {
                        var option = '<option value="' + json['paciente']['cidade_id'] + '">' + json['paciente']['cidade'] + '</option>';
                        $('#cidade option').remove();
                        $('#cidade').append(option);
                    }

                    if(json['paciente']['bairro_id']) {
                        var option = '<option value="' + json['paciente']['bairro_id'] + '">' + json['paciente']['bairro'] + '</option>';
                        $('#bairro option').remove();
                        $('#bairro').append(option);
                    }

                });
            }
        });
    </script>
@stop