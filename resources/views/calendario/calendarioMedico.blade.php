@extends('menu')

@section('css')
    <style type="text/css" class="init">
        .aberto {
            background-color: #caebd7;
        }

        .fechado {
            background-color: #eeb5ba;
        }

        .bloqueado {
            background-color: #f7d2a4;
        }

        .row_selected {
            background-color: #f7d2a4;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">

            </div>

            <div class="block-header">
                <h2>Agenda Médica - {{ $especialista['getCgm']['nome'] }}</h2>
            </div>

            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div role="tabpanel" class="tab">

                            <ul class="tab-nav" role="tablist">
                                <li class="active"><a href="#calendario" aria-controls="calendario" role="tab"
                                                      data-toggle="tab"
                                                      aria-expanded="true">Criação do Calendário</a></li>
                                <li role="presentation" class=""><a href="#quadro" aria-controls="quadro" role="tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Quadro do Calendário</a></li>
                            </ul>

                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane animated fadeInRight active" id="calendario">

                                    <br/>

                                    <div class="row">
                                        <div class="col-md-5 col-md-offset-1">
                                            <!-- define the calendar element -->
                                            <div class="row">
                                                <div id="my-calendar"></div>
                                            </div>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="form-group col-md-10">
                                                        <button type="button" id="save" disabled
                                                                class="btn btn-primary btn-sm m-t-10">Salvar
                                                        </button>
                                                        <button type="button" id="edit" disabled
                                                                class="btn btn-success btn-sm m-t-10">Editar
                                                        </button>
                                                        <button type="button" id="fechar" disabled
                                                                class="btn btn-danger btn-sm m-t-10">Fechar
                                                        </button>
                                                        <button type="button" id="bloquear" disabled
                                                                class="btn btn-warning btn-sm m-t-10">Bloquear
                                                        </button>
                                                        <a href="{{route('serbinario.especialista.index')}}"
                                                           class="btn btn-default btn-sm m-t-10">Voltar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <form method="post" id="form_agenda">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="form-group col-md-8">
                                                                <div class="fg-line">
                                                                    {!! Form::label('localidades', 'Unidade de Atendimento') !!}
                                                                    {!! Form::select('localidade_id', array(), array(),array('class' => 'form-control input-sm', 'id' => 'localidades')) !!}
                                                                    <input type="hidden" id="especialista_id" name="especialista_id" value="{{ $especialista['id'] }}">
                                                                </div>
                                                            </div>


                                                            <div class="form-group col-md-8">
                                                                <div class="fg-line">
                                                                    {!! Form::label('qtd_vagas', 'Quantidade de vagas') !!}
                                                                    {!! Form::text('qtd_vagas', $especialista['qtd_vagas'] , array('class' => 'form-control input-sm', 'id' => 'qtd_vagas')) !!}
                                                                </div>
                                                            </div>
                                                            <div class=" col-md-6">
                                                                <div class="fg-line">
                                                                    {!! Form::label('data', 'Data') !!}
                                                                    {!! Form::text('data', '', array('class' => 'form-control data input-sm', 'readonly' => 'readonly', 'id' => 'data')) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="fg-line">
                                                                    <div class="checkbox m-b-15">
                                                                        <label>
                                                                            <input type="checkbox" name="mais_mapa" id="mapa" value=""><i class="input-helper"></i>
                                                                            Possui mais de um mapa?
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="fg-line">
                                                                    {!! Form::label('hora', 'Hora Mapa 1') !!}
                                                                    {!! Form::text('hora', '', array('class' => 'form-control hora input-sm', 'id' => 'hora')) !!}
                                                                    <input type="hidden" id="id_mapa1" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <div class="fg-line">
                                                                    {!! Form::label('especialidade_um', 'Especialidade') !!}
                                                                    {!! Form::select('especialidade_um', array(), array(),array('class' => 'form-control input-sm', 'id' => 'especialidade_um')) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="fg-line">
                                                                    {!! Form::label('vagas_mapa1', 'Vagas Mapa 1') !!}
                                                                    {!! Form::text('vagas_mapa1', '', array('class' => 'form-control hora input-sm', 'id' => 'vagas_mapa1')) !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="fg-line">
                                                                    {!! Form::label('hora2', 'Hora Mapa 2') !!}
                                                                    {!! Form::text('hora2', '', array('class' => 'form-control hora', 'id' => 'hora2', 'readonly' => 'readonly')) !!}
                                                                    <input type="hidden" id="id_mapa2" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <div class="fg-line">
                                                                    {!! Form::label('especialidade_dois', 'Especialidade') !!}
                                                                    {!! Form::select('especialidade_dois', array(), array(),array('disabled' => 'disabled', 'class' => 'form-control input-sm', 'id' => 'especialidade_dois')) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="fg-line">
                                                                    {!! Form::label('vagas_mapa2', 'Vagas Mapa 2') !!}
                                                                    {!! Form::text('vagas_mapa2', '', array('class' => 'form-control hora input-sm', 'id' => 'vagas_mapa2', 'readonly' => 'readonly')) !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Grid dos paciente por data do calendário --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" disabled id="reagendarPaciente" class="btn btn-primary btn-sm m-t-10">Reagendar</button>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="pacientes-grid" class="display table table-bordered compact" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Paciente</th>
                                                        <th>Horário</th>
                                                        <th>Exame</th>
                                                        <th>Situação</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Paciente</th>
                                                        <th>Horário</th>
                                                        <th>Situação</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane animated fadeInRight" id="quadro">
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form role="form">

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

                                                <div class="form-group col-sm-3">
                                                    <div class=" fg-line">
                                                        <label for="especialidade-grid">Especialidade</label>
                                                        <div class="select">
                                                            {!! Form::select('especialidade-grid', array(), null, array('class' => 'form-control', 'id' => 'especialidade-grid')) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-2">
                                                    <div class=" fg-line">
                                                        <label for="status">Status</label>
                                                        <div class="select">
                                                            {!! Form::select('status', (['' => 'Selecione'] + $loadFields['status']->toArray()), null, array('class' => 'form-control', 'id' => 'status')) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <button type="submit" style="margin-top: 28px" id="search" class="btn-primary btn input-sm">Consultar</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="grid-calendario-especialista" class="table" style="width: 100%">
                                                    <thead>
                                                    <tr style="background-color: dimgrey">
                                                        <th>Data</th>
                                                        <th>Local</th>
                                                        <th>Mapas</th>
                                                        <th>Especialidades</th>
                                                        <th>Agendamentos</th>
                                                        <th>Vaga total</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td>Data</td>
                                                        <td>Local</td>
                                                        <td>Mapas</td>
                                                        <td>Especialidades</td>
                                                        <td>Agendamentos</td>
                                                        <td>Vaga total</td>
                                                        <td>Status</td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('calendario.modal_reagendamento')
    @include('calendario.modal_bloqueio')
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('/js/agenda/selects.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/operacoes.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/grid_pacientes.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/loadFields_reagendamento.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/modal_reagendamento.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/agenda/grid_calendario.js')}}"></script>

    <!-- initialize the calendar on ready -->
    <script type="application/javascript">

        // Evento para abrir o modal de telefones
        $(document).on("click", "#reagendarPaciente", function () {

            // Executando o modal
            runModalReagendarPacientes(especialidadeId, idsPacientes, especialistaNome, CRM);
        });

        $(document).ready(function () {

            idEspecialista = "{{$especialista['id']}}";

            // Carregando grid quadro do calendário so especialista
            loadTableCalendario(idEspecialista);

            //Carregando as localidades
            localidade();
            especialidadesUm("", idEspecialista);
            especialidadesSearchGrid("", idEspecialista);

            //Calendário
            $("#my-calendar").zabuto_calendar({
                cell_border: true,
                today: true,
                show_days: false,
                weekstartson: 0,
                nav_icon: {
                    prev: '<button class="btn btn-info  btn-xs waves-effect waves-circle"><i class="zmdi zmdi-arrow-back"></i> </button>',
                    next: '<button class="btn btn-info  btn-xs waves-effect waves-circle"><i class="zmdi zmdi-arrow-forward"></i> </button>'
                },
                action: function () {
                    return myDateFunction(this.id, false);
                },
                ajax: {
                    url: "{{route('serbinario.calendario.calendarios', ['id' => $especialista['id']])}}",
                }
            });

            //Pega o evento da data
            function myDateFunction(id) {

                var date = $("#" + id).data("date");
                var hasEvent = $("#" + id).data("hasEvent");
                $('.data').val(toDate(date));

                if (hasEvent) {

                    var dados = {
                        'data': date,
                        'especialista' : idEspecialista
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: '{{route('serbinario.calendario.calendariodata')}}',
                        datatype: 'json',
                        data: dados
                    }).done(function (json) {

                        // Carregando os selectes
                        localidade(json['calendario']['localidade_id']);
                        especialidadesUm(json['calendario']['mapas'][0]['especialidade_mapa']['id'], idEspecialista);

                        // Preenchendo os campos do formulário
                        $('#especialista_id').val(json['calendario']['especialista_id']);
                        $('#data').val(toDate(json['calendario']['data']));
                        $('#hora').val(json['calendario']['mapas'][0]['horario']);
                        $('#id_mapa1').val(json['calendario']['mapas'][0]['id']);
                        $('#vagas_mapa1').val(json['calendario']['mapas'][0]['vagas']);
                        json['calendario']['mais_mapa'] == '1' ? $('#mapa').prop('checked', true) : $('#mapa').attr('checked', false);
                        idCalendario = json['calendario']['id'];
                        $('#qtd_vagas').val(json['calendario']['qtd_vagas']);
                        var status = json['calendario']['status_id'];

                        runGridPacientes(idCalendario);

                        // Valida se o dia tem mais de um mapa ou não!!
                        if (json['calendario']['mais_mapa'] == '1') {

                            // Habilitando os campos do segundo mapa
                            $('#hora2').prop('readonly', false);
                            $('#vagas_mapa2').prop('readonly', false);
                            $('#especialidade_dois').prop('disabled', false);

                            // Preenchendo os campos do segundo mapa
                            $('#hora2').val(json['calendario']['mapas'][1]['horario']);
                            $('#vagas_mapa2').val(json['calendario']['mapas'][1]['vagas']);
                            $('#id_mapa2').val(json['calendario']['mapas'][1]['id']);
                            especialidadesDois(json['calendario']['mapas'][1]['especialidade_mapa']['id'], idEspecialista);

                        } else {

                            // Desabilitando os campos do segundo mapa
                            $('#hora2').prop('readonly', true);
                            $('#vagas_mapa2').prop('readonly', true);
                            $('#especialidade_dois').prop('disabled', true);

                            // Setando valores nulos no segundo mapa
                            $('#hora2').val("");
                            $('#vagas_mapa2').val("");
                            $('#id_mapa2').val("");
                            $('#especialidade_dois option').remove();
                        }


                        // Habilitando os botões do calendário e desabilitando o de salvar
                        $('#data').prop('readonly', true);
                        $('#edit').attr('disabled', false);
                        $('#fechar').attr('disabled', false);
                        $('#bloquear').attr('disabled', false);
                        $('#save').attr('disabled', true);

                        // Caso o dia do calendário tenha sido bloqueado, nenhuma ação poderá ser feita no memso
                        if(status == '3' || status == '2' || json['qtdAgendado'] > 0) {

                            // Desabilitando os botões
                            $('#save').attr('disabled', true);

                            // Desabilita apenas os botões de bloquear e fechar se caso o status for de fechado ou bloqueado
                            if(status == '3' || status == '2') {
                                $('#fechar').attr('disabled', true);
                                $('#bloquear').attr('disabled', true);
                                $('#edit').attr('disabled', true);
                            } else if (json['qtdAgendado'] > 0) {
                                $('#fechar').attr('disabled', false);
                                $('#bloquear').attr('disabled', false);
                                $('#edit').attr('disabled', true);
                            }

                            // Desabilitando os campos do formulário
                            $('#qtd_vagas').prop('readonly', true);
                            $('#hora').prop('readonly', true);
                            $('#hora2').prop('readonly', true);
                            $('#especialidade_um').prop('disabled', true);
                            $('#especialidade_dois').prop('disabled', true);
                            $('#localidades').prop('disabled', true);

                        } else {

                            // Desabilitando os campos do formulário
                            $('#qtd_vagas').prop('readonly', false);
                            $('#hora').prop('readonly', false);
                            $('#especialidade_um').prop('disabled', false);
                            $('#localidades').prop('disabled', false);

                        }

                    });
                } else {

                    localidade();
                    especialidadesUm("", idEspecialista);
                    $('#qtd_vagas').val({{$especialista['qtd_vagas']}});
                    $('#hora').val("");
                    $('#hora2').val("");
                    $('#hora2').prop('readonly', true);
                    $('#especialidade_dois').prop('disabled', true);
                    $('#especialidade_dois option').remove();
                    $('#mapa').prop('checked', false);

                    runGridPacientes(0);

                    $('#data').prop('readonly', true);
                    $('#save').attr('disabled', false);
                    $('#edit').attr('disabled', true);

                    // Desabilitando os campos do formulário
                    $('#qtd_vagas').prop('readonly', false);
                    $('#hora').prop('readonly', false);
                    $('#especialidade_um').prop('disabled', false);
                    $('#localidades').prop('disabled', false);
                }
            }

        });
    </script>
@stop
