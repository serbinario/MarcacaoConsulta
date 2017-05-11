<div class="block-header">
    <h2>Cadastro Geral Municipal</h2>
</div>

<div class="card">
    <div class="card-body card-padding">

        <div role="tabpanel" class="tab">
            <ul class="tab-nav" role="tablist">
                <li class="active"><a href="#dpessoais" aria-controls="dpessoais" role="tab" data-toggle="tab"
                                      aria-expanded="true">Dados pessoais</a></li>
                <li role="presentation" class=""><a href="#doc" aria-controls="doc" role="tab" data-toggle="tab"
                                                    aria-expanded="false">Documentação</a></li>
                <li role="presentation" class=""><a href="#end" aria-controls="end" role="tab" data-toggle="tab"
                                                    aria-expanded="false">Endereço</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane animated fadeInRight active" id="dpessoais">
                    <br/>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class="fg-line">
                                <label class="control-label" for="nome">Nome *</label>
                                {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control input-sm', 'placeholder' => 'Número completo')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="fg-line">
                                <label class="control-label" for="data_nascimento">Data Nascimento *</label>
                                {!! Form::text('data_nascimento', Session::getOldInput('data_nascimento') , array('class' => 'form-control input-sm date', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="sexo">Sexo *</label>
                                <div class="select">
                                    {!! Form::select('sexo', $loadFields['sexo'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="estado_civil">Estado Civil</label>

                                <div class="select">
                                    {!! Form::select('estado_civil', $loadFields['estadocivil'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="nacionalidade">Nacionalidade</label>

                                <div class="select">
                                    {!! Form::select('nacionalidade', $loadFields['nacionalidade'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <div class=" fg-line">
                                <label for="naturalidade">Naturalidade</label>

                                <div class="select">
                                    {!! Form::select('naturalidade', $loadFields['nacionalidade'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class=" fg-line">
                                <label for="pai">Nome do pai</label>

                                <div class="select">
                                    {!! Form::text('pai', Session::getOldInput('pai') , array('class' => 'form-control input-sm', 'placeholder' => 'Nome do pai')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <div class=" fg-line">
                                <label for="mae">Nome da Mãe</label>
                                {!! Form::text('mae', Session::getOldInput('mae') , array('class' => 'form-control input-sm', 'placeholder' => 'Nome da mãe')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <div class="fg-line">
                                <label class="control-label" for="fone">Telefone 1 *</label>
                                {!! Form::text('fone', Session::getOldInput('fone') , array('class' => 'form-control telefone input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="fg-line">
                                <label class="control-label" for="fone2">Telefone 2</label>
                                {!! Form::text('fone2', Session::getOldInput('fone2') , array('class' => 'form-control telefone input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="fg-line">
                                <label class="control-label" for="fone3">Telefone 3</label>
                                {!! Form::text('fone3', Session::getOldInput('fone3') , array('class' => 'form-control telefone input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <div class=" fg-line">
                                <label for="escolaridade">Escolaridade</label>

                                <div class="select">
                                    {!! Form::select('escolaridade', $loadFields['escolaridade'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class=" fg-line">
                                <label for="cgmmunicipio">Cidadão do município? *</label>

                                <div class="select">
                                    {!! Form::select('cgmmunicipio', $loadFields['cgmmunicipio'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="fg-line">
                                <label class="control-label" for="data_falecimento">Data Falecimento</label>
                                {!! Form::text('data_falecimento', Session::getOldInput('data_falecimento') , array('class' => 'form-control input-sm date', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <div class=" fg-line">
                                <label for="email">E-mail</label>
                                {!! Form::text('email', Session::getOldInput('email') , array('class' => 'form-control input-sm', 'placeholder' => 'Endereço eletrônico')) !!}
                            </div>
                        </div>
                    </div>

                </div>
                <div role="tabpanel" class="tab-pane animated fadeInRight" id="doc">
                    <br/>

                    <div class="row">
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="cpf_cnpj">CPF *</label>
                                {!! Form::text('cpf_cnpj', Session::getOldInput('cpf_cnpj') , array('class' => 'form-control cpf input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="rg">RG *</label>
                                {!! Form::text('rg', Session::getOldInput('rg') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="orgao_emissor">Orgão Emissor</label>
                                {!! Form::text('orgao_emissor', Session::getOldInput('orgao_emissor') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="data_expedicao">Data Expedição</label>
                                {!! Form::text('data_expedicao', Session::getOldInput('data_expedicao') , array('class' => 'form-control  date', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="numero_sus">Número do SUS *</label>
                                {!! Form::text('numero_sus', Session::getOldInput('numero_sus') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="numero_nis">Número NIS *</label>
                                {!! Form::text('numero_nis', Session::getOldInput('numero_nis') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="num_cnh">Número CNH</label>
                                {!! Form::text('num_cnh', Session::getOldInput('num_cnh') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="categoria_cnh">Categoria CNH</label>

                                <div class="select">
                                    {!! Form::select('categoria_cnh', $loadFields['categoriacnh'], null, array('class'=> 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="venci_cnh">Vencimento CNH</label>
                                {!! Form::text('venci_cnh', Session::getOldInput('venci_cnh') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="numero_titulo">Número do Título</label>
                                {!! Form::text('numero_titulo', Session::getOldInput('numero_titulo') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="numero_zona">Zona</label>
                                {!! Form::text('numero_zona', Session::getOldInput('numero_zona') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="numero_sessao">Sessão</label>
                                {!! Form::text('numero_sessao', Session::getOldInput('numero_sessao') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane animated fadeInRight" id="end">
                    <br/>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <div class=" fg-line">
                                <label for="logradouro">Logradouro *</label>
                                {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="end_numero">Número *</label>
                                {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="endereco[comp]">Comple.</label>
                                {!! Form::text('endereco[comp]', Session::getOldInput('endereco[comp]') , array('class' => 'form-control input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class=" fg-line">
                                <label for="cep">CEP</label>
                                {!! Form::text('endereco[cep]', Session::getOldInput('endereco[cep]') , array('class' => 'form-control cep input-sm', 'placeholder' => '')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <div class=" fg-line">
                                <label for="estado">UF *</label>

                                <div class="select">
                                    @if(isset($model->endereco->bairros->cidade->estado->id))
                                        {!! Form::select('estado', $loadFields['estado'], $model->endereco->bairros->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                                    @else
                                        {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class=" fg-line">
                                <label for="cidade">Cidade *</label>

                                <div class="select">
                                    @if(isset($model->endereco->bairros->cidade->id))
                                        {!! Form::select('cidade', array($model->endereco->bairros->cidade->id => $model->endereco->bairros->cidade->nome), $model->endereco->bairros->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                                    @else
                                        {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class=" fg-line">
                                <label for="endereco[bairro]">Bairro *</label>

                                <div class="select">
                                    @if(isset($model->endereco->bairros->id))
                                        {!! Form::select('endereco[bairro]', array($model->endereco->bairros->id => $model->endereco->bairros->nome), $model->endereco->bairros->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                    @else
                                        {!! Form::select('endereco[bairro]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('serbinario.cgm.index') }}">Voltar</a>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/validacoes/validation_form_cgm.js')}}"></script>
    <script type="text/javascript">
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

        //consulta via select2
        $("#instituicao").select2({
            placeholder: 'Selecione uma instituição',
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
                        'tableName':  'fac_instituicoes',
                        'fieldName':  'nome',
                        'fieldWhere':  'nivel',
                        'valueWhere':  '3',
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

        //consulta via select2
        $("#formacao").select2({
            placeholder: 'Selecione uma formação acadêmica',
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
                        'tableName':  'fac_cursos_superiores',
                        'fieldName':  'nome',
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
    </script>
@stop