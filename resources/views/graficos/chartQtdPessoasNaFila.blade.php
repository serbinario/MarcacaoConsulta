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
    </style>
@endsection

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::open(['method' => "POST"]) !!}

            <div class="block-header">
                <h2>GRÁFICO QUANTIDADE DE PESSOAS NA FILA</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $data = new \DateTime('now') ?>
                                            <label for="data_inicio">Início</label>
                                            {!! Form::text('data_inicio', null , array('class' => 'form-control date ')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $dataFinal =  isset($request['data_fim']) ? $request['data_fim'] : ""; ?>
                                            <label for="data_fim">Fim</label>
                                            {!! Form::text('data_fim', $dataFinal , array('class' => 'form-control date ')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-2">
                                    <div class=" fg-line">
                                        <label for="exame">Tipo</label>
                                        <div class="select">
                                            {!! Form::select('tipo', (['' => 'Selecione um tipo'] + $loadFields['tipooperacao']->toArray()), null, array('class' => 'form-control', 'id' => 'tipo')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-2">
                                    <div class=" fg-line">
                                        <label for="especialidade">Especialidade</label>
                                        <div class="select">
                                            {!! Form::select('especialidade', array(), null, array('class' => 'form-control', 'id' => 'especialidade')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div style="margin-top: 22px" class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <button id="search" class="btn btn-primary btn-sm m-t-10">Consultar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-12-md">
                            <div id="container" style=" margin: 0 auto"></div>
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
   <script src="{{ asset('/js/charts/chart_qtd_pessoas_na_fila.js')  }}"></script>
    <script type="text/javascript">

        //Carregando os bairros
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
                            option += '<option value="' + json[i]['children'][j]['id'] + '">'+json[i]['children'][j]['text']+'</option>';
                        }
                        option += '</optgroup >';
                    }

                    $('#especialidade optgroup').remove();
                    $('#especialidade').append(option);
                });
            }
        });

    </script>
@stop