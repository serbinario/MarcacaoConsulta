@extends('menu')

@section('css')
    <style type="text/css" class="init">

        body {
            font-family: arial;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table, tr, td {
            font-size: small;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: small;
        }

        th {
            background-color:#CCC;
            font-size: 12px;
            color:#484848;
            padding-left:4px;
            padding-right:4px;
            border-bottom:solid 1px #CCC;
            height:26px;
            padding-right:5px;

        }
        tr:nth-child(odd) {
            background-color:#F3F3F3;
        }

        tr:nth-child(even) {
            background-color:#FFF;

        }

        tr, td {
            height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            /*white-space:nowrap;*/
            border-bottom:solid 1px #E1E1E1;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('message') !!}</em>
                    </div>
                @endif

                @if(Session::has('errors'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::open(['route'=>'serbinario.tabelas.procedimentos', 'method' => "POST", 'id'=> 'formDemanda' ]) !!}

            <div class="block-header">
                <h2>TABELA DE ASSUNTO E SUBASSUNTOS</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="tipo">Tipo operação</label>
                                            {!! Form::select('tipo',(["" => "Selecione"] + $loadFields['tipooperacao']->toArray()), null,
                                            array('class' => 'form-control', 'id' => 'tipo')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="operacao">Operação</label>
                                            {!! Form::select('operacao',array(), null, array('class' => 'form-control', 'id' => 'operacao')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="situacao">Situação</label>
                                            {!! Form::select('situacao',(["" => "Selecione"] + $loadFields['statusagendamento']->toArray()), null,
                                            array('class' => 'form-control', 'id' => 'situacao')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $data = new \DateTime('now') ?>
                                            <?php $dataInicio =  isset($request['data_inicio']) ? $request['data_inicio'] : ""; ?>
                                            <label for="data_inicio">Início</label>
                                            {!! Form::text('data_inicio', $dataInicio , array('class' => 'form-control date')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $dataFinal =  isset($request['data_fim']) ? $request['data_fim'] : ""; ?>
                                            <label for="data_fim">Fim</label>
                                            {!! Form::text('data_fim', $dataFinal , array('class' => 'form-control date')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table compact table-condensed">
                                    <thead>
                                    <tr style="background-color: #e7ebe9">
                                        <th colspan="2"  style="text-align: center">
                                            Procedimento: @if(isset($procedimentoFirst)) {{$procedimentoFirst->nome}} @endif</th>
                                    </tr>
                                    <tr>
                                        <th>Subprocedimento</th>
                                        <th>Quantidade de pessoas
                                            - @if(isset($situacaoFirst) && $situacaoFirst)
                                                {{ $situacaoFirst->nome }}
                                            @else
                                                  GERAL
                                            @endif
                                        </th>
                                    </tr>
                                    </thead>
                                    @if(isset($rows))
                                        <tbody>
                                        @foreach($rows as $row)
                                            <tr>
                                                <td>{{$row->suboperacao}} </td>
                                                <td>
                                                    {{$row->qtd}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr style="background-color: #f1f3f2">
                                            <td>Total geral</td>
                                            <td>{{$totalAgendamentos}}</td>
                                        </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>
@stop
@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_especialidade.js')}}"></script>
    <script type="text/javascript">

        //Carregando os bairros
        $(document).on('change', "#tipo", function () {
            //Removendo as Bairros
            $('#operacao option').remove();

            //Recuperando a cidade
            var tipo = $(this).val();

            if (tipo !== "") {
                var dados = {
                    'table' : 'age_grupo_operacoes',
                    'field_search' : 'age_tipo_operacoes.id',
                    'value_search': tipo,
                    'tipo_search': "1"
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '/index.php/serbinario/util/searchOperacoes',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    for (var i = 0; i < json.length; i++) {
                        option += '<optgroup label="' + json[i]['text'] + '">';
                        for (var j = 0; j < json[i]['children'].length; j++) {
                            option += '<option value="' + json[i]['children'][j]['id'] + '">'+json[i]['children'][j]['text']+'</option>';
                        }
                        option += '</optgroup >';
                    }

                    $('#operacao optgroup').remove();
                    $('#operacao').append(option);
                });
            }
        });
    </script>
@stop