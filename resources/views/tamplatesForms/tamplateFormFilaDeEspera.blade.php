<div class="block-header">
    <h2>Cadastro de Fila de Espera</h2>
</div>

<div class="card">
    <div class="card-body card-padding">

        {{--#1--}}
        <div class="row">
            @if(!isset($model))
                <div class="form-group col-sm-4">
                    <div class=" fg-line">
                        <label for="cgm_id">Cidadão</label>
                        <div class="select">
                            {!! Form::select('cgm_id', ['' => 'Selecione um cidadão'] + $loadFields['cgm']->toArray(), Session::getOldInput('cgm_id'), array('class' => 'form-control', 'id' => 'paciente')) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{--#2--}}
        <div class="row">
            <div class="form-group col-sm-4">
                <div class="fg-line">
                    <label class="control-label" for="cgm[nome]">Cidadão *</label>
                    {!! Form::text('cgm[nome]', Session::getOldInput('cgm[nome]')  , array('id' => 'nome', 'class' => 'form-control input-sm', 'placeholder' => 'Nome')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="cgm[data_nascimento]">Data de Nascimento</label>
                    {!! Form::text('cgm[data_nascimento]', Session::getOldInput('cgm[data_nascimento]')  , array('class' => 'form-control dateTimePicker input-sm date', 'id' => 'data_nascimento', 'placeholder' => 'Data de Nascimento')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="cgm[idade]">Idade</label>
                    {!! Form::text('cgm[idade]', Session::getOldInput('cgm[idade]')  , array('class' => 'form-control input-sm', 'id' => 'idade',  'placeholder' => 'Idade')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="data">Data do cadastro *</label>
                    {!! Form::text('data', Session::getOldInput('data') , array('class' => 'form-control input-sm dateTimePicker date', 'placeholder' => 'Data do cadastro')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class=" fg-line">
                    <label for="prioridade_id">Prioridade *</label>
                    <div class="select">
                        {!! Form::select('prioridade_id', $loadFields['prioridade'], null, array('id' => 'prioridade', 'class'=> 'form-control')) !!}
                    </div>
                </div>
            </div>
        </div>

        {{--#3--}}
        <div class="row">
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="tipo">Tipo *</label>
                    @if(isset($model->especialidade->operacao->grupo->tipo->id))
                        {!! Form::select('tipo', $loadFields['tipooperacao'], $model->especialidade->operacao->grupo->tipo->id, array('class' => 'form-control imput-sm', 'id' => 'tipo')) !!}
                    @else
                        {!! Form::select('tipo', (['' => 'Selecione um tipo'] + $loadFields['tipooperacao']->toArray()), null, array('class' => 'form-control imput-sm', 'id' => 'tipo')) !!}
                    @endif
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="fg-line">
                    <label class="control-label" for="especialidade">Operação *</label>
                    <div class="select">
                        @if(isset($model->especialidade->operacao->id))
                            {!! Form::select('especialidade_id', array($model->especialidade->id => $model->especialidade->operacao->nome), $model->especialidade->id, array('class' => 'form-control', 'id' => 'especialidade')) !!}
                        @else
                            {!! Form::select('especialidade_id', array(), Session::getOldInput('especialidade_id'),array('class' => 'form-control', 'id' => 'especialidade')) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="fg-line">
                    <label class="control-label" for="sub_operacoes_id">Suboperação</label>
                    <div class="select">
                        <select multiple class="form-control" id="sub_operacoes_id" name="sub_operacoes[]">
                            @if(isset($model->id))
                                @foreach($loadFields['suboperacao'] as $key => $value)
                                    <option value="{{$key}}"
                                            @foreach($model->suboperacoes->lists('id') as $c) @if($key == $c)selected="selected"@endif @endforeach>{{$value}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="cgm[numero_sus]">Número do SUS *</label>
                    {!! Form::text('cgm[numero_sus]', Session::getOldInput('cgm[numero_sus]') , array('id' => 'numero_sus', 'class' => 'form-control input-sm', 'placeholder' => 'Número do SUS')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class=" fg-line">
                    <label for="cgm[numero_nis]">Número NIS</label>
                    {!! Form::text('cgm[numero_nis]', Session::getOldInput('cgm[numero_nis]') , array('id' => 'numero_nis', 'class' => 'form-control input-sm', 'placeholder' => '')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class=" fg-line">
                    <label for="cpf_cnpj">CPF</label>
                    {!! Form::text('cgm[cpf_cnpj]', Session::getOldInput('cgm[cpf_cnpj]') , array('id' => 'cpf_cnpj', 'class' => 'form-control cpf input-sm', 'placeholder' => '')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class=" fg-line">
                    <label for="rg">RG</label>
                    {!! Form::text('cgm[rg]', Session::getOldInput('cgm[rg]') , array('id' => 'rg', 'class' => 'form-control input-sm', 'placeholder' => '')) !!}
                </div>
            </div>
        </div>
        {{--#3--}}
        <div class="row">
            <div class="form-group col-sm-6">
                <div class="fg-line">
                    <label class="control-label" for="logradouro">Logradouro</label>
                    {!! Form::text('cgm[endereco][logradouro]', Session::getOldInput('cgm[endereco][logradouro]')  , array('class' => 'form-control input-sm', 'id' => 'logradouro',  'placeholder' => 'Logradouro')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="numero">Número</label>
                    {!! Form::text('cgm[endereco][numero]', Session::getOldInput('endereco[endereco][numero]'), array('class' => 'form-control input-sm', 'id' => 'numero',  'placeholder' => 'Número')) !!}
                </div>
            </div>
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="cgm[fone]">Telefone</label>
                    {!! Form::text('cgm[fone]', Session::getOldInput('cgm[fone]')  , array('class' => 'form-control telefone input-sm', 'id' => 'fone',  'placeholder' => 'Telefone')) !!}
                </div>
            </div>
        </div>
        {{--#4--}}
        <div class="row">
            <div class="form-group col-sm-2">
                <div class="fg-line">
                    <label class="control-label" for="estado">UF</label>
                    <div class="select">
                        @if(isset($model->cgm->endereco->bairros->cidade->estado->id))
                            {!! Form::select('estado', $loadFields['estado'], $model->cgm->endereco->bairros->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                        @else
                            {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="fg-line">
                    <label class="control-label" for="cidade">Cidade</label>
                    <div class="select">
                        @if(isset($model->cgm->endereco->bairros->cidade->id))
                            {!! Form::select('cidade', array($model->cgm->endereco->bairros->cidade->id => $model->cgm->endereco->bairros->cidade->nome), $model->cgm->endereco->bairros->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                        @else
                            {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="fg-line">
                    <label class="control-label" for="bairro">Bairro</label>
                    <div class="select">
                        @if(isset($model->cgm->endereco->bairros->id))
                            {!! Form::select('cgm[endereco][bairro_id]', array($model->cgm->endereco->bairros->id => $model->cgm->endereco->bairros->nome), $model->cgm->endereco->bairros->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                        @else
                            {!! Form::select('cgm[endereco][bairro_id]', array(), Session::getOldInput('cgm[endereco][bairro_id]'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class=" fg-line">
                    <label for="posto_saude_id">PSF</label>
                    <div class="select">
                        {!! Form::select('posto_saude_id', (['' => 'Selecione um psf'] + $loadFields['postosaude']->toArray()), null, array('id' => 'psf', 'class'=> 'form-control')) !!}
                    </div>
                </div>
            </div>
        </div>
        {{--#5--}}
        <div class="row">
            <div class="form-group col-md-12">
                <div class=" fg-line">
                    <label for="preparo">Observaçâo</label>
                    {!! Form::textarea('observacao', Session::getOldInput('observacao'),
                        array('class' => 'form-control input-sm', 'rows' => '4','placeholder' => 'Adicione uma observação')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.fila.index') }}">Voltar</a>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_fila.js')}}"></script>
    <script type="text/javascript">

        //consulta via cgm
        $("#paciente").select2({
            placeholder: 'Selecione um cidadão',
            minimumInputLength: 3,
            width: 300,
            ajax: {
                type: 'POST',
                url: "{{ route('serbinario.util.select2FilaDeEspera')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search':     params.term, // search term
                        'tableName':  'gen_cgm',
                        'fieldName':  'nome',
                        //'fieldWhere':  'nivel',
                        //'valueWhere':  '3',
                        'page':       params.page
                    };
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
                    'table' : 'gen_cidades',
                    'field_search' : 'estados_id',
                    'value_search': estado,
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.search')  }}',
                    data: dados,
                    datatype: 'json',
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
                    'table' : 'gen_bairros',
                    'field_search' : 'cidades_id',
                    'value_search': cidade,
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.search')  }}',
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

                    $('#nome').val(json['cidadao']['nome']);
                    console.log(json['cidadao']['numero_sus'])
                    $('#numero_sus').val(json['cidadao']['numero_sus']);
                    $('#data_nascimento').val(json['cidadao']['data_nascimento']);
                    $('#idade').val(json['cidadao']['idade']);
                    $('#fone').val(json['cidadao']['fone']);
                    $('#logradouro').val(json['cidadao']['logradouro']);
                    $('#numero').val(json['cidadao']['numero']);
                    $('#cpf_cnpj').val(json['cidadao']['cpf_cnpj']);
                    $('#rg').val(json['cidadao']['rg']);
                    $('#numero_nis').val(json['cidadao']['numero_nis']);

                    $( "#estado option" ).each(function() {
                        if($(this).val() == json['cidadao']['estado']) {
                            $(this).prop('selected', true);
                        }
                    });

                    if(json['cidadao']['cidade_id']) {
                        var option = '<option value="' + json['cidadao']['cidade_id'] + '">' + json['cidadao']['cidade'] + '</option>';
                        $('#cidade option').remove();
                        $('#cidade').append(option);
                    }

                    if(json['cidadao']['bairro_id']) {
                        var option = '<option value="' + json['cidadao']['bairro_id'] + '">' + json['cidadao']['bairro'] + '</option>';
                        $('#bairro option').remove();
                        $('#bairro').append(option);
                    }

                });
            }
        });

        //Carregando as especialidades (operações)
        $(document).on('change', "#tipo", function () {
            //Removendo as Bairros
            $('#especialidade option').remove();

            //Recuperando a cidade
            var tipo = $(this).val();

            if (tipo !== "") {
                var dados = {
                    'table' : 'age_grupo_operacoes',
                    'field_search' : 'age_tipo_operacoes.id',
                    'value_search': tipo,
                    'tipo_search': "2"
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.searchOperacoes')  }}',
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
        });

        $("#sub_operacoes_id").select2({
            placeholder: "Selecione",
            width: 500
        });

        //Carregando os bairros
        $(document).on('change', "#especialidade", function () {
            // Removendo as Bairros
            $('#sub_operacoes_id option').remove();

            // Recuperando a cidade
            var operacao = $("#especialidade option:selected").attr('data');

            console.log(operacao);

            if (operacao !== "") {

                var dados = {
                    'table' : 'age_sub_operacoes',
                    'field_search' : 'operacao_id',
                    'value_search': operacao
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.search')  }}',
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#sub_operacoes_id option').remove();
                    $('#sub_operacoes_id').append(option);
                });
            }
        });


    </script>
@stop