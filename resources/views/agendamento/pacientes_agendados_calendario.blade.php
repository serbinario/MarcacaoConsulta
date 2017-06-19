@extends('menu')

@section('css')
    <style type="text/css" class="init">
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            /*url('http://i.stack.imgur.com/FhHRx.gif')*/
            50% 50%
            no-repeat;
        }

        /* enquanto estiver carregando, o scroll da página estará desativado */
        body.loading {
            overflow: hidden;
        }

        /* a partir do momento em que o body estiver com a classe loading,  o modal aparecerá */
        body.loading .modal {
            display: block;
        }

    </style>
@endsection


@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            {{-- <div class="ibox-content">
             </div>--}}

            {{--<div class="block-header">
                <h2>Agendamento</h2>
            </div>--}}
            <div class="modal"></div>
            <div class="card">

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
                </div>

                <div class="card-body card-padding">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h2>FILTRO PARA PESQUISA</h2>
                                </div>
                                <div class="card-body m-t-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" id="form_agendamento">
                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        {!! Form::label('localidade', 'Unidade de Atendimento') !!}
                                                        {!! Form::select('localidade', ['' => 'Selecione'] + $loadFields['localidade']->toArray(), null, array('class' => 'form-control input-sm', 'id' => 'localidade')) !!}
                                                        <input type="hidden" name="data" id="data">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="fg-line">
                                                        {!! Form::label('localidade', 'Tipo de operação') !!}
                                                        {!! Form::select('tipo_operacao', ['' => 'Selecione'] + $loadFields['tipooperacao']->toArray(), null, array('class' => 'form-control', 'id' => 'tipo_operacao')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="fg-line">
                                                        {!! Form::label('grupo_operacao', 'Especialidade') !!}
                                                        <select class="form-control" name="grupo_operacao" id="grupo_operacao">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="fg-line">
                                                        {!! Form::label('especialista', 'Especialista') !!}
                                                        <select class="form-control" name="especialista" id="especialista">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="fg-line">
                                                        <button type="button" id="btnConsultar"
                                                                class="btn btn-primary btn-sm m-t-10">Consultar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="container container-alt">
                                <div class="block-header block-header-calendar">
                                    <h2>
                                        <span></span>
                                    </h2>

                                    <ul class="actions actions-calendar">
                                        <li><a class="calendar-next" href=""><i class="zmdi zmdi-chevron-left"></i></a></li>
                                        <li><a class="calendar-prev" href=""><i class="zmdi zmdi-chevron-right"></i></a></li>

                                        <li class="dropdown">
                                            <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                                            <ul class="dropdown-menu dm-icon pull-right">
                                                <li><a href="" data-calendar-view="month"><i class="zmdi zmdi-view-comfy active"></i> Visualizar por Mês</a></li>
                                                <li><a href="" data-calendar-view="basicWeek"><i class="zmdi zmdi-view-week"></i> Visualizar por Semana</a></li>
                                                <li><a href="" data-calendar-view="basicDay"><i class="zmdi zmdi-view-day"></i> Visualizar por Dia</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <div id="calendar" class="card"></div>

                            </div>
                        </div>
                    </div>
                    {{-- Fim dos campos de pesquisa --}}

                    {{-- Começo da grid de pacientes --}}
                    <div class="row">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="text-left">
                                    <button type="button" disabled id="definirAtendimento" class="btn btn-success btn-sm m-t-10">Definir Atendimento</button>
                                    <button type="button" disabled id="reagendarPaciente" class="btn btn-primary btn-sm m-t-10">Reagendar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive no-padding">
                            <table id="agendados-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Cidadao</th>
                                    <th>Nº SUS</th>
                                    {{--<th>Especialidade</th>--}}
                                   {{-- <th>Dia</th>--}}
                                    <th>Hora</th>
                                   {{-- <th>Especialista</th>--}}
                                    <th>PSF</th>
                                    <th>Situação</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Cidadao</th>
                                    <th>Nº SUS</th>
                                    {{--<th>Especialidade</th>--}}
                                    {{-- <th>Dia</th>--}}
                                    <th>Hora</th>
                                    {{-- <th>Especialista</th>--}}
                                    <th>PSF</th>
                                    <th>Situação</th>
                                    <th style="width: 6%;">Acão</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    {{-- Fim da grid de pacientes --}}

                    <div id="modalCGM" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
                         aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" type="button" data-dismiss="modal">×</button>
                                    <h3 class="modal-title">Agendar Paciente</h3><br />
                                    <div class="div-hora1">
                                        <span class="hora1"></span>
                                        <span class="total-vagas1 ocultar1"></span>
                                        <span class="total-agendados1 ocultar1"></span>
                                        <span class="vagas-restantes1 ocultar1"></span><br />
                                    </div>
                                    <div class="div-hora2">
                                        <span class="hora2"></span>
                                        <span class="total-vagas2 ocultar2"></span>
                                        <span class="total-agendados2 ocultar2"></span>
                                        <span class="vagas-restantes2 ocultar2"></span><br />
                                    </div>

                                </div>
                                <form method="post" id="form_agendamento">
                                    <div class="modal-body" style="alignment-baseline: central">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <select class="form-control" name="cgm_id" id="paciente">
                                                        </select>
                                                        <input type="hidden" id="calendario" name="calendario_id">
                                                        <input type="hidden" id="data" name="data">
                                                        <input type="hidden" id="id" name="id">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <select class="form-control" name="hora" id="hora">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="obs">Observação</label>
                                                    <div class="form-group">
                                                        <textarea name="obs" id="obs" rows="4" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" disabled id="save">Salvar</button>
                                        <button class="btn btn-danger" id="delete">Deletar</button>
                                        {{--<button class="btn btn-warning" id="edit">Editar</button>--}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('agendamento.modal_definir_atendimento')
    @include('agendamento.modal_reagendamento')
@stop
@section('javascript')
    <script type="text/javascript" src="{{asset('/js/agendamento/selects_consulta_pacientes_agendados.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/calendario.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/grid_pacientes_agendados_calendario.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/loadFields_reagendamento.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/modal_reagendamento.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agendamento/modal_definir_atendimento.js')}}"></script>
    <script type="text/javascript">

        // Definindo um tipo de perfil para ser usado como validação no arquivo js
        @role('master|admin' )
              perfil = '1';
        @endrole
        @role('submaster')
              perfil = '2';
        @endrole


        // Evento para abrir o modal de telefones
        $(document).on("click", "#definirAtendimento", function () {

            // Executando o modal
            runModalDefinirAtendimento(idsPacientes);
        });

        // Evento para abrir o modal de reagendamento
        $(document).on("click", "#reagendarPaciente", function () {

            // Executando o modal de reagendamento
            runModalReagendarPacientes(especialidadeId, idsPacientes);

        });

        // Deletar paciente
        $(document).on('click', 'a.excluir', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Alerta",
                text: "Tem certeza da exclusão do item,?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim!"
            }).then(function () {

                $.ajax({
                    url: url,
                    dataType: "json",
                    type: "GET",
                    success: function (data) {
                        swal('Agendamento deletado com sucesso!', "Click no botão abaixo!", 'success');
                        table.ajax.reload();
                        //location.href = "/serbinario/calendario/index/" + idEspecialista;
                    }
                });
            });
        });

    </script>
@stop