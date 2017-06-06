@extends('menu')

@section('content')
    <section id="content">
        <div class="container">

            <div class="block-header">
                <h2>Lista de pacientes agendados</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">

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

                    <div class="row">
                        <br/>
                        {!! Form::open(['method' => "POST"]) !!}
                        <div class="col-md-12">

                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <?php $data = new \DateTime('now') ?>
                                    {!! Form::label('data_inicio', 'Início') !!}
                                    {!! Form::text('data_inicio', null , array('class' => 'form-control dateTimePicker date', 'placeholder' => 'Data inicial')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('data_fim', 'Fim') !!}
                                    {!! Form::text('data_fim', null , array('class' => 'form-control dateTimePicker date', 'placeholder' => 'Data final')) !!}
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

                            <div class="form-group col-sm-3">
                                <div class=" fg-line">
                                    <label for="exame">Exame</label>

                                    <div class="select">
                                        {!! Form::select('exame', array(), null, array('class' => 'form-control', 'id' => 'exame')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-2">
                                <div class=" fg-line">
                                    <label for="prioridade">Prioridade</label>

                                    <div class="select">
                                        {!! Form::select('prioridade', (['' => 'Selecione'] + $loadFields['prioridade']->toArray()), null, array('id' => 'prioridade', 'class'=> 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-4">
                                <div class=" fg-line">
                                    <label for="psf">PSF</label>

                                    <div class="select">
                                        {!! Form::select('psf', (['' => 'Selecione'] + $loadFields['postosaude']->toArray()), null, array('id' => 'psf', 'class'=> 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-2">
                                <div class=" fg-line">
                                    <label for="psf">Situação</label>

                                    <div class="select">
                                        {!! Form::select('situacao', (['' => 'Selecione'] + $loadFields['statusagendamento']->toArray()), null, array('id' => 'situacao', 'class'=> 'form-control')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('globalSearch', 'Pesquisar') !!}
                                    {!! Form::text('globalSearch', null , array('class' => 'form-control', 'placeholder' => 'Pesquisar...')) !!}
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <button type="submit" style="margin-top: 28px" id="search"
                                        class="btn-primary btn input-sm">Consultar
                                </button>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="card-body card-padding">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-left">
                                <button type="button" disabled id="definirAtendimento" class="btn btn-success btn-sm m-t-10">Definir Atendimento</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive no-padding">
                        <table id="agendados-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Cidadao</th>
                                <th>Especialidade</th>
                                <th>Dia</th>
                                <th>Hora</th>
                                <th>Especialista</th>
                                <th>PSF</th>
                                <th>Situação</th>
                               {{-- <th>Ação</th>--}}
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Cidadao</th>
                                <th>Especialidade</th>
                                <th>Dia</th>
                                <th>Hora</th>
                                <th>Especialista</th>
                                <th>PSF</th>
                                <th>Situação</th>
                               {{-- <th style="width: 17%;">Acão</th>--}}
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('agendamento.modal_definir_atendimento')
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('/js/agendamento/grid_pacientes_agendados.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/modal_definir_atendimento.js')}}"></script>
    <script type="text/javascript">

        // Evento para abrir o modal de telefones
        $(document).on("click", "#definirAtendimento", function () {

            // Executando o modal
            runModalDefinirAtendimento(idsPacientes);
        });

        //Carregando os bairros
        $(document).on('change', "#tipo", function () {
            //Removendo as Bairros
            $('#exame option').remove();

            //Recuperando a cidade
            var tipo = $(this).val();

            if (tipo !== "") {
                var dados = {
                    'table' : 'grupo_operacoes',
                    'field_search' : 'tipo_operacoes.id',
                    'value_search': tipo,
                    'tipo_search': "2"
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('serbinario.util.searchOperacoes')  }}',
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

                    $('#exame optgroup').remove();
                    $('#exame').append(option);
                });
            }
        });
    </script>
@stop